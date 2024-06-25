<?php

use Brick\Math\BigDecimal;

class ExchangeCalculationService
{
    public function calculateTargetAmount(Money $sourceMoney, ExchangeRate $exchangeRate): BigDecimal
    {
        return $sourceMoney->getAmount()->multipliedBy($exchangeRate->getRate());
    }

    public function calculateFee(BigDecimal $amount): BigDecimal
    {
        return $amount->multipliedBy(BigDecimal::of('0.01'));
    }
}