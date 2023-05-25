<?php

namespace App\Repositories\ProductImage;

use Exception;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Product\ProductRepository;
use App\Http\Requests\ProductImage\ProductImageDtoRequest;
use App\Http\Requests\ProductImage\ProductImageDeleteDtoRequest;
use App\Repositories\ProductImage\Interface\ProductImageRepositoryInterface;


class ProductImageRepository implements ProductImageRepositoryInterface
{

    /**
     * Constructor based dependency injection
     *
     * @param ProductImageRepository $repository
     *
     *
     * @return void
     */
    public function __construct(protected ProductRepository $productRepository)
    {

    }

     /**
     * get all products
     */
    public function findAll(int $productNumber){
        //Redis::flushDB();
        try{
            if($productImages = Redis::get("product-images:$productNumber")){
                $productImages = json_decode($productImages);

                Redis::expire("product-images:$productNumber", 60*60*2);
            }else{
                $productImages = ProductImage::where('productNumber',$productNumber)->get();

                Redis::setex("product-images:$productNumber", 60*60*2, json_encode($productImages));

            }

            return $productImages;
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
            if($productImages = Redis::get("product-image:$id")){
                $productImages = json_decode($productImages);

                Redis::expire("product-image:$id", 60*60*2);
            }else{
                $productImages = ProductImage::find($id);

                Redis::setex("product-image:$id", 60*60*2, json_encode($productImages));

            }

            return $productImages;

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
                $product = ProductImage::select('buyPrice')->find($id);
                $price = $product->buyPrice;
            }

            return $price;

        }catch(Exception $e){
            throw $e;
        }
    }


    /**
     * store a product multiple images
     * @param Array $data
     *
     *
     * @return Array
     */
    public function add(Array $data,int $id){
        if (empty($data) || empty($id)) {
            throw new Exception;
        }

        //to add image into product images table
        $productImages = ProductImage::where('ProductNumber',$id)->get();

        try{

           ProductImage::where('ProductNumber',$id)->delete();

           if($result = ProductImage::insert($data)){
                Redis::setex("product-images:$id", 60*60*2, json_encode($data));

                if (!$productImages->isEmpty()) {

                    foreach($productImages as $image){

                       $imageName = basename($image->image);

                       if(Storage::disk('s3_thumbnail_images')->exists('small_'.$imageName)){
                            Storage::disk('s3_thumbnail_images')->delete('small_'.$imageName);
                       }
                       if(Storage::disk('s3_thumbnail_images')->exists('medium_'.$imageName)){
                            Storage::disk('s3_thumbnail_images')->delete('medium_'.$imageName);
                       }
                       if(Storage::disk('s3_images')->exists($imageName)){
                            Storage::disk('s3_images')->delete($imageName);
                       }

                    }
                }
            }

            return $result;

        }catch(Exception $e){
            throw $e;
        }
    }

    /**
     * delete a product image
     * @param ProductImageDeleteDtoRequest $data
     * @param int $id delete record by ID
     */
    public function delete(ProductImageDeleteDtoRequest $data,int $id){

        if(empty($data->ids) || empty($id)){
            throw new Exception;
        }

        //to add image into product images table
        $productImages = ProductImage::where('ProductNumber',$id)->whereIn('id',$data->ids)->get();

        if ($productImages->isEmpty()) {
            throw new Exception;
        }

        //to delete product image from product images table
        try{
            if($result = ProductImage::where('ProductNumber',$id)->whereIn('id',$data->ids)->delete()){
                foreach($productImages as $image){

                    $imageName = basename($image->image);

                    if(Storage::disk('s3_thumbnail_images')->exists('small_'.$imageName)){
                        Storage::disk('s3_thumbnail_images')->delete('small_'.$imageName);
                   }
                   if(Storage::disk('s3_thumbnail_images')->exists('medium_'.$imageName)){
                        Storage::disk('s3_thumbnail_images')->delete('medium_'.$imageName);
                   }
                   if(Storage::disk('s3_images')->exists($imageName)){
                        Storage::disk('s3_images')->delete($imageName);
                   }
                }
            }

            return $result;
        }catch(Exception $e){
            throw $e;
        }
    }

}
