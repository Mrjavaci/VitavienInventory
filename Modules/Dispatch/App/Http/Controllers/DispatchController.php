<?php

namespace Modules\Dispatch\App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Modules\Dispatch\App\Models\Dispatch;
use Modules\Dispatch\App\Models\DispatchStatus;
use Modules\Stock\App\Models\Stock;
use Modules\System\Helpers\Api\ApiCrud;
use Modules\User\App\Helpers\AuthHelper;
use Modules\WareHouse\App\Models\WareHouse;

class DispatchController extends ApiCrud
{
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
                    $query->where('branch_id', AuthHelper::make()->getUserTypeId());

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
                    $query->where('branch_id', AuthHelper::make()->getUserTypeId());
                    $query->where('id', $resourceId);
                    $query->orderByDesc('created_at');

                    return $query;
                },
            ],
        ];

        $data = parent::show($resourceId);
        $data['stocksAndAmounts'] = $this->normalizeStockAndAmounts(collect(json_decode($data['stocks_and_amounts'])));

        return view('dispatch::show', [
            'inventory' => $data,
        ]);
    }

    protected function normalizeStockAndAmounts(Collection $stockAndAmounts): Collection
    {
        return $stockAndAmounts->map(fn($stockId, $amount) => ['amount' => $amount, 'stock' => Stock::query()->find($stockId)]);
    }
}
