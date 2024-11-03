<?php

declare(strict_types=1);

namespace Service;

use App\Services\Calculators\TwelveMonthFeeCalculator;
use App\Services\Calculators\TwentyFourMonthFeeCalculator;
use App\Services\FeeCalculatorContext;
use PHPUnit\Framework\TestCase;

class FeeCalculatorContextTest extends TestCase
{
    private FeeCalculatorContext $context;

    protected function setUp(): void
    {
        $this->context = new FeeCalculatorContext([
            new TwelveMonthFeeCalculator(),
            new TwentyFourMonthFeeCalculator()
        ]);
    }

    public function testCalculateFeeForTwelveMonthTerm(): void
    {
        $amount = 1000;
        $term = 12;
        $expectedFee = 50;
        $this->assertEquals($expectedFee, $this->context->calculateFee($amount, $term));
    }

    public function testCalculateFeeForTwentyFourMonthTerm(): void
    {
        $amount = 1000;
        $term = 24;
        $expectedFee = 70;
        $this->assertEquals($expectedFee, $this->context->calculateFee($amount, $term));
    }

    public function testInvalidTermThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->context->calculateFee(1000, 36);
    }
}