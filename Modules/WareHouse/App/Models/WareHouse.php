<?php

namespace Modules\WareHouse\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WareHouse extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'warehouse';
}
