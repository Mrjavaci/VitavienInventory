<?php

namespace Modules\Stock\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $with = ['stockUnit'];

    protected $guarded = [];

    protected $table = 'stock';



    public function stockUnit()
    {
        return $this->belongsTo(StockUnit::class, 'stock_unit_id');
    }
}
