<?php

namespace Modules\Dispatch\App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\WareHouse\App\Models\WareHouse;

class Dispatch extends Model
{
    protected $guarded = [];

    protected $table = 'dispatch';

    protected $with = ['dispatchStatuses', 'wareHouse'];

    public function dispatchStatuses()
    {
        return $this->hasMany(DispatchStatus::class, 'dispatch_id', 'id');
    }

    public function wareHouse()
    {
        return $this->hasOne(WareHouse::class, 'id', 'ware_house_id');
    }
}
