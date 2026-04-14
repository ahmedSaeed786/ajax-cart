<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    //

    public $fillable = [
        "name",
        "qty",
        "amount",
        "total",
        "c_id",
    ];
}
