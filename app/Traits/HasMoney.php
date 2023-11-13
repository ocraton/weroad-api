<?php

namespace App\Traits;

trait HasMoney
{
    public function saveMoneyToDatabase($value): ?int
    {
        if (is_string($value)) {
            $currency = str_replace('.', '', $value);
            $currency = str_replace(',', '.', $currency);

            return intval(floatval($currency) * 100);
        }

        return $value != 0 ? $value * 100 : null;
    }

    public function getMoneyFromDatabase($value): ?string
    {
        return $value != null ? number_format($value / 100, 2, ',', '') : null;
    }
}
