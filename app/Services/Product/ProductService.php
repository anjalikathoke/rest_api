<?php

namespace App\Services\Product;

use Exception;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Product\ImageDtoRequest;
use App\Http\Resources\Product\ProductResource;
use App\Repositories\Product\ProductRepository;
use App\Http\Requests\Product\ProductDtoRequest;
use App\Http\Resources\Product\ProductDetailResource;

class ProductService
{
    /**
     * Constructor based dependency injection
     *
     * @param ProductRepository $repository
     *
     *
     * @return void
     */
    public function __construct(protected ProductRepository $repository)
    {

    }

     /**
     * Get the product listing
     *
     * @param int $id
     *
     * @return array
     */
    public function findAll()
    {
        try{
           return $products = ProductResource::collection($this->repository->findAll());
          // $productCount = count($products);
          // return ['products' => $products,'total' => $productCount];

        }catch(Exception $e){
            throw $e;
        }
    }

     /**
     * Get the product visits count
     *
     * @param int $id
     *
     * @return array
     */
    public function getProductVistsById(int $id){
        try{

            return ['visits' => $this->repository->getProductVistsById($id)];

        }catch(Exception $e){
            throw $e;
        }
    }

    /**
     * Get the product visits count
     *
     * @param int $id
     *
     * @return array
     */
    public function getProductPrcieById(int $id){
        try{

            return ['price' => $this->repository->getProductPrcieById($id)];

        }catch(Exception $e){
            throw $e;
        }
    }

    /**
     * Get the product details
     *
     * @param int $id
     *
     * @return array
     */
    public function show(int $id){
        try{
            return new ProductDetailResource(
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
    public function add(ProductDtoRequest $data){
        try{
            $extraDetails['productCode'] = $this->repository->generateUniqueProductCode();

            if($data->hasFile('file')){

                $file = $data->file('file');

                // Generate a main image file name with extension
                $fileName = $file->hashName();

               //$folderPath= Storage::disk('public_products');
               $folderPath= Storage::disk('s3_images');

               //store main image
               Storage::disk('s3_images')->put($fileName, File::get($file));


                //get file url
                if($fileUrl = $folderPath->url($fileName)){
                    $extraDetails['productImage'] = $fileUrl;
                }
            }

            $data = $data->merge($extraDetails);

            return new ProductResource(
                $this->repository->add($data)
            );
        }catch(Exception $e){
            throw $e;
        }
    }

    /**
     * update product function
     *
     * @param ProductDtoRequest $data
     *
     * @param int $id
     *
     * @return array
     */
    public function update(ProductDtoRequest $data,int $id){
        try{
            if($data->hasFile('file')){
                $file = $data->file('file');

                // Generate a file name with extension
                $fileName = $file->hashName();

                //$folderPath= Storage::disk('public_products');
                $folderPath= Storage::disk('s3_images');

                //store file
                Storage::disk('s3_images')->put($fileName, File::get($file));

                //get file url
                if($fileUrl = $folderPath->url($fileName)){

                    $extraDetails['productImage'] = $fileUrl;

                    $data = $data->merge($extraDetails);
                }
            }

            return $this->repository->update($data,$id);

        }catch(Exception $e){
            throw $e;
        }
    }

    /**
     * delete a product
     *
     * @param int $id
     *
     * @return boolean
     */
    public function delete(int $id){
        try{
           return $this->repository->delete($id);
        }catch(Exception $e){
            throw $e;
        }
    }


    /**
     * delete a product image
     *
     * @param int $id
     *
     * @return boolean
     */
    public function deleteProductImage(int $id){
        try{
           return $this->repository->deleteProductImage($id);
        }catch(Exception $e){
            throw $e;
        }
    }
}
