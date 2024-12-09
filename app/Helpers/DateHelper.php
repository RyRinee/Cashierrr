<?php

namespace App\Helpers;

class DateHelper
{
    public static function dmy($date, $toDmy = true)
    {
        if (!$date) {
            return null;
        }

        try {
            if ($toDmy) {
                return \Carbon\Carbon::parse($date)->format('d-m-Y');
            } else {
                return \Carbon\Carbon::createFromFormat('d-m-Y', $date)->toDateString();
            }
        } catch (\Exception $e) {
            return null; // Handle error jika tanggal tidak valid
        }
    }
}
