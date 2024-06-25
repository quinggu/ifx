<?php

namespace tests\Application;

use Brick\Math\BigDecimal;
use Currency;
use CurrencyExchangeService;
use ExchangeCalculationService;
use ExchangeCurrencyCommand;
use ExchangeRate;
use InMemoryExchangeRateRepository;
use PHPUnit\Framework\TestCase;

final class CurrencyExchangeServiceTest extends TestCase
{
    private CurrencyExchangeService $service;

    protected function setUp(): void
    {
        $exchangeRates = [
            new ExchangeRate(new Currency('EUR'), new Currency('GBP'), BigDecimal::of('1.5678')),
            new ExchangeRate(new Currency('GBP'), new Currency('EUR'), BigDecimal::of('1.5432'))
        ];

        $repository = new InMemoryExchangeRateRepository($exchangeRates);
        $calculationService = new ExchangeCalculationService();
        $this->service = new CurrencyExchangeService($repository, $calculationService);
    }

    public function testExchangeEURToGBP(): void
    {
        $command = new ExchangeCurrencyCommand('EUR', 'GBP', BigDecimal::of('100.0'));
        $transaction = $this->service->exchangeCurrency($command);

        $this->assertEquals('GBP', $transaction->getTargetMoney()->getCurrency()->getCode());
        $this->assertEquals(BigDecimal::of('154.14'), $transaction->getTargetMoney()->getAmount()->withScale(2)); // 100 * 1.5678 - 1%
    }

    public function testExchangeGBPToEUR(): void
    {
        $command = new ExchangeCurrencyCommand('GBP', 'EUR', BigDecimal::of('100.0'));
        $transaction = $this->service->exchangeCurrency($command);

        $this->assertEquals('EUR', $transaction->getTargetMoney()->getCurrency()->getCode());
        $this->assertEquals(BigDecimal::of('152.76'), $transaction->getTargetMoney()->getAmount()->withScale(2)); // 100 * 1.5432 - 1%
    }
}
