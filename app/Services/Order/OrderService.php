<?php

namespace App\Services\Order;

use Exception;

use App\Http\Resources\Order\OrderResource;
use App\Repositories\Order\OrderRepository;
use App\Http\Requests\Order\OrderDtoRequest;
use App\Repositories\Product\ProductRepository;
use App\Http\Requests\Order\OrderStatusDtoRequest;
use App\Http\Requests\Order\OrderShippingDateDtoRequest;

class OrderService
{
    /**
     * Constructor based dependency injection
     *
     * @param OrderRepository $repository
     *
     *
     * @return void
     */
    public function __construct(protected OrderRepository $repository, protected ProductRepository $productRepository)
    {
        $this->repository = $repository;
        $this->productRepository = $productRepository;
    }

    public function findAll()
    {
        try{
           return OrderResource::collection($this->repository->findAll());
        }catch(Exception $e){
            throw $e;
        }
    }

     /**
     * Get the order details
     *
     * @param int $id
     *
     * @return array
     */
    public function show(int $id){
        try{
            return new OrderResource(
                $this->repository->findById($id)
            );
        }catch(Exception $e){
            throw $e;
        }
    }

    /**
     * add order function
     *
     * @param OrderDtoRequest $data
     * @return array
     */
    public function add(OrderDtoRequest $data){
        $data->merge(['orderDate' => \Carbon\Carbon::now()->toDateTimeString(),'status' => 'Pending']);
        try{
            return new OrderResource(
                $this->repository->add($data)
            );

        }catch(Exception $e){
            throw $e;
        }
    }


    /**
     * delete a order
     *
     * @param int $id
     *
     * @return boolean
     */
    public function delete(int $id){

        try{
            $this->repository->delete($id);
        }catch(Exception $e){
            throw $e;
        }


    }

    /**
     * update a order status with product quantity
     *
     * @param int $id
     *
     * @return boolean
     */
    public function updateStatus(OrderStatusDtoRequest $data,int $id){
        try{
           return $this->repository->updateStatus($data,$id);
        }catch(Exception $e){
            throw $e;
        }
    }

    /**
     * update shipping date
     *
     * @param int $id
     *
     * @return boolean
     */
    public function updateShippingDate(OrderShippingDateDtoRequest $data,int $id){
        try{
           return $this->repository->updateShippingDate($data,$id);
        }catch(Exception $e){
            throw $e;
        }
    }


}
