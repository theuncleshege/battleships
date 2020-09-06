<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers\Validator;

use App\Helpers\Validator\InputValidator;
use PHPUnit\Framework\TestCase;

final class InputValidatorTest extends TestCase
{
    public function testInputValidatorCanGetErrorMessage(): void
    {
        $validator = new InputValidator();
        self::assertEquals(
            'Invalid input. Please try again.',
            $validator->getErrorMessage(),
        );
    }

    public function testInputValidatorCanValidate(): void
    {
        $validator = new InputValidator();

        self::assertFalse($validator->isValid('A'));
        self::assertFalse($validator->isValid('A11'));
        self::assertFalse($validator->isValid('A100'));
        self::assertFalse($validator->isValid('10'));
        self::assertTrue($validator->isValid('A5'));
    }
}
