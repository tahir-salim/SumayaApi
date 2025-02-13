<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UserMaritalStatus extends Enum
{
    const MARITAL_STATUS_SINGLE = 'SINGLE';
    const MARITAL_STATUS_MARRIED = 'MARRIED';
    const MARITAL_STATUS_DIVORCED = 'DIVORCED';
    const MARITAL_STATUS_WIDOWED = 'WIDOWED';

    public static function GET_MARITAL_STATUSES()
    {
        return [
            static::MARITAL_STATUS_SINGLE => ucwords(strtolower(str_replace('_', ' ', static::MARITAL_STATUS_SINGLE))),
            static::MARITAL_STATUS_MARRIED => ucwords(strtolower(str_replace('_', ' ', static::MARITAL_STATUS_MARRIED))),
            static::MARITAL_STATUS_DIVORCED => ucwords(strtolower(str_replace('_', ' ', static::MARITAL_STATUS_DIVORCED))),
            static::MARITAL_STATUS_WIDOWED => ucwords(strtolower(str_replace('_', ' ', static::MARITAL_STATUS_WIDOWED))),

        ];
    }
}
