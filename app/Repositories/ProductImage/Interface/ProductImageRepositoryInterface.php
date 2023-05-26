<?php

namespace App\Repositories\ProductImage\Interface;

use App\Http\Requests\ProductImage\ProductImageDtoRequest;
use App\Http\Requests\ProductImage\ProductImageDeleteDtoRequest;

interface ProductImageRepositoryInterface
{
    public function findAll(int $productNumber);

    public function findById(int $id);

    public function add(Array $request,int $id);

    public function delete(ProductImageDeleteDtoRequest $data,int $id);

}
