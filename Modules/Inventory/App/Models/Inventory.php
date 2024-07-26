<?php

namespace Modules\Inventory\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Stock\App\Models\Stock;

class Inventory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    protected $table = 'inventory';

    protected static function boot()
    {
        parent::boot();
        static::retrieved(function (Inventory $inventory) {
            $inventory->baseInventory = self::getBaseInventory($inventory);
        });
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'stock_id', 'id');
    }

    protected static function getBaseInventory(Inventory $inventory)
    {
        return app()->make('Modules\\'.$inventory->InventoryType.'\\App\\Models\\'.$inventory->InventoryType)::find($inventory->inventory_id);
    }
}
