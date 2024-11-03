<?php

declare(strict_types=1);

namespace App\Services;

final readonly class FeeCalculatorContext
{
    public function __construct(private iterable $calculators)
    {
    }

    public function calculateFee(float $amount, int $term): float
    {
        foreach ($this->calculators as $calculator) {
            if ($calculator->supports($term)) {
                return $calculator->calculate($amount);
            }
        }

        throw new \InvalidArgumentException("No fee calculator available for term: $term months.");
    }
}