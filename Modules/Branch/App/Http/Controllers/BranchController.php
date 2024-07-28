<?php

namespace Modules\Branch\App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Modules\Branch\App\Models\Branch;
use Modules\System\Helpers\Api\ApiCrud;

class BranchController extends ApiCrud
{
    protected function getModel(): Model
    {
       return new Branch();
    }
}
