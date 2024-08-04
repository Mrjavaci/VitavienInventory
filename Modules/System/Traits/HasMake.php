<?php

namespace Modules\System\Traits;

trait HasMake
{
    public static function make():self
    {
        return app()->make(self::class);
    }
}
