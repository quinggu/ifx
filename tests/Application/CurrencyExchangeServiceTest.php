<?php

declare(strict_types=1);

namespace tests\Application;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Currency;
use CurrencyExchangeService;
use ExchangeCalculationService;
use ExchangeCurrencyCommand;
use ExchangeRate;
use Fee;
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

        $fee = new Fee('0.01');
        $repository = new InMemoryExchangeRateRepository($exchangeRates);
        $calculationService = new ExchangeCalculationService();
        $this->service = new CurrencyExchangeService($repository, $calculationService, $fee);
    }

    public function testSellEURToGBP(): void
    {
        $command = new ExchangeCurrencyCommand('EUR', 'GBP', BigDecimal::of('100.00'));
        $transaction = $this->service->sell($command);

        $this->assertEquals('GBP', $transaction->getTargetMoney()->getCurrency()->getCode());
        $this->assertEquals(BigDecimal::of('155.21'), $transaction->getTargetMoney()->getAmount()->toScale(2, RoundingMode::HALF_UP));
    }

    public function testSellGBPToEUR(): void
    {
        $command = new ExchangeCurrencyCommand('GBP', 'EUR', BigDecimal::of('100.0'));
        $transaction = $this->service->sell($command);

        $this->assertEquals('EUR', $transaction->getTargetMoney()->getCurrency()->getCode());
        $this->assertEquals(BigDecimal::of('152.78'), $transaction->getTargetMoney()->getAmount()->toScale(2, RoundingMode::HALF_UP));
    }

    public function testBuyGBPFromEUR(): void
    {
        $command = new ExchangeCurrencyCommand('EUR', 'GBP', BigDecimal::of('100.00'));
        $transaction = $this->service->buy($command);

        $this->assertEquals('GBP', $transaction->getTargetMoney()->getCurrency()->getCode());
        $this->assertEquals(BigDecimal::of('155.21'), $transaction->getTargetMoney()->getAmount()->toScale(2, RoundingMode::HALF_UP));
    }

    public function testBuyEURFromGBP(): void
    {
        $command = new ExchangeCurrencyCommand('GBP', 'EUR', BigDecimal::of('100.0'));
        $transaction = $this->service->buy($command);

        $this->assertEquals('EUR', $transaction->getTargetMoney()->getCurrency()->getCode());
        $this->assertEquals(BigDecimal::of('152.78'), $transaction->getTargetMoney()->getAmount()->toScale(2, RoundingMode::HALF_UP));
    }
}
