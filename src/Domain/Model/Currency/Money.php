<?php

use Brick\Math\BigDecimal;

class Money
{
    private Currency $currency;
    private BigDecimal $amount;

    public function __construct(Currency $currency, BigDecimal $amount)
    {
        $this->currency = $currency;
        $this->amount = $amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getAmount(): BigDecimal
    {
        return $this->amount;
    }
}