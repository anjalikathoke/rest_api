<?php

namespace App\Listeners;

use Exception;
use App\Models\Product;
use App\Events\SuccessOrder;
use App\Repositories\Product\ProductRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderStatusUpdateNotification
{
    /**
     * Create the event listener.
     */
    public function __construct(protected ProductRepository $repository)
    {

    }

    /**
     * Handle the event.
     */
    public function handle(SuccessOrder $event)
    {
        /*dd($event);
        $product =  Product::find(1);
        $product->decrement('quantityInStock',1);*/
        return $this->repository->decrementProductQuantity($event['orderDetails']);

    }
}
