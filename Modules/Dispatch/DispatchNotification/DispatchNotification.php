<?php

namespace Modules\Dispatch\DispatchNotification;

use Modules\Dispatch\App\Models\Dispatch;
use Modules\Dispatch\Enums\DispatchStatusEnum;

class DispatchNotification
{
    protected Dispatch $dispatch;

    protected DispatchStatusEnum $dispatchStatusEnum;

    public function notify()
    {

    }

    public function getDispatch(): Dispatch
    {
        return $this->dispatch;
    }

    public function setDispatch(Dispatch $dispatch): DispatchNotification
    {
        $this->dispatch = $dispatch;

        return $this;
    }

    public function getDispatchStatusEnum(): DispatchStatusEnum
    {
        return $this->dispatchStatusEnum;
    }

    public function setDispatchStatusEnum(DispatchStatusEnum $dispatchStatusEnum): DispatchNotification
    {
        $this->dispatchStatusEnum = $dispatchStatusEnum;

        return $this;
    }

    public static function make(): self
    {
        return app()->make(self::class);
    }
}
