<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Interfaces\CommandInterface;

final readonly class CalculateFeeCommand implements CommandInterface
{
    public function __construct(
        public int $amount,
        public int $term
    ) {
    }

}