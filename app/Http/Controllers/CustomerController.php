<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\Customer;
use Illuminate\Http\Response;
use App\Services\Customer\CustomerService;
use App\Http\Requests\Customer\CustomerDtoRequest;

class CustomerController extends Controller
{

    /**
     * Constructor based dependency injection
     *
     * @param CustomerService $service
     *
     * @return void
     */
    public function __construct(protected CustomerService $service)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::whereStatus('active')->get();
        return response()->json(['status'=>'success','data' => $customers]);
    }


    /**
     * Store a newly created resource in storage.
     * @param CustomerDtoRequest $data
     */
    public function store(CustomerDtoRequest $request)
    {

        $data = null;
        $status = 'success';

        try{
            $data = $this->service->create(data : $request);
        }catch(Exception $e){
            $status = $e;
        }

        $result = array('status' => $status,'data' => $data);
        return response()->json($result);
    }

    /**
     * Display the specified resource.
     * @param int $id
     */
    public function show(int $id)
    {
        $data = null;
        $status = 'success';

        try{
            $data = $this->service->show($id);
        }catch (Exception $e){
            $status = 'error';
        }

        $result = array('status' => $status,'data' => $data);
        return response()->json($result);
    }

    /**
     * Update the specified resource in storage.
     * @param CustomerDtoRequest $data
     * @param int $id
     */
    public function update(CustomerDtoRequest $request, int $id)
    {
        $data = null;
        $status = 'success';

        try{
            $data = $this->service->update(data : $request,id:$id);
        }catch(Exception $e){
            $status = $e;
        }

        $result = array('status' => $status,'data' => $data);
        return response()->json($result);
    }

    /**
     * Display the specified resource.
     * @param int $id
     */
    public function customer_order(int $id)
    {
        $data = null;
        $status = 'success';

        try{
            $data = $this->service->customer_order($id);
        }catch (Exception $e){
            $status = 'error';
        }

        $result = array('status' => $status,'data' => $data);
        return response()->json($result);
    }



    /**
     * Delete the specified resource from storage.
     * @param int $id
     * @return array
     */
    public function destroy(int $id)
    {
        $data = null;
        $status = 'success';

        try{
            $data = $this->service->delete($id);
        }catch (Exception $e){
            $status = 'error';
        }

        $result = array('status' => $status,'data' => $data);
        return response()->json($result);
    }
}
