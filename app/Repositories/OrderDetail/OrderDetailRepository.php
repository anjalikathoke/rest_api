<?php

namespace App\Repositories\OrderDetail;

use Exception;
use App\Models\OrderDetail;
use App\Repositories\OrderDetail\Interface\OrderDetailRepositoryInterface;



class OrderDetailRepository implements OrderDetailRepositoryInterface
{
     /**
     * store order details
     *
     * @param array $orderDetails to be store
     *
     * @return boolean
     */
    public function add(array $orderDetails){
        try{
            return OrderDetail::insert($orderDetails);
        }catch(Exception $e){
            throw $e;
        }
    }
}
