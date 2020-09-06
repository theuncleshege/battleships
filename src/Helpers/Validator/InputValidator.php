<?php

declare(strict_types=1);

namespace App\Helpers\Validator;

final class InputValidator implements Validator
{
    public const INVALID_INPUT_GIVEN = 'Invalid input. Please try again.';

    private string $errorMessage = '';

    public function isValid(string $input): bool
    {
        if (strlen($input) !== 2) {
            $this->errorMessage = self::INVALID_INPUT_GIVEN;
            return false;
        }

        if (!ctype_alpha(substr($input, 0, 1))) {
            $this->errorMessage = self::INVALID_INPUT_GIVEN;
            return false;
        }

        if (!ctype_digit(substr($input, 1, 2))) {
            $this->errorMessage = self::INVALID_INPUT_GIVEN;
            return false;
        }

        return true;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
