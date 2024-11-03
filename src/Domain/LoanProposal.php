<?php

declare(strict_types=1);

namespace App\Domain;

final readonly class LoanProposal
{
    public function __construct(private int $term, private float $amount, private float $fee)
    {
    }

    public function getTerm(): int
    {
        return $this->term;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getFee(): float
    {
        return $this->fee;
    }
}
