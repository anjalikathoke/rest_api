<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The Table associated with the model
     */
    protected $table = 'orders';

    /**
     * The primary key associated with the table
     */
    protected $primaryKey = 'orderNumber';

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
        'orderNumber',
        'orderDate',
        'status',
        'comments',
        'customerNumber',
        'shippedDate'
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];


    protected $casts = [
        'status' => OrderStatus::class,
        'orderDate' => 'date:Y-m-d',
       //'requiredDate' => 'date:Y-m-d',
        'shippedDate' => 'date:Y-m-d'
      ];


    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class,'orderNumber');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customerNumber');
    }

    /**
     * Get the order products.
     */
    public function products(): HasOneThrough
    {
        return $this->hasOneThrough(OrderDetails::class, Product::class);
    }
}
