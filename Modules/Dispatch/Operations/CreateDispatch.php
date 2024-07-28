<?php

namespace Modules\Dispatch\Operations;

use Modules\Branch\App\Models\Branch;
use Modules\Dispatch\App\Models\DispatchStatus;
use Modules\Dispatch\Enums\DispatchStatusEnum;
use Modules\WareHouse\App\Models\WareHouse;

class CreateDispatch
{
    protected array $stocksAndAmounts = [];

    protected Branch $branch;

    protected WareHouse $wareHouse;

    protected dispatchStatusEnum $dispatchStatusEnum;

    public function create(): self
    {
        $this->getBranch()->dispatches()->create([
            'ware_house_id'      => $this->getWareHouse()->getKey(),
            'stocks_and_amounts' => $this->getStocksAndAmounts(),
        ]);
        DispatchStatus::query()->create([
            'branch_id' => $this->getBranch()->getKey(),
            'status'    => $this->dispatchStatusEnum->name,
        ]);

        return $this;
    }

    public function getStocksAndAmounts(): array
    {
        return $this->stocksAndAmounts;
    }

    public function getBranch(): Branch
    {
        return $this->branch;
    }

    public function getWareHouse(): WareHouse
    {
        return $this->wareHouse;
    }

    public function setStocksAndAmounts(array $stocksAndAmounts): CreateDispatch
    {
        $this->stocksAndAmounts = $stocksAndAmounts;

        return $this;
    }

    public function setBranch(Branch $branch): CreateDispatch
    {
        $this->branch = $branch;

        return $this;
    }

    public function setWareHouse(WareHouse $wareHouse): CreateDispatch
    {
        $this->wareHouse = $wareHouse;

        return $this;
    }

    public function setDispatchStatus(DispatchStatusEnum $dispatchStatus): self
    {
        $this->dispatchStatusEnum = $dispatchStatus;

        return $this;
    }

    public static function make(): self
    {
        return app()->make(CreateDispatch::class);
    }
}
