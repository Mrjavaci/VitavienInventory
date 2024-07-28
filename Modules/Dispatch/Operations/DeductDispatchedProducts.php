<?php

namespace Modules\Dispatch\Operations;

use Modules\Branch\App\Models\Branch;
use Modules\Inventory\App\Models\Inventory;
use Modules\WareHouse\App\Models\WareHouse;

class DeductDispatchedProducts
{
    protected Branch $branch;

    protected WareHouse $wareHouse;

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

    public function getBranch(): Branch
    {
        return $this->branch;
    }

    public function getWareHouse(): WareHouse
    {
        return $this->wareHouse;
    }

    public function getStocksAndAmounts(): array
    {
        return $this->stocksAndAmounts;
    }

    public function setBranch(Branch $branch): DeductDispatchedProducts
    {
        $this->branch = $branch;

        return $this;
    }

    public function setWareHouse(WareHouse $wareHouse): DeductDispatchedProducts
    {
        $this->wareHouse = $wareHouse;

        return $this;
    }

    public function setStocksAndAmounts(array $stocksAndAmounts): DeductDispatchedProducts
    {
        $this->stocksAndAmounts = $stocksAndAmounts;

        return $this;
    }

    public static function make(): self
    {
        return app()->make(DeductDispatchedProducts::class);
    }
}
