<?php

namespace App\Traits;

trait RupiahFormatterTrait
{
    /**
     * Format an integer to Rupiah.
     *
     * @param int $value
     * @return string
     */
    public function rupiah(int $value)
    {
        return 'Rp ' . number_format($value, 0, ',', '.') . ',-';
    }
}