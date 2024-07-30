<?php

namespace Tests\Unit;

use Modules\Branch\App\Models\Branch;
use Modules\Dispatch\App\Models\Dispatch;
use Modules\Dispatch\Enums\DispatchStatusEnum;
use Modules\Dispatch\Operations\DispatchOperations;
use Modules\Stock\App\Models\Stock;
use Modules\User\App\Helpers\AuthHelper;
use Modules\WareHouse\App\Models\WareHouse;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        $op = DispatchOperations::make()
                                ->setBranch(Branch::query()->find(AuthHelper::make()->getUserTypeId())->first())
                                ->setWareHouse(WareHouse::query()->find(1)->first())
                                ->setStocksAndAmounts([
                                    10 => Stock::query()->first()->id,
                                ])->startDispatch();

        if (empty($op->getError())) {
            dd($op->getError());
        }
        DispatchOperations::make()
                          ->setDispatch(Dispatch::query()->first())
                          ->updateDispatch(DispatchStatusEnum::DispatchRequestApproved);

        $this->assertTrue(true);
    }
}
