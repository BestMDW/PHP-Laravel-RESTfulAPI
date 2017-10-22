<?php

namespace App;

class Seller extends User
{
    /**
     * Makes the Eloquent One to Many relation.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
