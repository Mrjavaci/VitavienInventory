<?php

namespace Modules\Branch\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Dispatch\App\Models\Dispatch;
use Modules\Inventory\App\Models\Inventory;
use Modules\System\Traits\HasDateFormat;

class Branch extends Model
{
    use HasDateFormat;

    protected $table = 'branch';

    protected $guarded = [];

    protected $with = ['inventory'];

    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'inventory_id', 'id');
    }

    public function dispatches()
    {
        return $this->hasMany(Dispatch::class, 'branch_id', 'id');
    }
}
