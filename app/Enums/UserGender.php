<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UserGender extends Enum
{
    const MALE = 'MALE';
    const FEMALE = 'FEMALE';

    public static function GET_GENDER()
    {
        return [
            static::MALE => ucwords(strtolower(str_replace('_', ' ', static::MALE))),
            static::FEMALE => ucwords(strtolower(str_replace('_', ' ', static::FEMALE))),

        ];
    }
}
