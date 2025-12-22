<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class RoleType extends Enum
{
    const SYSTEM_ADMIN = 1;
    const COMPANY_ADMIN = 2;
    const USER = 3;
    public static function getDescription($value): string
    {
        switch ($value) {
            case self::SYSTEM_ADMIN:
                return 'システム管理者';
                break;

            case self::COMPANY_ADMIN:
                return '企業管理者';
                break;

            case self::USER:
                return 'ユーザー';
                break;

            default:
                return "";
                break;
        }
    }
    public static function parseArray()
    {
        $arrs = [];
        foreach (self::getValues() as $value) {
            $arrs[$value] = self::getDescription($value);
        }
        return $arrs;
    }
}
