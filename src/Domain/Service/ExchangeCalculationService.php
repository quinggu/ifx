<?php

declare(strict_types=1);

use Brick\Math\BigDecimal;

class ExchangeCalculationService
{
    public function calculateTargetAmount(Money $sourceMoney, ExchangeRate $exchangeRate): BigDecimal
    {
        return $sourceMoney->getAmount()->multipliedBy($exchangeRate->getRate());
    }

    public function calculateFee(BigDecimal $amount, Fee $fee): BigDecimal
    {
        return $amount->multipliedBy($fee->getValue());
    }
}