<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function borrows()
    {
        return $this->hasMany('App\Borrow');
    }
}
