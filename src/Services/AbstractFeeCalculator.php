<?php

declare(strict_types=1);

namespace App\Services;

use App\Domain\Interfaces\FeeCalculator;

abstract class AbstractFeeCalculator implements FeeCalculator
{
    public function __construct(protected array $feeStructure)
    {
    }

    protected function interpolateFee(float $amount): float
    {
        $lowerAmount = 0;
        $upperAmount = 0;

        foreach ($this->feeStructure as $key => $value) {
            if ($key < $amount) {
                $lowerAmount = $key;
            } elseif ($key > $amount) {
                $upperAmount = $key;
                break;
            }
        }
        $lowerFee = $this->feeStructure[$lowerAmount];
        $upperFee = $this->feeStructure[$upperAmount];

        return $lowerFee + (($upperFee - $lowerFee) * ($amount - $lowerAmount) / ($upperAmount - $lowerAmount));
    }

    protected function round(float $amount, float $fee): float
    {
        $total = $amount + $fee;
        if ($total % 5 !== 0) {
            $fee += 5 - ($total % 5);
        }

        return ceil($fee);
    }
}