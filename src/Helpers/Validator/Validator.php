<?php

declare(strict_types=1);

namespace App\Helpers\Validator;

interface Validator
{
    public function isValid(string $value): bool;

    public function getErrorMessage(): string;
}
