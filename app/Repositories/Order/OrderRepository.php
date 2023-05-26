<?php

namespace App\Repositories\Order;

use Exception;
use App\Models\Order;
use App\Events\SuccessOrder;
use App\Http\Resources\Order\OrderResource;
use App\Http\Requests\Order\OrderDtoRequest;
use App\Repositories\Product\ProductRepository;
use App\Http\Requests\Order\OrderStatusDtoRequest;
use App\Http\Requests\Order\OrderShippingDateDtoRequest;
use App\Repositories\Order\Interface\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{

    /**
     * Constructor based dependency injection
     *
     * @param OrderRepository $repository
     *
     *
     * @return void
     */
    public function __construct(protected ProductRepository $productRepository)
    {
        $productRepository = $productRepository;

    }

    /**
     * get all records
     *
     *
     * @return object
     */
    public function findAll(){
        try{
            return Order::get();
        }catch(Exception $e){
            throw $e;
        }
    }

    /**
     * Find record by ID
     *
     * @param int $id Find the record by ID
     *
     * @return json response
     */
    public function findById(int $id){
        try{
            return Order::find($id);
        }catch(Exception $e){
            throw $e;
        }
    }

    /**
     * store order
     *
     * @param OrderDtoRequest $data
     *
     * @return boolean
     */
    public function add(OrderDtoRequest $data){
        try{
            return Order::create($data->toArray());
        }catch(Exception $e){
            throw $e;
        }
    }

    /**
     * delete order details
     *
     * @param int $id
     *
     * @return boolean
     */
    public function delete(int $id){
        if(empty($id)){
            throw new Exception;
        }

        $order = Order::find($id);
        if(empty($order)){
            throw new Exception;
        }

        try{
            $order->delete();

            $order = new OrderResource($order);

            $this->productRepository->incrementProductQuantity($order['orderDetails']->toArray());
        }catch(Exception $e){
            throw $e;
        }
    }

    /**
     * update order status with product quantity
     *
     * @param OrderDtoRequest $data
     * @param int $id
     *
     * @return boolean
     */
    public function updateStatus(OrderStatusDtoRequest $data,int $id){
        if(empty($id)){
            throw new Exception;
        }

        $order = $this->findById($id);

        if(empty($data)){
            throw new Exception;
        }
        if(empty($order)){
            throw new Exception;
        }

        try{
            $data = $data->toArray();
            //update status
           $order->update($data);

           $order_status = $data['status'];

           //to get order and its order details collection
           $order = new OrderResource($order);

           /*if($order_status == 'Ordered'){
                $this->productRepository->decrementProductQuantity($order['orderDetails']->toArray());
           }else*/
           if($order_status == 'Canceled'){
                $order->delete();
                $this->productRepository->incrementProductQuantity($order['orderDetails']->toArray());
           }

          // event(new SuccessOrder($order));
        }catch(Exception $e){
            throw $e;
        }
    }

    /**
     * update shipping date
     *
     * @param OrderDtoRequest $data
     * @param int $id
     *
     * @return boolean
     */
    public function updateShippingDate(OrderShippingDateDtoRequest $data,int $id){
        if (empty($data) || empty($id)) {
            throw new Exception;
        }

        $order = $this->findById($id);

        try{
            //update shipping date
            return  $order->update($data->toArray()); //for update() field should be fillable

          // event(new SuccessOrder($order));
        }catch(Exception $e){
            throw $e;
        }
    }


}
