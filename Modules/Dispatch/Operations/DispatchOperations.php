<?php

namespace Modules\Dispatch\Operations;

use Modules\Branch\App\Models\Branch;
use Modules\Dispatch\App\Models\Dispatch;
use Modules\Dispatch\Enums\DispatchStatusEnum;
use Modules\WareHouse\App\Models\WareHouse;

class DispatchOperations
{
    protected array $stocksAndAmounts = [];

    protected Branch $branch;

    protected WareHouse $wareHouse;

    protected Dispatch $dispatch;

    public function startDispatch(DispatchStatusEnum $dispatchStatusEnum): self
    {
        CreateDispatch::make()
                      ->setBranch($this->getBranch())
                      ->setWareHouse($this->getWareHouse())
                      ->setDispatchStatus($dispatchStatusEnum)
                      ->create();

        DeductDispatchedProducts::make()
                                ->setBranch($this->getBranch())
                                ->setWareHouse($this->getWareHouse())
                                ->setStocksAndAmounts($this->getStocksAndAmounts())
                                ->deduct();

        return $this;
    }

    public function updateDispatch(DispatchStatusEnum $dispatchStatusEnum): self
    {
        UpdateDispatchStatus::make()
                            ->setDispatch($this->getDispatch())
                            ->setDispatchStatusEnum($dispatchStatusEnum)
                            ->update();

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

    public function setDispatch(Dispatch $dispatch): DispatchOperations
    {
        $this->dispatch = $dispatch;

        return $this;
    }

    public function setStocksAndAmounts(array $stocksAndAmounts): DispatchOperations
    {
        $this->stocksAndAmounts = $stocksAndAmounts;

        return $this;
    }

    public function setBranch(Branch $branch): DispatchOperations
    {
        $this->branch = $branch;

        return $this;
    }

    public function setWareHouse(WareHouse $wareHouse): DispatchOperations
    {
        $this->wareHouse = $wareHouse;

        return $this;
    }

    public static function make(): self
    {
        return app()->make(DispatchOperations::class);
    }
}
