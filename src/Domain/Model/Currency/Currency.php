<?php

declare(strict_types=1);

readonly class Currency
{
    public function __construct(
        private string $code
    ) {
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
