<?php

namespace Modules\Notification\Helpers;

use Modules\Notification\App\Models\Notification;
use Modules\System\Traits\HasMake;
use Modules\User\App\Helpers\AuthHelper;

class NotificationHelper
{
    use HasMake;

    protected string $title;

    protected string $content;

    protected string $targetType;

    protected string $targetId;

    protected string $targetUrl;

    public function notify(): self
    {
        $this->createNotify();

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getTargetType(): string
    {
        return $this->targetType;
    }

    public function getTargetId(): string
    {
        return $this->targetId;
    }

    public function getTargetUrl(): string
    {
        return $this->targetUrl;
    }

    public function setTitle(string $title): NotificationHelper
    {
        $this->title = $title;

        return $this;
    }

    public function setContent(string $content): NotificationHelper
    {
        $this->content = $content;

        return $this;
    }

    public function setTargetType(string $targetType): NotificationHelper
    {
        $this->targetType = $targetType;

        return $this;
    }

    public function setTargetId(string $targetId): NotificationHelper
    {
        $this->targetId = $targetId;

        return $this;
    }

    public function setTargetUrl(string $targetUrl): NotificationHelper
    {
        $this->targetUrl = $targetUrl;

        return $this;
    }

    public static function getNotificationCount()
    {
        return Notification::query()
                           ->where('target_type', AuthHelper::make()->getUserType())
                           ->where('target_id', AuthHelper::make()->getUserTypeId())
                           ->where('seen', 0)
                           ->count();
    }

    public static function getNotifications(): \Illuminate\Database\Eloquent\Collection|array
    {
        return Notification::query()
                           ->where('target_type', AuthHelper::make()->getUserType())
                           ->where('target_id', AuthHelper::make()->getUserTypeId())
                           ->where('seen', 0)
                           ->get();
    }

    protected function createNotify(): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
    {
        return Notification::query()->create([
            'title'       => $this->getTitle(),
            'content'     => $this->getContent(),
            'target_type' => $this->getTargetType(),
            'target_id'   => $this->getTargetId(),
            'target_url'  => $this->getTargetUrl(),
        ]);
    }
}
