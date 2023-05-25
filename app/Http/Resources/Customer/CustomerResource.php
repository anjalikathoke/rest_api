<?php

namespace App\Http\Resources\Customer;


use Illuminate\Http\Request;
use App\Http\Resources\Order\OrderResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'contactFirstName' => $this->contactFirstName ?? '',
            'contactLastName' => $this->contactLastName ?? '',
            'customerName' => $this->customerName ?? '',
            'phone' => $this->phone ?? '',
            'addressLine1' => $this->addressLine1 ?? '',
            'addressLine2' => $this->addressLine2 ?? '',
            'city' => $this->city ?? '',
            'state' => $this->state ?? '',
            'postalCode' => $this->postalCode ?? '',
            'country' => $this->country ?? ''
       ];
    }
}
