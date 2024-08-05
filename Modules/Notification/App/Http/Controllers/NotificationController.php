<?php

namespace Modules\Notification\App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\Notification\App\Models\Notification;
use Modules\System\Helpers\Api\ApiCrud;
use Modules\System\Helpers\Api\Result;

class NotificationController extends ApiCrud
{
    public function setSeen(Request $request)
    {
        try {
            Notification::query()->find($request->input('id'))->update(['seen' => true]);
        } catch (\Exception $exception) {
            return Result::exception($exception);
        }

        return Result::success('Notification Updated Successfully');
    }

    /**
     * Display a listing of the resource.
     */
    protected function getModel(): Model
    {
        return new Notification();
    }
}
