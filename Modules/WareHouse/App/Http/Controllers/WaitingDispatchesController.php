<?php

namespace Modules\WareHouse\App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\Dispatch\App\Models\Dispatch;
use Modules\Dispatch\Enums\DispatchStatusEnum;
use Modules\System\Helpers\Api\ApiCrud;
use Modules\System\Helpers\StockAndAmountNormalizer;
use Modules\User\App\Helpers\AuthHelper;
use Modules\User\enums\UserTypeEnum;

class WaitingDispatchesController extends ApiCrud
{
    public function index(Request $request)
    {
        if (AuthHelper::make()->getUserType() !== UserTypeEnum::WareHouse->name) {
            return redirect()->back();
        }

        $dispatches = Dispatch::query()
                              ->where('ware_house_id', AuthHelper::make()->getUserTypeId())
                              ->with(['dispatchStatuses'])
                              ->orderBy('created_at')
                              ->get()
                              ->map(function (Dispatch $dispatch) {
                                  $lastDispatchStatus = $dispatch->dispatchStatuses->last();
                                  $dispatch->normalizedStockAndAmount = StockAndAmountNormalizer::make()->normalize(collect(json_decode($dispatch->stocks_and_amounts, 1)));
                                  if ($lastDispatchStatus->status === DispatchStatusEnum::DispatchRequest->name) {
                                      return $dispatch;
                                  }

                                  return null;
                              })
                              ->filter();

        return view('warehouse::waitingdispatches', ['dispatches' => $dispatches]);
    }

    protected function getModel(): Model
    {
        return new Dispatch();
    }
}
