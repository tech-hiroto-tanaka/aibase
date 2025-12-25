<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OperationType extends Enum
{
    const INSERT = 1;
    const UPDATE = 2;
    const DELETE = 3;
    const LOGIN = 4;
    const LOGOUT = 5;
    const OTHER = 9;

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::INSERT:
                return '登録';
            case self::UPDATE:
                return '更新';
            case self::DELETE:
                return '削除';
            case self::LOGIN:
                return 'ログイン';
            case self::LOGOUT:
                return 'ログアウト';
            default:
                return 'その他';
        }
    }
}
