<?php

namespace Modules\WareHouse\App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Helpers\Api\ApiCrud;
use Modules\WareHouse\App\Models\WareHouse;

class WareHouseController extends ApiCrud
{
    protected function getModel(): Model
    {
        return new WareHouse();
    }
}
