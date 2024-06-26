<?php

declare(strict_types=1);

use Brick\Math\BigDecimal;

readonly class CurrencyExchangeTransaction
{
    public function __construct(
        private Money      $sourceMoney,
        private Money      $targetMoney,
        private BigDecimal $fee
    )
    {
    }

    public function getSourceMoney(): Money
    {
        return $this->sourceMoney;
    }

    public function getTargetMoney(): Money
    {
        return $this->targetMoney;
    }

    public function getFee(): BigDecimal
    {
        return $this->fee;
    }
}
