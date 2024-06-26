<?php

declare(strict_types=1);

class InMemoryExchangeRateRepository implements ExchangeRateRepositoryInterface
{
    private array $exchangeRates = [];

    public function __construct(
        array $exchangeRates
    )
    {
        foreach ($exchangeRates as $rate) {
            $this->exchangeRates[$rate->getFromCurrency()->getCode() . '->' . $rate->getToCurrency()->getCode()] = $rate;
        }
    }

    public function findRate(Currency $fromCurrency, Currency $toCurrency): ?ExchangeRate
    {
        $key = $fromCurrency->getCode() . '->' . $toCurrency->getCode();

        return $this->exchangeRates[$key] ?? null;
    }
}
