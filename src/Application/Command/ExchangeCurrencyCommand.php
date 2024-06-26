<?php

declare(strict_types=1);

use Brick\Math\BigDecimal;

class ExchangeCurrencyCommand
{
    private Currency $fromCurrency;
    private Currency $toCurrency;

    public function __construct(
        string $fromCurrency,
        string $toCurrency,
        private readonly BigDecimal $amount
    ) {
        $this->fromCurrency = new Currency($fromCurrency);
        $this->toCurrency = new Currency($toCurrency);
    }

    public function getFromCurrency(): Currency
    {
        return $this->fromCurrency;
    }

    public function getToCurrency(): Currency
    {
        return $this->toCurrency;
    }

    public function getAmount(): BigDecimal
    {
        return $this->amount;
    }
}
