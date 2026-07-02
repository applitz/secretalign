<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Agent\Agent;
use Route;

class Audittrails extends Model
{
    use HasFactory;
    protected $table = 'audit_trails';

    protected $fillable = [
        'patient_id',
        'treatment_plan_id',
        'event',
        'from',
        'to',
        'data',
        'url',
        'ip',
        'agent',
    ];

    protected $casts = [
        'patient_id' => 'integer',
        'treatment_plan_id' => 'integer',
    ];

    function addAudittrails($patientId, $treatmentPlanId, $event, $from, $to, $data)
    {
        $agent = new Agent();
        $browser = $agent->browser();
        $currentRoute = Route::current()->getName();
        $auditTrail = new Audittrails();
        $auditTrail->patient_id = $patientId;
        $auditTrail->treatment_plan_id = $treatmentPlanId;
        $auditTrail->event = $event;
        $auditTrail->from = $from;
        $auditTrail->to = $to;
        $auditTrail->data = json_encode($data);
        $auditTrail->url = str_replace(".", "/", $currentRoute);
        $auditTrail->ip = $_SERVER['REMOTE_ADDR'];
        $auditTrail->agent = $browser;
        $auditTrail->save();
    }
}
