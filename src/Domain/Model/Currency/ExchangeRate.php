<?php

use Brick\Math\BigDecimal;

class ExchangeRate
{
    private Currency $fromCurrency;
    private Currency $toCurrency;
    private BigDecimal $rate;

    public function __construct(Currency $fromCurrency, Currency $toCurrency, BigDecimal $rate)
    {
        $this->fromCurrency = $fromCurrency;
        $this->toCurrency = $toCurrency;
        $this->rate = $rate;
    }

    public function getFromCurrency(): Currency
    {
        return $this->fromCurrency;
    }

    public function getToCurrency(): Currency
    {
        return $this->toCurrency;
    }

    public function getRate(): BigDecimal
    {
        return $this->rate;
    }
}
