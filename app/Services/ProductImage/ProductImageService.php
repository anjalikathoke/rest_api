<?php

namespace App\Services\ProductImage;

use Exception;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Product\ProductRepository;
use App\Http\Resources\ProductImage\ProductImageResource;
use App\Repositories\ProductImage\ProductImageRepository;
use App\Http\Requests\ProductImage\ProductImageDtoRequest;
use App\Http\Requests\ProductImage\ProductImageDeleteDtoRequest;

class ProductImageService
{
    /**
     * Constructor based dependency injection
     *
     * @param ProductImageRepository $repository
     *
     *
     * @return void
     */
    public function __construct(protected ProductImageRepository $repository, protected ProductRepository $productRepository)
    {

    }

     /**
     * Get the product image listing
     *
     * @param int $id
     *
     * @return array
     */
    public function findAll(int $productNumber)
    {
        try{
           return ProductImageResource::collection($this->repository->findAll($productNumber));
        }catch(Exception $e){
            throw $e;
        }
    }


    /**
     * Get the product image details
     *
     * @param int $id
     *
     * @return array
     */
    public function show(int $id){
        try{
            return new ProductImageResource(
                $this->repository->findById($id)
            );
        }catch(Exception $e){
            throw $e;
        }
    }

    /**
     * add product image function
     *
     * @param ProductImageDtoRequest $data
     * @return array
     */
    public function add(ProductImageDtoRequest $data,int $id){

       // dd( $contents = Storage::disk('s3_images')->get('M00QMmJCDSwMsthAcyG9zf0LSOhWVSKECfDPCLoe.jpg.jfif'));
        try{
            $files = $data->file('files');

            $details = $resultPath = [];

            //prepare array for uploading mutiple images
            foreach ($files as $key => $file) {

                // Generate a file name with extension
                $fileName = $file->hashName();

                $folderPath = Storage::disk('s3_images');

                //store and get main image
                Storage::disk('s3_images')->put($fileName,File::get($file));
                $fileUrl = $folderPath->url($fileName);

                $resultPath[] = $fileUrl;

                $details[] = ['productNumber' => $id, 'image' => $fileUrl];


                // Generate a thumbnail image (small) file name with extension
                $fileNameSmall = 'small_'.$file->hashName();

                // Generate a thumbnail image (medium) file name with extension
                $fileNameMedium = 'medium_'.$file->hashName();

                //store thumbnail image image
                $imageSmall = Image::make($file->path())->resize(200, 200, function ($constraint) {
                    $constraint->aspectRatio();
                });

                //store and get small thumb file url
                Storage::disk('s3_thumbnail_images')->put($fileNameSmall, $imageSmall->stream());
                $smallFileUrl = Storage::disk('s3_thumbnail_images')->url($fileNameSmall);

                $resultPath[] = $smallFileUrl;

                $imageMedium = Image::make($file->path())->resize(400, 200, function ($constraint) {
                    $constraint->aspectRatio();
                });

                //store and get medium thumb file url
                Storage::disk('s3_thumbnail_images')->put($fileNameMedium, $imageMedium->stream());
                $mediumFileUrl = Storage::disk('s3_thumbnail_images')->url($fileNameMedium);

                $resultPath[] = $mediumFileUrl;


            }

            //upload multiple images
            if($details){
                $this->repository->add($details,$id);
            }else{
                throw new Exception();
            }

            return $resultPath;
        }catch(Exception $e){
            throw $e;
        }
    }

    /**
     * delete a product image
     *
     * @param ProductImageDeleteDtoRequest $data
     * @param int $id
     *
     * @return boolean
     */
    public function delete(ProductImageDeleteDtoRequest $data,int $id){

        try{
           return $this->repository->delete($data,$id);
        }catch(Exception $e){
            throw $e;
        }
    }
}
