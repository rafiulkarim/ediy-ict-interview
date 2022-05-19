<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Union extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'population',
        'upazila_id'
    ];

    public function upazila()
    {
        return $this->hasOne(Upazila::class, 'id', 'upazila_id');
    }
}
