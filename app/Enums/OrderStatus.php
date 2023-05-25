<?php

namespace App\Enums;

enum OrderStatus:string{

    case Pending = 'Pending';
    case Ordered = 'Ordered';
    case Shipped = 'Shipped';
    case Canceled = 'Canceled';
    case Delivered = 'Delivered';
}
