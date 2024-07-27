<?php

namespace Modules\Branch\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Inventory\App\Models\Inventory;

class Branch extends Model
{
    use HasFactory;

    protected $table = 'branch';

    protected $guarded = [];

    protected $with = ['inventory'];

    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'inventory_id', 'id');
    }
}
