<?php

declare(strict_types=1);

use Brick\Math\BigDecimal;

readonly class Money
{
    public function __construct(
        private Currency   $currency,
        private BigDecimal $amount
    )
    {
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