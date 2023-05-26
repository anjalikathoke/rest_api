<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\OrderDetail\OrderDetailResource;

class OrderResource extends JsonResource
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
            'orderNumber' => $this->orderNumber ?? '',
            'orderDate' => $this->orderDate ?? '',
            'status' => $this->status ?? '',
            'comments' => $this->comments ?? '',
            'customerName' => $this->customer->customerName,
            'orderDetails' => (OrderDetailResource::collection($this->orderDetails)),
       ];
    }
}
