<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movixpatient extends Model
{
    use HasFactory;
    protected $table = 'movixpatients';

    protected $fillable = [
        'patient_id',
        'p_treatment_plans_id',
        'case_id',
        'note',
        'client',
        'movix_note'
    ];

    /**
     * Relation with Patient model
     */
    public function patient()
    {
        return $this->belongsTo(Patients::class, 'patient_id');
    }

    /**
     * Relation with Treatment Plan model
     */
    public function treatmentPlan()
    {
        return $this->belongsTo(PatientTreatmentPlan::class, 'p_treatment_plans_id');
    }

}
