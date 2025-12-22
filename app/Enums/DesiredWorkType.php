<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class DesiredWorkType extends Enum
{
    const SAME_DAY = 0;
    const WITHIN_A_MONTH = 1;
    const WITHIN_2_MONTHS = 2;
    const THREE_MONTHS_OR_MORE = 3;
    const OTHER = 4;
    public static function getDescription($value): string
    {
        if ($value === null) {
            return '';
        }
        switch ($value) {
            case self::SAME_DAY:
                return '即日';
                break;
            case self::WITHIN_A_MONTH:
                return '一ヶ月以内';
                break;
            case self::WITHIN_2_MONTHS:
                return '2ヶ月以内';
                break;
            case self::THREE_MONTHS_OR_MORE:
                return '3ヶ月以上';
                break;
            case self::OTHER:
                return '検討中のため未確定';
                break;
            default:
                return '';
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
