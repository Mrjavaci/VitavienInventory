<?php

namespace Modules\Dispatch\Operations;

use Modules\Dispatch\App\Models\Dispatch;
use Modules\Inventory\App\Models\Inventory;
use Modules\System\Traits\HasMake;

class IncreaseDispatchedProducts
{
    use HasMake;

    protected Dispatch $dispatch;

    protected array $stocksAndAmounts = [];

    public function increase(): \Illuminate\Support\Collection
    {
        $operationalizedInventories = collect();
        collect($this->getStocksAndAmounts())->each(function ($id, $amount) use (&$operationalizedInventories) {
            $inventory = Inventory::query()->where('id', $id)->first();
            $inventory->amount += $amount;
            $inventory->save();
            $operationalizedInventories->push($inventory);
        });

        return $operationalizedInventories;
    }

    public function getDispatch(): Dispatch
    {
        return $this->dispatch;
    }

    public function getStocksAndAmounts(): array
    {
        return $this->dispatch->getStocksAndAmounts();
    }

    public function setDispatch(Dispatch $dispatch): IncreaseDispatchedProducts
    {
        $this->dispatch = $dispatch;

        return $this;
    }
}
