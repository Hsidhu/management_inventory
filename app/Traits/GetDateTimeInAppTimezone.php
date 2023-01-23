<?php

namespace App\Traits;

use Carbon\Carbon;

trait GetDateTimeInAppTimezone {
  
    public function getCreatedAtAttribute($value)
    {
        $tz = config('app.app_timezone');
        return Carbon::createFromTimestamp(strtotime($value))->timezone($tz)->toDayDateTimeString();
    }

    public function getUpdatedAtAttribute($value)
    {
        $tz = config('app.app_timezone');
        return Carbon::createFromTimestamp(strtotime($value))->timezone($tz)->toDayDateTimeString();
    }

}
