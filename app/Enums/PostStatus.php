<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static DISABLED()
 * @method static static ENABLED()
 */
final class PostStatus extends Enum
{
    public const DISABLED = 0;
    public const ENABLED = 1;
}
