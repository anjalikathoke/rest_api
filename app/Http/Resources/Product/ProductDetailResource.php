<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'productCode' => $this->productCode ?? '',
            'productName' => $this->productName ?? '',
            'quantityInStock' => $this->quantityInStock ?? '',
            'buyPrice' => $this->buyPrice ?? '',
            'MSRP' => $this->MSRP ?? '',
            'productDescription' => $this->productDescription ?? ''
       ];
    }
}
