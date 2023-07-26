<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleBooking extends Model
{
    use HasFactory;
    protected $fillable = [
        'vehicle_id','driver_id','booking_date','status','approval_1','approval_1_datetime','approval_2','approval_2_datetime'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class,'vehicle_id','id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class,'driver_id','id');
    }

    public function approval1()
    {
        return $this->belongsTo(User::class,'approval_1','id');
    }

    public function approval2()
    {
        return $this->belongsTo(User::class,'approval_2','id');
    }
}
