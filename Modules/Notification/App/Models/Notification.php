<?php

namespace Modules\Notification\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\System\Traits\HasDateFormat;

class Notification extends Model
{
    use HasFactory;
    use HasDateFormat;

    protected $guarded = [];

    public function getGuarded(): array
    {
        return $this->guarded;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getTargetType()
    {
        return $this->target_type;
    }

    public function getTargetId()
    {
        return $this->target_id;
    }

    public function getTargetUrl()
    {
        return $this->target_url;
    }
}
