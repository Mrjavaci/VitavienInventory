<?php

namespace Modules\User\App\Helpers;

use Illuminate\Support\Facades\Auth;

class AuthHelper
{
    public static function make(): self
    {
        return app()->make(self::class);
    }

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
