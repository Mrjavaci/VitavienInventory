<?php

namespace Modules\Dispatch\App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Branch\App\Models\Branch;
use Modules\System\Traits\HasDateFormat;
use Modules\WareHouse\App\Models\WareHouse;

class Dispatch extends Model
{
    use HasDateFormat;

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
    public function branch()
    {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

    public function getStocksAndAmounts()
    {
        return json_decode($this->stocks_and_amounts, true);
    }

}
