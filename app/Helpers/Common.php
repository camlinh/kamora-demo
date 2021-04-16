<?php

namespace App\Helpers;

use App\Helpers\Constants;
use Carbon\Carbon;

class Common
{
    public static function formatDate($date, $format = Constants::DATE_FORMAT)
    {
        return $date ? Carbon::parse($date)->format($format) : '';
    }

    public static function parseDate($date, $format)
    {
        try {
            return $date ? Carbon::createFromFormat($format, $date) : null;
        } catch (\Exception $th) {
            return null;
        }
    }
}
