<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The Table associated with the model
     */
    protected $table = 'products';

    /**
     * The primary key associated with the table
     */
    protected $primaryKey = 'productNumber';

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
        'productCode',
        'productName',
        'productDescription',
        'quantityInStock',
        'buyPrice',
        'MSRP',
        'productImage',
        'productLine',
        'productScale',
        'productVendor'
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    public function ordersDetails()
    {
        return $this->belongsToMany(OrderDetail::class,'productNumber');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class,'productNumber');
    }

}
