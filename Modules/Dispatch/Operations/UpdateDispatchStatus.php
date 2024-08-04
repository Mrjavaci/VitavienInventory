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

            return;
        }

        if ($this->getDispatchStatusEnum()->name === DispatchStatusEnum::Finished->name) {
            $this->createDispatchStatus();
            $this->finishDispatchStatus();
            /**
             * @todo Create Finish dispatch
             */
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

    public function setDispatch(Dispatch $dispatch): UpdateDispatchStatus
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

            $this->makeDispatchNotification();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new $exception;
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

    protected function finishDispatchStatus()
    {
        $this->createDispatchStatus();

        IncreaseDispatchedProducts::make()
                                  ->setDispatch($this->getDispatch())
                                  ->increase();
    }
}
