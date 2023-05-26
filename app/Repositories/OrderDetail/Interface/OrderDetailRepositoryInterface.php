<?php

namespace App\Repositories\OrderDetail\Interface;

use App\Http\Requests\Order\OrderDtoRequest;

interface OrderDetailRepositoryInterface
{
    public function add(array $orderDetails);

}
