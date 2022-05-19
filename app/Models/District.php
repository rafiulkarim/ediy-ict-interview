<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'division_id'
    ];

    public function division()
    {
        return $this->hasOne(Division::class, 'id', 'division_id');
    }

    public function upazila()
    {
        return $this->hasMany(Upazila::class, 'district_id', 'id');
    }

}
