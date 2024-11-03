<?php

declare(strict_types=1);

namespace App\Services\Calculators;

use App\Services\AbstractFeeCalculator;

final class TwelveMonthFeeCalculator extends AbstractFeeCalculator
{
    private const FEE_STRUCTURE = [
        1000 => 50,
        2000 => 90,
        3000 => 90,
        4000 => 115,
        5000 => 100,
        6000 => 120,
        7000 => 140,
        8000 => 160,
        9000 => 180,
        10000 => 200,
        11000 => 220,
        12000 => 240,
        13000 => 260,
        14000 => 280,
        15000 => 300,
        16000 => 320,
        17000 => 340,
        18000 => 360,
        19000 => 380,
        20000 => 400,
    ];

    private const TERM = 12;

    public function __construct()
    {
        parent::__construct(self::FEE_STRUCTURE);
    }

    public function supports(int $term): bool
    {
        return self::TERM === $term;
    }

    public function calculate(float $amount): float
    {
        $fee = $this->feeStructure[$amount] ?? $this->interpolateFee($amount);

        return $this->round($amount, $fee);
    }
}