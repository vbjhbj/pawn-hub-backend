<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Holding;
use App\Models\Shop;

class Settlement extends Model
{
    public $timestamps = false;
    use HasFactory;

    public function holding()
    {
        return $this->belongsTo(Holding::class);
    }
    public function shop()
    {
        return $this->hasOne(Shop::class);
    }
}
