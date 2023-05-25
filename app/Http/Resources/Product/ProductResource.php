<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'productCode' => $this->productCode ?? '',
            'productName' => $this->productName ?? '',
            'quantityInStock' => $this->quantityInStock ?? '',
            'buyPrice' => $this->buyPrice ?? '',
            'MSRP' => $this->MSRP ?? '',
            'productDescription' => $this->productDescription ?? '',
            'productImage' => $this->productImage ?? '',
            'created_at' => $this->created_at ?? ''
       ];
    }
}
