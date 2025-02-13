<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UserVerification extends Enum
{
    const STATUS_PENDING = 'PENDING';
    const STATUS_VERIFIED = 'VERIFIED';

    public static function GET_STATUSES()
    {
        return [
            static::STATUS_PENDING => ucwords(strtolower(str_replace('_', ' ', static::STATUS_PENDING))),
            static::STATUS_VERIFIED => ucwords(strtolower(str_replace('_', ' ', static::STATUS_VERIFIED))),
        ];
    }
}
