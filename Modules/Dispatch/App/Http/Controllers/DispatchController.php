<?php

namespace Modules\Dispatch\App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;
use Modules\Branch\App\Models\Branch;
use Modules\Dispatch\App\Models\Dispatch;
use Modules\Dispatch\App\Models\DispatchStatus;
use Modules\Dispatch\Enums\DispatchStatusEnum;
use Modules\Dispatch\Operations\DispatchOperations;
use Modules\Stock\App\Models\Stock;
use Modules\System\Helpers\Api\ApiCrud;
use Modules\System\Helpers\StockAndAmountNormalizer;
use Modules\User\App\Helpers\AuthHelper;
use Modules\WareHouse\App\Models\WareHouse;

class DispatchController extends ApiCrud
{
    public function approve(Request $request)
    {
        DispatchOperations::make()
                          ->setWareHouse(WareHouse::query()->where('id', AuthHelper::make()->getUserTypeId())->first())
                          ->setDispatch(Dispatch::query()->find($request->input('id')))
                          ->updateDispatch(DispatchStatusEnum::DispatchRequestApproved);
    }

    public function statusUpdate(Request $request, int $id)
    {
        $operation = DispatchOperations::make()
                                       ->setDispatch(Dispatch::query()->find($id))
                                       ->updateDispatch(DispatchStatusEnum::from($request->input('status')));
        if (! empty($operation->getError())) {
            return redirect()->route('dispatch.show',$id)->withErrors(['error' => $operation->getError()]);
        }

        return redirect()->route('dispatch.show', $id);
    }

    public function create()
    {
        return view('dispatch::create', [
            'warehouses' => WareHouse::query()->select(['id', 'name'])->with(['inventory'])->get(),
            'stocks'     => collect(Stock::query()->get()->toArray())->map(function ($stock) {
                $stock['name'] = $stock['name'].' - '.$stock['stock_unit']['name'];

                return $stock;
            }),
        ]);
    }

    /**
     * Display a listing of the resource.
     */

    protected function getModel(): Model
    {
        return new Dispatch();
    }

    public function index(Request $request)
    {
        if (AuthHelper::make()->getUserType() === 'System') {
            return view('dispatch::index', parent::index($request));
        }
        $this->overrideModelFunctions = [
            __FUNCTION__ => [
                'function' => function (Builder $model) use ($request) {
                    $query = $model->orderByDesc('id');
                    if (AuthHelper::make()->getUserType() === 'Branch') {
                        $query->where('branch_id', AuthHelper::make()->getUserTypeId());

                        return $query;
                    }
                    if (AuthHelper::make()->getUserType() === 'WareHouse') {
                        $query->where('ware_house_id', AuthHelper::make()->getUserTypeId());

                        return $query;
                    }

                    return $query;
                },
            ],
        ];
        $data = parent::index($request);

        $data->map(fn($item) => $item['lastStatus'] = DispatchStatus::query()->where('dispatch_id', $item['id'])->orderByDesc('created_at')->first()->status ?? null);

        return view('dispatch::index', [
            'data' => $data->toArray(),
        ]);
    }

    public function show(int $resourceId)
    {
        $this->overrideModelFunctions = [
            __FUNCTION__ => [
                'function' => function (Builder $query) use ($resourceId) {
                    if (AuthHelper::make()->getUserType() === 'Branch') {
                        $query->where('branch_id', AuthHelper::make()->getUserTypeId());
                    }
                    if (AuthHelper::make()->getUserType() === 'WareHouse') {
                        $query->where('ware_house_id', AuthHelper::make()->getUserTypeId());
                    }
                    $query->where('id', $resourceId);
                    $query->orderByDesc('created_at');
                    $query->with(['branch'])->without(['inventory']);

                    return $query;
                },
            ],
        ];

        $data = parent::show($resourceId);

        $data['stocksAndAmounts'] = $this->normalizeStockAndAmounts(collect(json_decode($data['stocks_and_amounts'])));

        return view('dispatch::show', [
            'inventory'           => $data,
            'dispatchStatusEnums' => DispatchStatusEnum::cases(),
        ]);
    }

    public function store(Request $request)
    {
        $stocksAndAmounts = json_decode($request->stocksAndAmounts, true);
        if (count($stocksAndAmounts) === 0) {
            return redirect()->route('dispatch.index')->with('error', 'Please select at least one stock');
        }

        $stocksAndAmounts = collect($stocksAndAmounts)
            ->mapWithKeys(fn($data) => [$data[2] => $data[0]])
            ->toArray();

        DispatchOperations::make()
                          ->setBranch(Branch::query()->where('id', AuthHelper::make()->getUserTypeId())->firstOrFail())
                          ->setWareHouse(WareHouse::query()->where('id', $request->wareHouse)->firstOrFail())
                          ->setStocksAndAmounts($stocksAndAmounts)
                          ->startDispatch();

        return redirect()->route('dispatch.index');
    }

    protected function normalizeStockAndAmounts(Collection $stockAndAmounts): Collection
    {
        return StockAndAmountNormalizer::make()->normalize($stockAndAmounts);
    }
}
