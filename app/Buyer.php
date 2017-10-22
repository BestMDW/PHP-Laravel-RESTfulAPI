<?php

namespace App;

class Buyer extends User
{
    /**
     * Makes the Eloquent One to Many relation.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
}
