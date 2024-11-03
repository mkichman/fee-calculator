<?php

declare(strict_types=1);

namespace Service\Calculators;

use App\Services\Calculators\TwentyFourMonthFeeCalculator;
use PHPUnit\Framework\TestCase;

class TwentyFourMonthFeeCalculatorTest extends TestCase
{
    private TwentyFourMonthFeeCalculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new TwentyFourMonthFeeCalculator();
    }

    /**
     * @dataProvider feeCalculationProvider
     */
    public function testCalculateFee(float $amount, float $expectedFee): void
    {
        $this->assertEquals($expectedFee, $this->calculator->calculate($amount));
    }

    public function testSupports(): void
    {
        $this->assertFalse($this->calculator->supports(12));
        $this->assertTrue($this->calculator->supports(24));
    }

    public static function feeCalculationProvider(): array
    {
        return [
            'exact breakpoint 1000 PLN' => [1000, 70],
            'exact breakpoint 2000 PLN' => [2000, 100],
            'interpolated value 1500 PLN' => [1500, 85],
            'exact breakpoint 5000 PLN' => [5000, 200],
            'interpolated value 5500 PLN' => [5500, 220],
        ];
    }
}