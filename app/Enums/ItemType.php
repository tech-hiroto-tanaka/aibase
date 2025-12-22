<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ItemType extends Enum
{
    const GENRE = 1;
    const AREA = 2;
    const SKILL_WORD = 3;
    const DESIRED_UNIT_PRICE = 4;
    const FEATURES = 5;
    const CONTACT_FORM = 6;
    public static function getDescription($value): string
    {
        switch ($value) {
            case self::GENRE:
                return 'ジャンル';
                break;
            case self::AREA:
                return 'エリア';
                break;
            case self::SKILL_WORD:
                return 'スキルワード';
                break;
            case self::DESIRED_UNIT_PRICE:
                return '希望単価';
                break;
            case self::FEATURES:
                return '特徴';
                break;
            case self::CONTACT_FORM:
                return '契約形態';
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
