<?php

use Brick\Math\BigDecimal;

class CurrencyExchangeService
{
    private ExchangeRateRepositoryInterface $exchangeRateRepository;
    private ExchangeCalculationService $calculationService;

    public function __construct(
        ExchangeRateRepositoryInterface $exchangeRateRepository,
        ExchangeCalculationService $calculationService
    ) {
        $this->exchangeRateRepository = $exchangeRateRepository;
        $this->calculationService = $calculationService;
    }

    public function exchangeCurrency(ExchangeCurrencyCommand $command): CurrencyExchangeTransaction
    {
        $exchangeRate = $this->exchangeRateRepository->findRate($command->getFromCurrency(), $command->getToCurrency());
        if ($exchangeRate === null) {
            throw new InvalidArgumentException("Exchange rate not found");
        }

        $sourceMoney = new Money($command->getFromCurrency(), $command->getAmount());
        $targetAmount = $this->calculationService->calculateTargetAmount($sourceMoney, $exchangeRate);
        $fee = $this->calculationService->calculateFee($targetAmount);

        $targetMoney = new Money($command->getToCurrency(), $targetAmount->minus($fee));
        return new CurrencyExchangeTransaction($sourceMoney, $targetMoney, $fee);
    }
}
