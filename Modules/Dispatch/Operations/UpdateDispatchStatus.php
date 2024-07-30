<?php

namespace Modules\Dispatch\Operations;

use Modules\Dispatch\App\Models\Dispatch;
use Modules\Dispatch\App\Models\DispatchStatus;
use Modules\Dispatch\DispatchNotification\DispatchNotification;
use Modules\Dispatch\Enums\DispatchStatusEnum;

class UpdateDispatchStatus
{
    protected Dispatch $dispatch;

    protected DispatchStatusEnum $dispatchStatusEnum;

    public function update()
    {
        $justCreateEnums = [
            DispatchStatusEnum::DispatchRequest->name,
            DispatchStatusEnum::DispatchRequestApproved->name,
            DispatchStatusEnum::Shipped->name,
            DispatchStatusEnum::OnWay->name,
            DispatchStatusEnum::Reached->name,
        ];
        if (in_array($this->dispatchStatusEnum->name, $justCreateEnums)) {
            $this->createDispatchStatus();
            DispatchNotification::make()
                                ->setDispatch($this->dispatch)
                                ->setDispatchStatusEnum($this->dispatchStatusEnum)
                                ->notify();

            return;
        }

        if ($this->getDispatchStatusEnum()->name === DispatchStatusEnum::Finished->name) {
            $this->createDispatchStatus();
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

    public static function make(): self
    {
        return app()->make(self::class);
    }

    protected function createDispatchStatus(): void
    {
        DispatchStatus::query()->create([
            'dispatch_id' => $this->getDispatch()->getKey(),
            'status'      => $this->getDispatchStatusEnum()->name,
        ]);
    }
}
