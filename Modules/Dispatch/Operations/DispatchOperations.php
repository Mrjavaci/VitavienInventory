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

    protected string $error = '';

    public function startDispatch(DispatchStatusEnum $dispatchStatusEnum = DispatchStatusEnum::DispatchRequest): self
    {
        CreateDispatch::make()
                      ->setBranch($this->getBranch())
                      ->setWareHouse($this->getWareHouse())
                      ->setDispatchStatus($dispatchStatusEnum)
                      ->setStocksAndAmounts($this->getStocksAndAmounts())
                      ->create();
        try {

        DeductDispatchedProducts::make()
                                ->setBranch($this->getBranch())
                                ->setWareHouse($this->getWareHouse())
                                ->setStocksAndAmounts($this->getStocksAndAmounts())
                                ->deduct();
        }catch (\Exception $exception){
            $this->error = $exception->getMessage();
        }

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

    public function setDispatch(Dispatch $dispatch): self
    {
        $this->dispatch = $dispatch;

        return $this;
    }

    public function setStocksAndAmounts(array $stocksAndAmounts): self
    {
        $this->stocksAndAmounts = $stocksAndAmounts;

        return $this;
    }

    public function setBranch(Branch $branch): self
    {
        $this->branch = $branch;

        return $this;
    }

    public function setWareHouse(WareHouse $wareHouse): self
    {
        $this->wareHouse = $wareHouse;

        return $this;
    }

    public function getError(): string
    {
        return $this->error;
    }

    public function setError(string $error): DispatchOperations
    {
        $this->error = $error;

        return $this;
    }


    public static function make(): self
    {
        return app()->make(DispatchOperations::class);
    }
}
