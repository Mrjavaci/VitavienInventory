<?php

namespace Modules\Dispatch\Enums;

enum DispatchStatusEnum:string
{
    case DispatchRequest = 'DispatchRequest';
    case DispatchRequestApproved = 'DispatchRequestApproved';
    case Shipped = 'Shipped';
    case OnWay = 'OnWay';
    case Reached = 'Reached';
    case Finished = 'Finished';
    case Cancelled = 'Cancelled';
}
