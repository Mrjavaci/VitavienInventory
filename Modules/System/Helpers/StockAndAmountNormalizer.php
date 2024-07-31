<?php

namespace Modules\System\Helpers;

use Illuminate\Support\Collection;
use Modules\Stock\App\Models\Stock;

class StockAndAmountNormalizer
{
    public function normalize(Collection $stockAndAmounts): Collection
    {
        return $stockAndAmounts->map(fn($stockId, $amount) => ['amount' => $amount, 'stock' => Stock::query()->find($stockId)]);
    }

    public static function make(): self
    {
        return app()->make(self::class);
    }
}
