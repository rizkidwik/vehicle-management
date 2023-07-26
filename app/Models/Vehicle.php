<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $fillable = [
        'mine_id','number_plate','vehicle_type','status'
    ];

    public function mine()
    {
        return $this->belongsTo(Mine::class,'mine_id','id');
    }
}
