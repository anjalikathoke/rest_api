<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Services\Product\ProductService;
use App\Http\Requests\Product\ImageDtoRequest;
use App\Http\Requests\Product\ProductDtoRequest;

class ProductController extends Controller
{
    /**
     * Constructor based dependency injection
     *
     * @param ProductService $service
     *
     *
     * @return void
     */
    public function __construct(Protected ProductService $service)
    {

    }

    /**
     * Display a product of the resource.
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
     * Display the specified product details.
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
     * get the product visits count
     * @param int $id
     */
    public function get_product_visits(int $id)
    {
        $status = 'success';
        $data = Null;

        try{
            return $this->service->getProductVistsById($id);
        }catch(Exception $e){
            throw $e;
        }

        $result = array('status' => $status,'data'=>$data);
        return response()->json($result);
    }

    /**
     * get the product visits count
     * @param int $id
     */
    public function get_product_price(int $id)
    {
        $status = 'success';
        $data = Null;

        try{
            return $this->service->getProductPrcieById($id);
        }catch(Exception $e){
            throw $e;
        }

        $result = array('status' => $status,'data'=>$data);
        return response()->json($result);
    }


    /**
     * Store a newly created product resource in storage.
     * @param ProductDtoRequest $data
     * @return array
     */
    public function store(ProductDtoRequest $request)
    {
        $status = 'success';
        $data = Null;

        try{
            $data = $this->service->add(
                data:$request
            );
        }catch(Exception $e){
            throw $e;
        }

        $result = array('status' => $status,'data'=>$data);
        return response()->json($result);
    }

    /**
     * Update the specified resource in storage.
     * @param ProductDtoRequest $data
     * @param int $id
     * @return array
     */
    public function update(ProductDtoRequest $request,int $id)
    {
        $status = 'success';
        $data = Null;

        try{
            $data = $this->service->update(
                data:$request,
                id:$id
            );
        }catch(Exception $e){
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

        try{
            $data = $this->service->delete($id);
        }catch(Exception $e){
            throw $e;
        }

        $result = array('status' => $status,'data'=>$data);
        return response()->json($result);
    }

    /**
     * Store a newly created product resource in storage.
     * @param ImageDtoRequest $data
     * @return array
     */
    public function add_product_image(ImageDtoRequest $request)
    {
        $status = 'success';
        $data = Null;

        try{
            $data = $this->service->addProductImage(
                data:$request
            );
        }catch(Exception $e){
            throw $e;
        }

        $result = array('status' => $status,'data'=>$data);
        return response()->json($result);
    }


    /**
     * Update the specified resource in storage.
     * @param ImageDtoRequest $data
     * @param int $id
     * @return array
     */
    public function update_product_image(ImageDtoRequest $request)
    {
        $status = 'success';
        $data = Null;

        try{
            $data = $this->service->updateProductImage(
                data:$request
            );
        }catch(Exception $e){
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
    public function delete_product_Image(int $id)
    {
        $status = 'success';
        $data = Null;

        try{
            $data = $this->service->deleteProductImage($id);
        }catch(Exception $e){
            throw $e;
        }

        $result = array('status' => $status,'data'=>$data);
        return response()->json($result);
    }
}
