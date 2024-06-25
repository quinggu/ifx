<?php

interface ExchangeRateRepositoryInterface
{
    public function findRate(Currency $fromCurrency, Currency $toCurrency): ?ExchangeRate;
}
