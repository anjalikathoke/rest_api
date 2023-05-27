<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;


class Customer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The Table associated with the model
     */
    protected $table = 'customers';

    /**
     * The primary key associated with the table
     */
    protected $primaryKey = 'customerNumber';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;



   /*public function getCustomerNameAttribute()
    {
        return "{$this->attributes['contactFirstName']} {$this->attributes['contactLastName']}";
    }*/

    /**
     * Get the user's customer name.
     */
   protected function customerName(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) =>    "{$attributes['contactFirstName']} {$attributes['contactLastName']}"
        );
    }

    public function orders()
    {
        return $this->hasMany(Order::class,'customerNumber');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customerNumber',
        'customerName',
        'contactFirstName',
        'contactLastName',
        'phone',
        'addressLine1',
        'addressLine2',
        'city',
        'state',
        'postalCode',
        'country'
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];


}
