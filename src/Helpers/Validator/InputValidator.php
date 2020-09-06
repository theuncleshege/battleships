<?php

declare(strict_types=1);

namespace App\Helpers\Validator;

final class InputValidator implements Validator
{
    private string $errorMessage = 'Invalid input. Please try again.';

    public function isValid(string $input): bool
    {
        if (strlen($input) < 2 || strlen($input) > 3) {
            return false;
        }

        if (!ctype_alpha(substr($input, 0, 1))) {
            return false;
        }

        if (!ctype_digit(substr($input, 1, 2))) {
            return false;
        }

        $this->errorMessage = '';
        return true;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
