<?php

namespace Modules\Dispatch\App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Traits\HasDateFormat;

class DispatchStatus extends Model
{
    use HasDateFormat;

    protected $guarded = [];

    protected $table = 'dispatch_status';
}
