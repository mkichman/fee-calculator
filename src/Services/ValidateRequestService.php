<?php

declare(strict_types=1);

namespace App\Services;

use App\Domain\Exception\ValidationException;
use App\Domain\Interfaces\RequestInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidateRequestService
{
    public function __construct(protected ValidatorInterface $validator)
    {
    }

    public function validate(RequestInterface $request): void
    {
        $errors = $this->validator->validate($request);

        if (\count($errors) > 0) {
            throw new ValidationException($errors);
        }
    }
}