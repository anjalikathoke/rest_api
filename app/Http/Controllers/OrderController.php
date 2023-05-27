<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\Order\OrderService;
use App\Http\Requests\Order\OrderDtoRequest;
use App\Services\OrderDetail\OrderDetailService;
use App\Http\Requests\Order\OrderStatusDtoRequest;
use App\Http\Requests\Order\OrderShippingDateDtoRequest;

class OrderController extends Controller
{
    /**
     * Constructor based dependency injection
     *
     * @param OrderService $service
     *
     * @param OrderDetailService $orderDetailService
     *
     * @return void
     */
    public function __construct(Protected OrderService $service, protected OrderDetailService $orderDetailService)
    {

    }

    /**
     * Display a order listing of the resource.
     */
    public function index()
    {
        $status = 'success';
        $data = Null;

        try{
            $data = $this->service->findAll();
        }catch(Exception $e){
            throw $e;
        }

        $result = array('status' => $status,'data'=>$data);
        return response()->json($result);
    }

    /**
     * Display the specified order details.
     * @param int $id
     */
    public function show(int $id)
    {
        $status = 'success';
        $data = Null;

        try{
            return $this->service->show($id);
        }catch(Exception $e){
            throw $e;
        }

        $result = array('status' => $status,'data'=>$data);
        return response()->json($result);
    }

    /**
     * Store a newly created order and order details resource in storage.
     */
    public function store(OrderDtoRequest $request)
    {
        //dd($request);
        $status = 'success';
        $data = Null;

        DB::beginTransaction();
        try{
            $order = $this->service->add(
                data:$request
            );
           $data = $this->orderDetailService->storeOrderDetails($request,$order);
           DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            throw $e;
        }

        $result = array('status' => $status,'data'=>$data);
        return response()->json($result);
    }

    /**
     * Delete the specified resource from storage.
     * @param int $id
     * @return array
     */
    public function destroy(int $id)
    {
        $status = 'success';
        $data = Null;

        DB::beginTransaction();
        try{
            $data = $this->service->delete($id);
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            throw $e;
        }

        $result = array('status' => $status,'data'=>$data);
        return response()->json($result);
    }

    /**
     * update order status with product quantity for the specified
     * @param int $id
     * @return array
     */
    public function update_status(OrderStatusDtoRequest $request,int $id)
    {
        $this->authorize('create-delete-products');

        $status = 'success';
        $data = Null;

        DB::beginTransaction();
        try{
            $data = $this->service->updateStatus(data:$request, id:$id);
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            throw $e;
        }

        $result = array('status' => $status,'data'=>$data);
        return response()->json($result);
    }

    /**
     * update order status with product quantity for the specified
     * @param int $id
     * @return array
     */
    public function update_shipping_date(OrderShippingDateDtoRequest $request,int $id)
    {
        $this->authorize('create-delete-products');

        $status = 'success';
        $data = Null;

        try{
            $data = $this->service->updateShippingDate(data:$request, id:$id);
        }catch(Exception $e){
            throw $e;
        }

        $result = array('status' => $status,'data'=>$data);
        return response()->json($result);
    }


}
