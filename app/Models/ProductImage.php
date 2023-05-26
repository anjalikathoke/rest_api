<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ProductImage extends Model
{
    use HasFactory;

    /**
     * The Table associated with the model
     */
    protected $table = "product_images";

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'productNumber',
        'image'
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    public function product()
    {
        return $this->belongsTo(Product::class,'productNumber');
    }

}
