<?php

namespace App\Repositories\Product\Interface;

use App\Http\Requests\Product\ProductDtoRequest;

interface ProductRepositoryInterface
{
    public function findAll();

    public function findById(int $id);

    public function add(ProductDtoRequest $request);

    public function update(ProductDtoRequest $request,int $id);

    public function delete(int $id);

    public function generateUniqueProductCode();

    public function getDetailsForIds(array $productIds);

    public function incrementProductQuantity(array $productDetails);

    public function decrementProductQuantity(array $productDetails);

    public function getProductVistsById(int $id);

    public function getProductPrcieById(int $id);

    public function deleteProductImage(int $id);
}
