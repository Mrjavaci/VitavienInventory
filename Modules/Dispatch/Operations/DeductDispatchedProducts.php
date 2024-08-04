<?php

namespace Modules\Dispatch\Operations;

use Modules\Dispatch\App\Models\Dispatch;
use Modules\Inventory\App\Models\Inventory;
use Modules\System\Traits\HasMake;

class DeductDispatchedProducts
{
    use HasMake;

    protected Dispatch $dispatch;

    protected array $stocksAndAmounts = [];

    /**
     * @throws \Exception
     */
    public function deduct(): \Illuminate\Support\Collection
    {
        $operationalizedInventories = collect();
        foreach ($this->getStocksAndAmounts() as $deductAmount => $id) {
            $inventory = Inventory::query()->where('id', $id)->first();
            $inventoryAmount = $inventory->amount;
            if ($inventory->amount < 0 || $inventory->amount == 0 || ($inventoryAmount - $deductAmount) < 0) {
                throw new \Exception('Inventory amount is not enough');
            }
            $inventory->amount -= $deductAmount;

            $inventory->save();
            $operationalizedInventories->push($inventory);
        }

        return $operationalizedInventories;
    }

    public function getStocksAndAmounts(): array
    {
        return $this->dispatch->getStocksAndAmounts();
    }

    public function getDispatch(): Dispatch
    {
        return $this->dispatch;
    }

    public function setDispatch(Dispatch $dispatch): DeductDispatchedProducts
    {
        $this->dispatch = $dispatch;

        return $this;
    }
}
