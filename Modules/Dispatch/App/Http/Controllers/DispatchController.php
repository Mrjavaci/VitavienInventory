<?php

namespace Modules\Dispatch\App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\Dispatch\App\Models\Dispatch;
use Modules\System\Helpers\Api\ApiCrud;
use Modules\User\App\Helpers\AuthHelper;

class DispatchController extends ApiCrud
{
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

        $data = collect($data);

        return view('dispatch::show', [
            'inventory' => $data,
        ]);
    }
}
