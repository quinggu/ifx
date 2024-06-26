<?php

declare(strict_types=1);

use Brick\Math\BigDecimal;

class Fee
{
    private BigDecimal $value;

    public function __construct(
        string $value
    )
    {
        $this->value = BigDecimal::of($value);
    }

    public function getValue(): BigDecimal
    {
        return $this->value;
    }
}