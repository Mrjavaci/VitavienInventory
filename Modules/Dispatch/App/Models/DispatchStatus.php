<?php

namespace Modules\Dispatch\App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Traits\HasDateFormat;

class DispatchStatus extends Model
{
    use HasDateFormat;

    protected $guarded = [];

    protected $table = 'dispatch_status';

    protected static function boot()
    {
        parent::boot();
        static::retrieved(function (DispatchStatus $dispatchStatus) {
            $dispatchStatus->causerDetails = [
                'causerType' => $dispatchStatus->causer_type,
                'causer'     => app()->make('Modules\\'.$dispatchStatus->causer_type.'\\App\\Models\\'.$dispatchStatus->causer_type)::find($dispatchStatus->causer_id),
            ];
        });
    }
}
