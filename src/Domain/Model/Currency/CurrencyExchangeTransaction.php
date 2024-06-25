<?php

use Brick\Math\BigDecimal;

class CurrencyExchangeTransaction
{
    private Money $sourceMoney;
    private Money $targetMoney;
    private BigDecimal $fee;

    public function __construct(Money $sourceMoney, Money $targetMoney, BigDecimal $fee)
    {
        $this->sourceMoney = $sourceMoney;
        $this->targetMoney = $targetMoney;
        $this->fee = $fee;
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
