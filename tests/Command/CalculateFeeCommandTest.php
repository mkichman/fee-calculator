<?php

declare(strict_types=1);

namespace Command;

use App\Command\CalculateFeeCommand;
use App\Domain\Exception\ValidationException;
use App\Domain\LoanProposal;
use App\Request\CalculateFeeRequest;
use App\Services\ValidateRequestService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Validator\ConstraintViolationList;

class CalculateFeeCommandTest extends TestCase
{
    private CommandTester $commandTester;
    private MessageBusInterface $commandBus;
    private ValidateRequestService $validateRequestService;

    protected function setUp(): void
    {
        $this->commandBus = $this->createMock(MessageBusInterface::class);
        $this->validateRequestService = $this->createMock(ValidateRequestService::class);

        $command = new CalculateFeeCommand($this->commandBus, $this->validateRequestService);
        $this->commandTester = new CommandTester($command);
    }

    public function testExecuteSuccessful(): void
    {
        $amount = 5000;
        $term = 12;
        $fee = 100;

        $loanProposal = new LoanProposal($term, $amount, $fee);
        $envelope = new Envelope($loanProposal, [new HandledStamp($loanProposal, 'bus_name')]);

        $this->validateRequestService
            ->expects($this->once())
            ->method('validate')
            ->with($this->isInstanceOf(CalculateFeeRequest::class));

        $this->commandBus
            ->expects($this->once())
            ->method('dispatch')
            ->willReturn($envelope);

        $this->commandTester->execute([
            'amount' => $amount,
            'term' => $term,
        ]);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString(
            sprintf('Fee successfully calculated. Term: %d, amount: %d, fee: %d', $term, $amount, $fee),
            $output
        );

        $this->assertEquals(Command::SUCCESS, $this->commandTester->getStatusCode());
    }

    public function testExecuteValidationFails(): void
    {
        $this->expectException(ValidationException::class);
        $validationErrors = $this->createMock(ConstraintViolationList::class);

        $this->validateRequestService
            ->expects($this->once())
            ->method('validate')
            ->willThrowException(new ValidationException($validationErrors));

        $this->commandTester->execute([
            'amount' => 5000,
            'term' => 12,
        ]);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Validation failed. Errors:', $output);
        $this->assertNotEquals(Command::SUCCESS, $this->commandTester->getStatusCode());
    }
}