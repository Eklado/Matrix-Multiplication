<?php

namespace App\Classes\Helper;

class StringConversion
{
    public static function convertIntToExcelColumnName(int $number): string
    {
        $numeric = ($number - 1) % 26;
        $letter = chr(65 + $numeric);
        $num2 = intval(($number - 1) / 26);
        if ($num2 > 0) {
            return self::convertIntToExcelColumnName($num2) . $letter;
        } else {
            return $letter;
        }
    }
}
