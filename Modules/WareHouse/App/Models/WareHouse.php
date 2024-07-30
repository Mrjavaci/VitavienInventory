<?php

namespace Modules\WareHouse\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Inventory\App\Models\Inventory;

class WareHouse extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'warehouse';

    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'inventory_id', 'id')->where('InventoryType', 'WareHouse');
    }
}
