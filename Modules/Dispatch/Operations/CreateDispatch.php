<?php

namespace Modules\Dispatch\Operations;

use Illuminate\Database\Eloquent\Model;
use Modules\Branch\App\Models\Branch;
use Modules\Dispatch\App\Models\Dispatch;
use Modules\Dispatch\App\Models\DispatchStatus;
use Modules\Dispatch\Enums\DispatchStatusEnum;
use Modules\WareHouse\App\Models\WareHouse;

class CreateDispatch
{
    protected array $stocksAndAmounts = [];

    protected Branch $branch;

    protected WareHouse $wareHouse;

    protected dispatchStatusEnum $dispatchStatusEnum;

    protected Dispatch|Model $dispatch;

    public function create(): self
    {
        $this->dispatch = $this->getBranch()->dispatches()->create([
            'ware_house_id'      => $this->getWareHouse()->getKey(),
            'stocks_and_amounts' => collect($this->getStocksAndAmounts())->toJson(),
        ]);
        DispatchStatus::query()->create([
            'dispatch_id' => $this->dispatch->getKey(),
            'status'      => $this->dispatchStatusEnum->name,
        ]);

        return $this;
    }

    public function getDispatch(): Dispatch
    {
        return $this->dispatch;
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
