<?php

namespace Modules\Dispatch\Enums;

enum DispatchStatusEnum
{
    case DispatchRequest;
    case Shipped;
    case OnWay;
    case Reached;
    case Finished;
    case Cancelled;
}
