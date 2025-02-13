<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class AdStatus extends Enum
{
    const ACTIVE = 'ACTIVE';
    const DRAFT = 'DRAFT';
    const ENDED = 'ENDED';

    public static function GET_STATUSES()
    {
        return [
            static::ACTIVE => ucwords(strtolower(str_replace('_', ' ', static::ACTIVE))),
            static::DRAFT => ucwords(strtolower(str_replace('_', ' ', static::DRAFT))),
            static::ENDED => ucwords(strtolower(str_replace('_', ' ', static::ENDED))),
        ];
    }
}
