<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upazila extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'district_id'
    ];

    public function district()
    {
        return $this->hasOne(District::class, 'id', 'district_id');
    }

    public function union()
    {
        return $this->hasMany(Union::class, 'upazila_id', 'id');
    }
}
