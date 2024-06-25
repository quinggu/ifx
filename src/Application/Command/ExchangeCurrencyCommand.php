<?php

use Brick\Math\BigDecimal;

class ExchangeCurrencyCommand
{
    private Currency $fromCurrency;
    private Currency $toCurrency;
    private BigDecimal $amount;

    public function __construct(string $fromCurrency, string $toCurrency, BigDecimal $amount)
    {
        $this->fromCurrency = new Currency($fromCurrency);
        $this->toCurrency = new Currency($toCurrency);
        $this->amount = $amount;
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
