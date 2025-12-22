<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ContactType extends Enum
{
    const NEW_CONTACT = 0;
    const UNDER_SUPPORT = 1;
    const SUPPORTED = 2;
    const NOT_ACTION_REQUIRED = 3;
    public static function getDescription($value): string
    {
        switch ($value) {
            case self::NEW_CONTACT:
                return '新規 ( 未対応）';
                break;
            case self::UNDER_SUPPORT:
                return '対応中';
                break;
            case self::SUPPORTED:
                return '対応済';
                break;
            case self::NOT_ACTION_REQUIRED:
                return '対応必要無し';
                break;
            default:
                return "";
                break;
        }
    }

    public static function parseArray()
    {
        $data = [];
        foreach (self::getValues() as $value) {
            $data[] = ['label' => self::getDescription($value), 'id' => $value];
        }
        return $data;
    }
}
