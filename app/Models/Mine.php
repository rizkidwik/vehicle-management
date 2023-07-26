<?php

namespace App\Models;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mine extends Model
{
    use HasFactory;
    protected $fillable = ['branch_id','name'];

    public function branch()
    {
        return $this->belongsTo(Branch::class,'branch_id','id');
    }
}
