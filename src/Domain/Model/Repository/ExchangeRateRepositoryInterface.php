<?php

declare(strict_types=1);

interface ExchangeRateRepositoryInterface
{
    public function findRate(Currency $fromCurrency, Currency $toCurrency): ?ExchangeRate;
}
