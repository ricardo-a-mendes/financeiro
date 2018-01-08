<?php

namespace App\Helper;

class Number
{
    public static function formatCurrency($value, $locale = 'ca')
    {
        $currency = 'CAD';
        $decimal = '.';
        $thousand = ',';
        if ($locale == 'br') {
            $currency = 'R';
            $decimal = ',';
            $thousand = '.';
        }

        return $currency . '$ ' . number_format($value, 2, $decimal, $thousand);
    }
}