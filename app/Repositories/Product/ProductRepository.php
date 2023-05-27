<?php

namespace App\Repositories\Product;

use Exception;
use App\Models\Product;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Product\ProductResource;
use App\Http\Requests\Product\ProductDtoRequest;
use App\Repositories\Product\Interface\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
     /**
     * get all products
     */
    public function findAll(){
        try{
            return Product::get();
        }catch(Exception $e){
            throw $e;
        }
    }

     /**
     * Find record by ID
     * @param int $id Find the record by ID
     */
    public function findById(int $id){
        try{
           // Redis::flushDB();

            if($product = Redis::get("product:$id")){
                $product = json_decode($product);

                Redis::expire("product:$id", 60*60*2);
            }else{
                $product = Product::find($id);

                Redis::setex("product:$id", 60*60*2, json_encode($product));
               // Redis::setex("product:$id", 60*60*2, $product);

            }

            //increment product visits count
            Redis::incr("product_visits:$id");

            return $product;

        }catch(Exception $e){
            throw $e;
        }
    }

     /**
     * get product visit by ID
     * @param int $id Find the record by ID
     */
    public function getProductVistsById(int $id){
        try{
            $visits = Redis::incr("product_visits:$id");

            return $visits;

        }catch(Exception $e){
            throw $e;
        }
    }

     /**
     * get product price by ID
     * @param int $id Find the record by ID
     */
    public function getProductPrcieById(int $id){
        try{
            if(is_null($price = Redis::get("product_price:$id"))){
                $product = Product::select('buyPrice')->find($id);
                $price = $product->buyPrice;
            }

            return $price;

        }catch(Exception $e){
            throw $e;
        }
    }


    /**
     * store a product
     * @param ProductDtoRequest $data
     *
     *
     * @return Array
     */
    public function add(ProductDtoRequest $data){
        try{
            $product =  Product::create($data->toArray());
            return $product;
        }catch(Exception $e){
            throw $e;
        }
    }

    /**
     * Update a product
     * @param ProductDtoRequest $data
     *
     * @param int $id
     *
     * @return Array
     */
    public function update(ProductDtoRequest $data,int $id){
        if (empty($data) || empty($id)) {
            throw new Exception;
        }

        $product = Product::find($id);

        try{
            $details = $data->toArray();
            $result = $product->update($details);

            if($data->hasFile('productImage') && isset($details['productImage']) && $product->productImage){

               $imageName = basename($product->productImage);

               if(Storage::disk('s3_thumbnail_images')->exists('small_'.$imageName)){
                    Storage::disk('s3_thumbnail_images')->delete('small_'.$imageName);
               }
               if(Storage::disk('s3_thumbnail_images')->exists('medium_'.$imageName)){
                    Storage::disk('s3_thumbnail_images')->delete('medium_'.$imageName);
               }
               if(Storage::disk('s3_images')->exists($imageName)){
                    Storage::disk('s3_images')->delete($imageName);
               }

               Redis::setex("product_image:$id", 60*60*2 ,$details['productImage']);
            }

            //to cache updated product details and price
            Redis::setex("product:$id", 60*60*2, json_encode($details));
            Redis::set("product_price:$id",$details['buyPrice']);

            return $result;
        }catch(Exception $e){
            throw $e;
        }
    }

    /**
     * Soft delete a product
     * @param int $id delete record by ID
     */
    public function delete(int $id){
        if(empty($id)){
            throw new Exception;
        }

        $product = $this->findById($id);

        try{
            if($result = $product->delete()){
                if($product->productImage){

                    $imageName = basename($product->productImage);

                    if(Storage::disk('s3_thumbnail_images')->exists('small_'.$imageName)){
                        Storage::disk('s3_thumbnail_images')->delete('small_'.$imageName);
                    }
                    if(Storage::disk('s3_thumbnail_images')->exists('medium_'.$imageName)){
                        Storage::disk('s3_thumbnail_images')->delete('medium_'.$imageName);
                    }
                    if(Storage::disk('s3_images')->exists($imageName)){
                        Storage::disk('s3_images')->delete($imageName);
                    }

                    Redis::del("product_image:$id");
                }
            }

            //delete cache for that product only
            Redis::del("product:$id");
            Redis::del("product_price:$id");

            return $result;
        }catch(Exception $e){
            throw $e;
        }
    }

    /**
     * generate unique product code
     *
     *
     * @return string response
     */
    public function generateUniqueProductCode()
    {
        do {
            $refrence_id = mt_rand( 1000, 9999 );
            $productCode = 'P-'.$refrence_id;
         } while ( Product::where( 'productCode', $productCode )->exists() );

         return $productCode;
    }

    /**
     * get product details for given product ids
     *
     * @param array $productIds
     *
     * @return array response
     */
    public function getDetailsForIds(array $productIds)
    {
        if(empty($productIds)){
            throw new Exception;
        }
        try{
            return Product::select('productCode','buyPrice')->whereIn('productNumber', $productIds)->get();
        }catch(Exception $e){
            throw $e;
        }
    }

    public function decrementProductQuantity(array $orderDetails)
    {

        if(empty($orderDetails)){
            throw new Exception;
        }

        foreach($orderDetails as $productDetails){

            try{
                $product = $this->findById($productDetails['productNumber']);
            }catch(Exception $e){
                throw $e;
            }

            if($product->quantityInStock <= $productDetails['quantityOrdered']){
                throw new Exception;
            }

            try{
                $product->decrement('quantityInStock',$productDetails['quantityOrdered']);
            }catch(Exception $e){
                throw $e;
            }

        }
    }

    public function incrementProductQuantity(array $orderDetails)
    {

        if(empty($orderDetails)){
            throw new Exception;
        }

        foreach($orderDetails as $productDetails){

            try{
                $product = $this->findById($productDetails['productNumber']);
            }catch(Exception $e){
                throw $e;
            }

            if($product->quantityInStock <= $productDetails['quantityOrdered']){
                throw new Exception;
            }

            try{
                return $product->increment('quantityInStock',$productDetails['quantityOrdered']);
            }catch(Exception $e){
                throw $e;
            }
        }

    }

    /**
     * Soft delete a product image
     * @param int $id delete record by ID
     */
    public function deleteProductImage(int $id){
        if(empty($id)){
            throw new Exception;
        }

        //update product for updating main image
        $product = Product::find($id);

        if (empty($product)) {
            throw new Exception;
        }

        try{

            $details['productImage'] = null;
            $product->update($details);

            //to delete cache for  product main image
            Redis::del("product-image:$id");
            Redis::del("product-images:$id");


        }catch(Exception $e){
            throw $e;
        }

    }

}
