<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Command\CalculateFeeCommand;
use App\Domain\Interfaces\CommandHandlerInterface;
use App\Domain\LoanProposal;
use App\Services\FeeCalculatorContext;

final readonly class CalculateFeeHandler implements CommandHandlerInterface
{
    public function __construct(private FeeCalculatorContext $calculatorContext)
    {
    }

    public function __invoke(CalculateFeeCommand $calculateFeeCommand): LoanProposal
    {
       $fee = $this->calculatorContext->calculateFee($calculateFeeCommand->amount, $calculateFeeCommand->term);

       return new LoanProposal(
           $calculateFeeCommand->term,
           $calculateFeeCommand->amount,
           $fee
       );
    }

}