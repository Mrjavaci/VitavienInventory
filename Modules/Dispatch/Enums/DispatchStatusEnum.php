<?php

namespace Modules\Dispatch\Enums;

enum DispatchStatusEnum
{
    case DispatchRequest;
    case DispatchRequestApproved;
    case Shipped;
    case OnWay;
    case Reached;
    case Finished;
    case Cancelled;
}
