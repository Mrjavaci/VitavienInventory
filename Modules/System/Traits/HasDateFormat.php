<?php

namespace Modules\System\Traits;

use Carbon\Carbon;

trait HasDateFormat
{
    protected string $defaultDateFormat = 'Y-m-d H:i:s';

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format($this->defaultDateFormat);
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format($this->defaultDateFormat);
    }
}
