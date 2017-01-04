<?php

namespace App\Helper;

class Number
{
    public static function formatCurrency($value, $locale = 'br')
    {
        return 'R$ ' . number_format($value, 2, ',', '.');
    }
}