<?php

declare(strict_types=1);

readonly class CurrencyExchangeService
{
    public function __construct(
        private ExchangeRateRepositoryInterface $exchangeRateRepository,
        private ExchangeCalculationService      $calculationService,
        private Fee                             $fee
    )
    {
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
