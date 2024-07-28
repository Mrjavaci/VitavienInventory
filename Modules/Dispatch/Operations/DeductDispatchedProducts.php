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

    public function deduct(): \Illuminate\Support\Collection
    {
        $operationalizedInventories = collect();
        foreach ($this->getStocksAndAmounts() as $stockAndAmount) {
            $inventories = Inventory::query()
                                    ->where('InventoryType', 'WareHouse')
                                    ->where('inventory_id', $this->getWareHouse()->getKey())
                                    ->get();

            collect($stockAndAmount)->each(fn($amount, $stock) => $inventories->each(function ($inventory) use ($stock, $amount, $operationalizedInventories) {
                if ($inventory->stock === $stock) {
                    $inventory->update([
                        'amount' => $inventory->amount - $amount,
                    ]);
                    $operationalizedInventories->push($inventory);
                }
            }));
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
