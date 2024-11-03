<?php

declare(strict_types=1);

namespace App\Command;

use App\Application\Command\CalculateFeeCommand as CalculateFee;
use App\Domain\Exception\ValidationException;
use App\Domain\LoanProposal;
use App\Request\CalculateFeeRequest;
use App\Services\ValidateRequestService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

#[AsCommand(name: 'app:calculate-fee', description: 'Calculate fee')]
final class CalculateFeeCommand extends Command
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
        private readonly ValidateRequestService $validateRequestService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('amount', InputArgument::REQUIRED, 'Loan amount')
            ->addArgument('term', InputArgument::REQUIRED, 'Loan term');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $calculateFeeRequest = new CalculateFeeRequest();
        $calculateFeeRequest->setAmount((int)$input->getArgument('amount'));
        $calculateFeeRequest->setTerm((int)$input->getArgument('term'));

        try {
            $this->validateRequestService->validate($calculateFeeRequest);
        } catch(ValidationException $exc) {
            $output->writeln($exc->getMessage());

            return Command::INVALID;
        }

        $result = $this->commandBus->dispatch(
            new CalculateFee(
                $calculateFeeRequest->getAmount(),
                $calculateFeeRequest->getTerm()
            )
        );

        $loanProposal = $result->last(HandledStamp::class)?->getResult();

        if($loanProposal instanceof LoanProposal) {
            $output->writeln(
                sprintf(
                    'Fee successfully calculated. Term: %d, amount: %d, fee: %d',
                    $loanProposal->getTerm(),
                    $loanProposal->getAmount(),
                    $loanProposal->getFee()
                )
            );

            return Command::SUCCESS;
        }

        return Command::FAILURE;
    }
}
