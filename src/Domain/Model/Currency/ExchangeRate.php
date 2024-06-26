<?php

declare(strict_types=1);

use Brick\Math\BigDecimal;

readonly class ExchangeRate
{
    public function __construct(
        private Currency   $fromCurrency,
        private Currency   $toCurrency,
        private BigDecimal $rate
    )
    {
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
