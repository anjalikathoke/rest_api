<?php

namespace App\Repositories\Customer\Interface;

use App\Http\Requests\Customer\CustomerDtoRequest;

interface CustomerRepositoryInterface
{
    public function add(CustomerDtoRequest $data);

    public function findById(int $id);

    public function update(CustomerDtoRequest $data, int $id);

    public function delete(int $id);

   // public function myOrders(int $id);

}
