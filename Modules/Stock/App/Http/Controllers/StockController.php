<?php

namespace Modules\Stock\App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Modules\Stock\App\Models\Stock;
use Modules\System\ApiHelpers\ApiCrud;

class StockController extends ApiCrud
{
    protected function getModel(): Model
    {
        return new Stock();
    }

    public function show(int $resourceId): JsonResponse
    {
        return parent::show($resourceId);
    }
}
