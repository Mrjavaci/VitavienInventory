<?php

namespace Modules\Branch\App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\Branch\App\Models\Branch;
use Modules\System\Helpers\Api\ApiCrud;
use Modules\User\App\Helpers\AuthHelper;

class BranchController extends ApiCrud
{
    protected function getModel(): Model
    {
        return new Branch();
    }

    public function index(Request $request)
    {
        if (AuthHelper::make()->getUserType() === 'System') {
            return view('branch::index', parent::index($request));
        }

        return view('branch::index', $this->getBranchDataWithUserData());
    }

    protected function getBranchDataWithUserData()
    {
        $userType = AuthHelper::make()->getUserType();

        return app()
            ->make('Modules\\'.$userType.'\\App\\Models\\'.$userType)
            ->find(AuthHelper::make()->getUserTypeId())->toArray();
    }
}
