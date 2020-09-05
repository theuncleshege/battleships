<?php

declare(strict_types=1);

const CHR_START_NUMBER = 64;

function getLetterByIndex(int $index): string
{
    return chr(CHR_START_NUMBER + $index);
}
