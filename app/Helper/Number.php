<?php

namespace App\Helper;

class Number
{
    public static function formatCurrency($value, $showCurrency = false, $locale = 'ca')
    {
        $localeCurrency = 'CAD';
        $decimal = '.';
        $thousand = ',';
        if ($locale == 'br') {
            $localeCurrency = 'R';
            $decimal = ',';
            $thousand = '.';
        }

        $currency = $showCurrency ? $localeCurrency : '';

        return $currency . '$ ' . number_format($value, 2, $decimal, $thousand);
    }
}