<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function borrows()
    {
        return $this->hasMany('App\Borrow');
    }

    public function library()
    {
        return $this->belongsTo('App\Library');
    }
}
