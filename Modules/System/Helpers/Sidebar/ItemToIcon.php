<?php

namespace Modules\System\Helpers\Sidebar;

use Modules\User\enums\UserTypeEnum;

class ItemToIcon
{
    public static function getIcon(string|null $item): string
    {
        if ($item === UserTypeEnum::System->name) {
            return 'fas fa-home';
        }
        if ($item === UserTypeEnum::Branch->name) {
            return 'fas fa-store';
        }
        if ($item === UserTypeEnum::WareHouse->name) {
            return 'fas fa-box';
        }
        if ($item === 'Settings') {
            return 'fas fa-cog';
        }
        if ($item === 'Dispatch') {
            return 'fas fa-truck';
        }

        return 'fas fa-home';
    }
}
