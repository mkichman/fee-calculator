<?php

declare(strict_types=1);

namespace App\Request;

use App\Domain\Interfaces\RequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CalculateFeeRequest implements RequestInterface
{
    #[Assert\Range(
        min:1000,
        max:20000
    )]
    #[Assert\NotBlank]
    private int $amount;

    #[Assert\Choice(choices:[12, 24])]
    #[Assert\NotBlank]
    private int $term;

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function getTerm(): int
    {
        return $this->term;
    }

    public function setTerm(int $term): void
    {
        $this->term = $term;
    }

}