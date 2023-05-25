<?php

namespace App\Http\Resources\ProductImage;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductImageResource extends JsonResource
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
            //'id' => $this->id ?? '',
            'productNumber' => $this->productNumber ?? '',
            'image' => $this->image ?? ''
       ];
    }
}
