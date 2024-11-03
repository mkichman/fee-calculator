<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

interface FeeCalculator
{
    public function calculate(float $amount): float;
    public function supports(int $term): bool;
}
