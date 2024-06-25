<?php

use Brick\Math\BigDecimal;

class CurrencyExchangeService
{
    private ExchangeRateRepositoryInterface $exchangeRateRepository;
    private ExchangeCalculationService $calculationService;

    public function __construct(
        ExchangeRateRepositoryInterface $exchangeRateRepository,
        ExchangeCalculationService $calculationService,
        Fee $fee
    ) {
        $this->exchangeRateRepository = $exchangeRateRepository;
        $this->calculationService = $calculationService;
        $this->fee = $fee;
    }

    public function sell(ExchangeCurrencyCommand $command): CurrencyExchangeTransaction
    {
        $exchangeRate = $this->exchangeRateRepository->findRate($command->getFromCurrency(), $command->getToCurrency());
        if ($exchangeRate === null) {
            throw new InvalidArgumentException("Exchange rate not found");
        }

        $sourceMoney = new Money($command->getFromCurrency(), $command->getAmount());
        $targetAmount = $this->calculationService->calculateTargetAmount($sourceMoney, $exchangeRate);
        $fee = $this->calculationService->calculateFee($targetAmount, $this->fee);

        $targetMoney = new Money($command->getToCurrency(), $targetAmount->minus($fee));

        return new CurrencyExchangeTransaction($sourceMoney, $targetMoney, $fee);
    }

    public function buy(ExchangeCurrencyCommand $command): CurrencyExchangeTransaction
    {
        $exchangeRate = $this->exchangeRateRepository->findRate($command->getFromCurrency(), $command->getToCurrency());
        if ($exchangeRate === null) {
            throw new InvalidArgumentException("Exchange rate not found");
        }

        $fee = $this->calculationService->calculateFee($command->getAmount(), $this->fee);
        $sourceMoney = new Money($command->getFromCurrency(), $command->getAmount()->minus($fee));
        $targetAmount = $this->calculationService->calculateTargetAmount($sourceMoney, $exchangeRate);

        $targetMoney = new Money($command->getToCurrency(), $targetAmount);

        return new CurrencyExchangeTransaction($sourceMoney, $targetMoney, $fee);
    }
}
