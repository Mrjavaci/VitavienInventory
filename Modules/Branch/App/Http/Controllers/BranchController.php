<?php

namespace Modules\Branch\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Branch\App\Models\Branch;
use Modules\System\ApiHelpers\ApiCrud;

class BranchController extends ApiCrud
{
    protected function getModel(): Model
    {
       return new Branch();
    }
}
