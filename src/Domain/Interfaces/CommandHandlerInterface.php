<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
interface CommandHandlerInterface
{
}
