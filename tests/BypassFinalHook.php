<?php

// phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter

declare(strict_types=1);

namespace Tests;

use DG\BypassFinals;
use PHPUnit\Runner\BeforeTestHook;

final class BypassFinalHook implements BeforeTestHook
{
    public function executeBeforeTest(string $test): void
    {
        BypassFinals::enable();
    }
}
