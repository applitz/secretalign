<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    use HasFactory;
    protected $table = 'patients';

    public function treatmentPlans()
    {
        return $this->hasMany(PatientTreatmentPlan::class, 'patient_id');
    }
    public function treatmentPlansNew()
    {
        return $this->hasMany(PatientTreatmentPlan::class, 'patient_id')
                    ->orderBy('id', 'desc');
    }



    public function latestTreatmentPlan()
    {
        return $this->hasOne(PatientTreatmentPlan::class, 'patient_id')
                    ->where('is_deleted', 0)
                    ->latestOfMany();
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
