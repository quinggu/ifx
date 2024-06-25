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

    public function add(Money $money): Money
    {
        if ($this->currency->getCode() !== $money->getCurrency()->getCode()) {
            throw new InvalidArgumentException("Different currencies");
        }

        return new Money($this->currency, $this->amount->plus($money->getAmount()));
    }

    public function subtract(Money $money): Money
    {
        if ($this->currency->getCode() !== $money->getCurrency()->getCode()) {
            throw new InvalidArgumentException("Different currencies");
        }

        return new Money($this->currency, $this->amount->minus($money->getAmount()));
    }
}