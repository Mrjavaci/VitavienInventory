<?php

namespace Modules\System\Helpers\Sidebar;

use Modules\User\App\Helpers\AuthHelper;
use Modules\User\enums\UserTypeEnum;

class PermittedItems
{
    public static function get(): array|\Illuminate\Http\RedirectResponse
    {
        if (! AuthHelper::make()->isLogged()) {
            return redirect()->route('login');
        }
        if (AuthHelper::make()->getUserType() === UserTypeEnum::System->name) {
            return ['Branch', 'WareHouse', 'Settings', 'Dispatch'];
        }
        if (AuthHelper::make()->getUserType() === UserTypeEnum::Branch->name) {
            return ['Branch', 'Settings', 'Dispatch'];
        }
        if (AuthHelper::make()->getUserType() === UserTypeEnum::WareHouse->name) {
            return ['WareHouse', 'Settings', 'Dispatch'];
        }

        return [];
    }
}
