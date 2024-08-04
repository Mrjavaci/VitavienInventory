<?php

namespace Modules\System\Helpers;

use Illuminate\Support\Collection;
use Modules\Stock\App\Models\Stock;
use Modules\System\Traits\HasMake;

class StockAndAmountNormalizer
{
    use HasMake;

    public function normalize(Collection $stockAndAmounts): Collection
    {
        return $stockAndAmounts->map(fn($stockId, $amount) => ['amount' => $amount, 'stock' => Stock::query()->find($stockId)]);
    }
}
