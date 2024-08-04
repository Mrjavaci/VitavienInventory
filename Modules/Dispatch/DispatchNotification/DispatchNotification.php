<?php

namespace Modules\Dispatch\DispatchNotification;

use Modules\Dispatch\App\Models\Dispatch;
use Modules\Dispatch\Enums\DispatchStatusEnum;
use Modules\Stock\App\Models\StockUnit;
use Modules\System\Helpers\StockAndAmountNormalizer;
use Modules\System\Helpers\Table\TableHelper;
use Modules\System\Traits\HasMake;
use NotificationChannels\Telegram\TelegramMessage;

class DispatchNotification
{
    use HasMake;

    protected Dispatch $dispatch;

    protected DispatchStatusEnum $dispatchStatusEnum;

    public function notify()
    {
        $this->notifyMasterGroup();

        return $this;
    }

    public function getDispatch(): Dispatch
    {
        return $this->dispatch;
    }

    public function getDispatchStatusEnum(): DispatchStatusEnum
    {
        return $this->dispatchStatusEnum;
    }

    public function setDispatch(Dispatch $dispatch): DispatchNotification
    {
        $this->dispatch = $dispatch;

        return $this;
    }

    public function setDispatchStatusEnum(DispatchStatusEnum $dispatchStatusEnum): DispatchNotification
    {
        $this->dispatchStatusEnum = $dispatchStatusEnum;

        return $this;
    }

    protected function notifyMasterGroup(): void
    {
        TelegramMessage::create()
                       ->to(config('services.telegram-bot-api.master-group-id'))
                       ->content($this->createContent())
                       ->send();
    }

    protected function createContent(): string
    {
        $dispatchStatus = $this->dispatch->dispatchStatuses()->get()->last();

        if ($this->dispatchStatusEnum->name === DispatchStatusEnum::Finished->name) {
            return $this->makeStockAndAmountsTable()."\n\n".$this->getContent($dispatchStatus);
        }

        return $this->getContent($dispatchStatus);
    }

    protected function getCreatedOrUpdated()
    {
        if ($this->dispatchStatusEnum->name === DispatchStatusEnum::DispatchRequest->name) {
            return 'requested';
        }
        if ($this->dispatchStatusEnum->name === DispatchStatusEnum::DispatchRequestApproved->name) {
            return 'approved';
        }
        if ($this->dispatchStatusEnum->name === DispatchStatusEnum::Cancelled->name) {
            return 'cancelled';
        }

        return 'updated';
    }

    protected function getContent($dispatchStatus): string
    {
        return sprintf(
            "*[Dispatch](%s) is %s
            New Status: %s
            By: %s %s*",
            route('dispatch.show', $this->dispatch->id),
            $this->getCreatedOrUpdated(),
            $this->dispatchStatusEnum->name,
            $dispatchStatus->causer_type,
            app()->make('Modules\\'.$dispatchStatus->causer_type.'\\App\\Models\\'.$dispatchStatus->causer_type)->find($dispatchStatus->causer_id)->name
        );
    }

    protected function makeStockAndAmountsTable(): string
    {
        $normalized = StockAndAmountNormalizer::make()
                                              ->normalize(collect($this->dispatch->getStocksAndAmounts()))
                                              ->map(function ($stockAndAmount) {
                                                  $stockAndAmount['stock'] = $stockAndAmount['stock']->name
                                                      .' - '.
                                                      StockUnit::query()->find($stockAndAmount['stock']->stock_unit_id)->name;

                                                  return $stockAndAmount;
                                              })->toArray();
        $forTable = [];
        foreach ($normalized as $item) {
            $forTable[] = $item;
        }

        return TableHelper::make()
                          ->setMainData($forTable)
                          ->setHeaders(['Amount', 'Stock'])
                          ->generate();
    }
}
