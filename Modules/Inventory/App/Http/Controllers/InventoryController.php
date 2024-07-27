<?php

namespace Modules\Inventory\App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Modules\Inventory\App\Models\Inventory;
use Modules\System\ApiHelpers\ApiCrud;

class InventoryController extends ApiCrud
{
    protected function getModel(): Model
    {
        return new Inventory();
    }
}
