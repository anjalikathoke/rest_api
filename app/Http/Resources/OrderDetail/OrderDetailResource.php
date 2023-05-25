<?php

namespace App\Http\Resources\OrderDetail;

use Illuminate\Http\Request;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       // return parent::toArray($request);
       return [
            'productNumber' => $this->productNumber ?? '',
            'productCode' => $this->productCode ?? '',
            'productName' => $this->products->productName,
            'quantityOrdered' => $this->quantityOrdered ?? '',
            'priceEach' => $this->priceEach ?? ''
       ];
    }
}
