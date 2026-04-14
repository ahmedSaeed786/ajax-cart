<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\cutomer;

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

    public function customer()
    {
        return $this->hasOne(cutomer::class, 'id', 'c_id');
    }
}
