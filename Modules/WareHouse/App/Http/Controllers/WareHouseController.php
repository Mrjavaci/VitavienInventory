<?php

namespace Modules\WareHouse\App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\System\Helpers\Api\ApiCrud;
use Modules\User\App\Helpers\AuthHelper;
use Modules\WareHouse\App\Models\WareHouse;

class WareHouseController extends ApiCrud
{
    protected function getModel(): Model
    {
        return new WareHouse();
    }

    public function index(Request $request)
    {
        $data = WareHouse::query()
                         ->where('id',AuthHelper::make()->getUserTypeId())
                         ->with(['inventory'])
                         ->get();

        return view('warehouse::index', ['data' => $data->first()->toArray()]);
    }
}
