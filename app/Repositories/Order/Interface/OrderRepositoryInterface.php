<?php

namespace App\Repositories\Order\Interface;

use App\Http\Requests\Order\OrderDtoRequest;
use App\Http\Requests\Order\OrderStatusDtoRequest;
use App\Http\Requests\Order\OrderShippingDateDtoRequest;

interface OrderRepositoryInterface
{
    public function findAll();

    public function findById(int $id);

    public function add(OrderDtoRequest $request);

    public function delete(int $id);

    public function updateStatus(OrderStatusDtoRequest $data,int $id);

    public function updateShippingDate(OrderShippingDateDtoRequest $data,int $id);

}
