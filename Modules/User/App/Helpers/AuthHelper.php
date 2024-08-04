<?php

namespace Modules\User\App\Helpers;

use Illuminate\Support\Facades\Auth;
use Modules\System\Traits\HasMake;

class AuthHelper
{
    use HasMake;

    public function isLogged(): bool
    {
        return Auth::id() !== null;
    }

    public function getUser(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        return Auth::user();
    }

    public function getUserType()
    {
        return Auth::user()->user_type;
    }
    public function getUserTypeId()
    {
        return Auth::user()->user_type_id;
    }

}
