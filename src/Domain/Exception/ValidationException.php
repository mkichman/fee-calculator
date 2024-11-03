<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends \Exception
{
    public const VALIDATION_MESSAGE = 'Validation failed. Errors: %s';

    public function __construct(?ConstraintViolationListInterface $errors = null)
    {
        parent::__construct(sprintf(self::VALIDATION_MESSAGE, $errors));
    }
}