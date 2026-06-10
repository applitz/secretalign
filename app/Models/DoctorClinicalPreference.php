<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorClinicalPreference extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'ipr_max_limit' => 'float',
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
