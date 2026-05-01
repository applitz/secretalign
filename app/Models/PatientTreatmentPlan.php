<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientTreatmentPlan extends Model
{
    use HasFactory;
    protected $table = 'p_treatment_plans';
    protected $guarded = [];
    public function patient()
    {
        return $this->belongsTo(Patients::class, 'patient_id');
    }

    public function lab()
    {
        return $this->belongsTo(User::class, 'lab');
    }
}

