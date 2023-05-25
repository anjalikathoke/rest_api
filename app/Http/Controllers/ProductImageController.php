<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\ProductImage\ProductImageService;
use App\Http\Requests\ProductImage\ProductImageDtoRequest;
use App\Http\Requests\ProductImage\ProductImageDeleteDtoRequest;

class ProductImageController extends Controller
{
    /**
     * Constructor based dependency injection
     *
     * @param ProductImageService $service
     *
     *
     * @return void
     */
    public function __construct(Protected ProductImageService $service)
    {

    }

    /**
     * Display a product of the resource.
     */
    public function index(int $productNumber)
    {
        $status = 'success';
        $data = Null;

        try{
            $data = $this->service->findAll($productNumber);
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
     * Store a newly created product resource in storage.
     * @param ProductImageDtoRequest $data
     * @return array
     */
    public function store(ProductImageDtoRequest $request,int $id)
    {
        $status = 'success';
        $data = Null;

        try{
            $data = $this->service->add(
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
     * @param ProductImageDtoRequest $data
     * @param int $id
     * @return array
     */
    public function destroy(ProductImageDeleteDtoRequest $request,int $id)
    {
        $status = 'success';
        $data = Null;

        try{
            $data = $this->service->delete(
                data:$request,
                id:$id
            );
        }catch(Exception $e){
            throw $e;
        }

        $result = array('status' => $status,'data'=>$data);
        return response()->json($result);
    }
}
