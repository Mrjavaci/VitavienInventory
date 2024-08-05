<?php

namespace Modules\Dispatch\Operations;

use Illuminate\Support\Facades\DB;
use Modules\Dispatch\App\Models\Dispatch;
use Modules\Dispatch\App\Models\DispatchStatus;
use Modules\Dispatch\DispatchNotification\DispatchNotification;
use Modules\Dispatch\Enums\DispatchStatusEnum;
use Modules\System\Traits\HasMake;
use Modules\User\App\Helpers\AuthHelper;

class UpdateDispatchStatus
{
    use HasMake;

    protected Dispatch $dispatch;

    protected DispatchStatusEnum $dispatchStatusEnum;

    /**
     * @throws \Exception
     */
    public function update(): void
    {
        $this->checkOrder();

        $this->checkAlreadyUpdated();

        $justCreateEnums = [
            DispatchStatusEnum::DispatchRequest->name,
            DispatchStatusEnum::Shipped->name,
            DispatchStatusEnum::OnWay->name,
            DispatchStatusEnum::Reached->name,
        ];
        if (in_array($this->dispatchStatusEnum->name, $justCreateEnums)) {
            $this->dispatchJustCreate();

            return;
        }

        if ($this->getDispatchStatusEnum()->name === DispatchStatusEnum::DispatchRequestApproved->name) {
            $this->dispatchRequestApproved();
            $this->makeDispatchNotification();

            return;
        }

        if ($this->getDispatchStatusEnum()->name === DispatchStatusEnum::Finished->name) {
            DB::beginTransaction();
            try {
                $this->createDispatchStatus();
                $this->finishDispatchStatus();
                $this->makeFinishDispatchNotification();
            } catch (\Exception $exception) {
                DB::rollBack();
                dd($exception->getMessage());
            }
            DB::commit();
        }
        if ($this->getDispatchStatusEnum()->name === DispatchStatusEnum::Cancelled->name) {
            $this->createDispatchStatus();
            /**
             * @todo Create Cancelled dispatch
             */
        }
    }

    public function getDispatch(): Dispatch
    {
        return $this->dispatch;
    }

    public function getDispatchStatusEnum(): DispatchStatusEnum
    {
        return $this->dispatchStatusEnum;
    }

    public function setDispatch(Dispatch $dispatch): self
    {
        $this->dispatch = $dispatch;

        return $this;
    }

    public function setDispatchStatusEnum(DispatchStatusEnum $dispatchStatusEnum): UpdateDispatchStatus
    {
        $this->dispatchStatusEnum = $dispatchStatusEnum;

        return $this;
    }

    protected function createDispatchStatus(): void
    {
        DispatchStatus::query()->create([
            'dispatch_id' => $this->getDispatch()->getKey(),
            'status'      => $this->getDispatchStatusEnum()->name,
            'causer_type' => AuthHelper::make()->getUserType(),
            'causer_id'   => AuthHelper::make()->getUserTypeId(),
        ]);
    }

    protected function dispatchRequestApproved(): void
    {
        DB::beginTransaction();
        try {
            $this->createDispatchStatus();

            DeductDispatchedProducts::make()
                                    ->setDispatch($this->getDispatch())
                                    ->deduct();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
    }

    protected function dispatchJustCreate(): void
    {
        $this->createDispatchStatus();

        $this->makeDispatchNotification();
    }

    protected function makeDispatchNotification(): void
    {
        DispatchNotification::make()
                            ->setDispatch($this->dispatch)
                            ->setDispatchStatusEnum($this->dispatchStatusEnum)
                            ->notify();
    }

    protected function finishDispatchStatus(): self
    {
        IncreaseDispatchedProducts::make()
                                  ->setDispatch($this->getDispatch())
                                  ->increase();

        return $this;
    }

    protected function makeFinishDispatchNotification()
    {
        DispatchNotification::make()
                            ->setDispatch($this->dispatch)
                            ->setDispatchStatusEnum($this->dispatchStatusEnum)
                            ->notify();
    }

    protected function checkAlreadyUpdated(): void
    {
        if ($this->getDispatch()->dispatchStatuses()->get()->last()->status === $this->getDispatchStatusEnum()->name) {
            throw new \Exception('Dispatch status is already updated');
        }
    }

    protected function checkOrder()
    {
        $allStatutes = collect(DispatchStatusEnum::cases())->map(fn($item) => $item->name);
        $searchCurrent = $allStatutes->search($this->dispatchStatusEnum->name);
        $searchLast = $allStatutes->search($this->getDispatch()->dispatchStatuses()->get()->last()->status);

        if ($searchCurrent < $searchLast) {
            throw new \Exception('Dispatch status is not valid');
        }
    }
}
