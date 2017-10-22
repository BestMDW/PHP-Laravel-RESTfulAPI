<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** Possible states of the product status field. */
    const AVAILABLE_PRODUCT = 'available';
    const UNAVAILABLE_PRODUCT = 'unavailable';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id',
    ];

    /******************************************************************************************************************/

    /**
     * Makes the Eloquent Many to Many relation.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    /******************************************************************************************************************/

    /**
     * Makes the Inverse Eloquent One to One relation.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function seller()
    {
        return $this->belongsTo('App\Seller');
    }

    /******************************************************************************************************************/

    /**
     * Makes the Eloquent One to Many relation.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    /******************************************************************************************************************/

    /**
     * Checks if product is available.
     * @return bool True when product is available, false otherwise.
     */
    public function isAvailable() : bool
    {
        return $this->status == Product::AVAILABLE_PRODUCT;
    }
}
