<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentCheck extends Model
{
    use HasFactory;
     protected $fillable = [
        'patient_id',
        'attachments_model',
        'bars_model',
        'name_patient',
        'model_dashboard',
        'cutouts_hooks',
        'schnittlinie',
        'zahlen_vergleichen',
        'cutouts_schiene',
        'folie_runtergenommen',
        'richtig_einpacken',
        'richtiger_asr',
        'coworker_name',
    ];
}
