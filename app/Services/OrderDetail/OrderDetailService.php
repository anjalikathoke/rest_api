<?php

namespace App\Services\OrderDetail;

use Exception;
use App\Http\Requests\Order\OrderDtoRequest;
use App\Http\Resources\Product\ProductResource;
use App\Repositories\Product\ProductRepository;
use App\Http\Resources\OrderDetail\OrderDetailResource;
use App\Repositories\OrderDetail\OrderDetailRepository;

class OrderDetailService
{
    protected $repository, $productRepository;

    /**
     * Constructor based dependency injection
     *
     * @param OrderDetailRepository $repository
     *
     *  @param ProductRepository $productRepository
     *
     * @return void
     */
    public function __construct(OrderDetailRepository $repository, ProductRepository $productRepository)
    {
        $this->repository = $repository;
        $this->productRepository = $productRepository;
    }

     /**
     * store order details
     *
     * @param OrderDtoRequest $request
     *
     * @param array $order
     *
     * @return boolean
     */
    public function storeOrderDetails(OrderDtoRequest $request, $order)
    {
        if(empty($request->orderDetail)){
            throw new Exception;
        }

        if(!is_array($request->orderDetail)){
            throw new Exception;
        }

        //to get specific index value from given multidimentional array
        $productIds = array_column($request->orderDetail, 'productNumber');

        if(empty($productIds)){
            throw new Exception;
        }

        //to get product details for given product ids
        $products = $this->productRepository->getDetailsForIds($productIds);

        if(empty($products) ){
            throw new Exception;
        }

        foreach($request->orderDetail as $key => $details){

            $orderDetails[] = array(
                'orderNumber' => $order['orderNumber'],
                'productNumber' => $details['productNumber'],
                'productCode' => $products[$key]['productCode'],
                'quantityOrdered' => $details['quantityOrdered'],
                'priceEach' => $products[$key]['buyPrice'],
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            );
        }

        try{
            $this->repository->add($orderDetails);
        }catch(Exception $e){
            throw $e;
        }

        try{
            $this->productRepository->decrementProductQuantity($orderDetails);
        }catch(Exception $e){
            throw $e;
        }
    }
}
