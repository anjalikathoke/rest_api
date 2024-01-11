<?php

namespace App\Listeners;

use Exception;
use App\Events\SuccessOrder;
use App\Repositories\Product\ProductRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderStatusUpdateNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     */
    public function handle(SuccessOrder $event)
    {
        $productRepository = new ProductRepository();
        $productRepository->decrementProductQuantity($event['orderDetails']);
    }
}
