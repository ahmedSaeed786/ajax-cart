<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\item;
use App\Models\order;

class cutomer extends Model
{
    //

    public $fillable = [
        "name",
        "date",
        "phone",
    ];

    public function item()
    {
        return $this->hasMany(order::class, 'c_id', 'id');
    }
}
