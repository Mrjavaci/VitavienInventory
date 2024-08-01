<?php

namespace Modules\Dispatch\Operations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Branch\App\Models\Branch;
use Modules\Dispatch\App\Models\Dispatch;
use Modules\Dispatch\DispatchNotification\DispatchNotification;
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
        DB::beginTransaction();

        $createDispatch = CreateDispatch::make()
                                        ->setBranch($this->getBranch())
                                        ->setWareHouse($this->getWareHouse())
                                        ->setDispatchStatus($dispatchStatusEnum)
                                        ->setStocksAndAmounts($this->getStocksAndAmounts())
                                        ->create();
        try {
            DispatchNotification::make()
                                ->setDispatch($createDispatch->getDispatch())
                                ->setDispatchStatusEnum($dispatchStatusEnum)
                                ->notify();
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->error = $exception->getMessage();
        }
        DB::commit();

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

    public function getError(): string
    {
        return $this->error;
    }

    public function setDispatch(Dispatch|Model $dispatch): self
    {
        $this->dispatch = $dispatch;

        return $this;
    }

    public function setStocksAndAmounts(array $stocksAndAmounts): self
    {
        $this->stocksAndAmounts = $stocksAndAmounts;

        return $this;
    }

    public function setBranch(Branch|Model $branch): self
    {
        $this->branch = $branch;

        return $this;
    }

    public function setWareHouse(WareHouse|Model $wareHouse): self
    {
        $this->wareHouse = $wareHouse;

        return $this;
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
