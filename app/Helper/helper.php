<?php
use App\Models\Patients;
use App\Http\Services\NemoTechService;
use App\Models\PatientTreatmentPlan;

function checkForRequestNewPlan($patientId)
{
    $patientDetails = Patients::with([
        'treatmentPlans' => function ($query) {
            $query->orderBy('id', 'desc');
        }
    ])
    ->where('id', $patientId)
    ->first();
    // dd($patientDetails);
    if ($patientDetails && $patientDetails->treatmentPlans->contains('status', 'Shipped')) {
        $shippingDateTime = $patientDetails->treatmentPlans[0]->shipping_date_time;
        if($patientDetails->treatmentPlans[0]->expiry_date != null) {
            $planExprieyDate = date('Y-m-d', strtotime($patientDetails->treatmentPlans[0]->expiry_date));
        } else {
            if ($patientDetails->pricing_package == 'AL-SECRET-SELECT') {
                $aligner_steps = $patientDetails->treatmentPlans[0]->aligner_steps;
                $addOnweeks = 2*$aligner_steps;
                $planExprieyDate = date('Y-m-d', strtotime($shippingDateTime . ' + '.$addOnweeks.' weeks'));
                if($aligner_steps > 0 && $aligner_steps <= 20) {
                    $planExprieyDate = date('Y-m-d', strtotime($planExprieyDate . ' + 3 months'));
                } else {
                    $planExprieyDate = date('Y-m-d', strtotime($planExprieyDate . ' + 6 months'));
                }
            } else {
                $planExprieyDate = date('Y-m-d', strtotime($shippingDateTime . ' + 3 years'));
            }
        }
        // Compare with today's date
        if (strtotime($planExprieyDate) < strtotime(date('Y-m-d'))) {
            return false;
        }
        return true;
    }
    return false;
}
function checkForRequestNewPlanExpriyDate($patientId)
{
    $patientDetails = Patients::with([
        'treatmentPlans' => function ($query) {
            $query->orderBy('id', 'desc');
        }
    ])
    ->where('id', $patientId)
    ->first();


    if ($patientDetails && $patientDetails->treatmentPlans->contains('status', 'Shipped')) {
        $shippingDateTime = $patientDetails->treatmentPlans[0]->shipping_date_time;
        if($patientDetails->treatmentPlans[0]->expiry_date != null) {
            return date_formate($patientDetails->treatmentPlans[0]->expiry_date);
        } else {
            if ($patientDetails->pricing_package == 'AL-SECRET-SELECT') {
                $aligner_steps = $patientDetails->treatmentPlans[0]->aligner_steps;
                $addOnweeks = 2*$aligner_steps;
                $planExprieyDate = date('Y-m-d', strtotime($shippingDateTime . ' + '.$addOnweeks.' weeks'));
                if($aligner_steps > 0 && $aligner_steps <= 20) {
                    $planExprieyDate = date('Y-m-d', strtotime($planExprieyDate . ' + 3 months'));
                } else {
                    $planExprieyDate = date('Y-m-d', strtotime($planExprieyDate . ' + 6 months'));
                }
            } else {
                $planExprieyDate = date('Y-m-d', strtotime($shippingDateTime . ' + 3 years'));
            }

            return date_formate($planExprieyDate);
        }

    }
    return NULL;
}

function getExpriyDateForNewPlaFromTreatmentPlanId($treatmentPlanId, $shippingDateTime)
{
    $treatmentPlanDetails = PatientTreatmentPlan::from('p_treatment_plans')
                            ->join('patients', 'patients.id', '=', 'p_treatment_plans.patient_id')
                            ->where('p_treatment_plans.id', $treatmentPlanId)
                            ->select('patients.pricing_package', 'p_treatment_plans.*')
                            ->first();

    $shippingDateTime = date('Y-m-d', strtotime($shippingDateTime));
    $patientDetails = Patients::where('id', $treatmentPlanDetails->patient_id)->first();

    if ($patientDetails->pricing_package == 'AL-SECRET-SELECT') {
        $aligner_steps = $treatmentPlanDetails->aligner_steps;
        $addOnweeks = 2*$aligner_steps;
        $planExprieyDate = date('Y-m-d', strtotime($shippingDateTime . ' + '.$addOnweeks.' weeks'));
        if($aligner_steps > 0 && $aligner_steps <= 20) {
            $planExprieyDate = date('Y-m-d', strtotime($planExprieyDate . ' + 3 months'));
        } else {
            $planExprieyDate = date('Y-m-d', strtotime($planExprieyDate . ' + 6 months'));
        }
    } else {
        $planExprieyDate = date('Y-m-d', strtotime($shippingDateTime . ' + 3 years'));
    }

    return date('Y-m-d', strtotime($planExprieyDate));
}


function date_formate($date)
{
    return date("d.m.Y", strtotime($date));
}

function getPatientTreatmentPlanStatus($status)
{
    $statusMap = [
        'In Progress' => 'badge-soft-primary',
        'Production' => 'badge-soft-success',
        'Waiting Staff Review' => 'badge-soft-warning',
        'Waiting Lab Review' => 'badge-soft-warning',
        "Waiting Dr's Review" => 'badge-soft-warning',
        "Waiting for Review from Advisor" => 'badge-soft-warning',
        'Treatment Plan Completed' => 'badge-soft-info',
        'Shipped' => 'badge-soft-info',
        'Cancelled By Lab' => 'badge-soft-warning',
        'Cancelled' => 'badge-soft-danger',
        'Pending' => 'badge-soft-secondary',
    ];

    return $statusMap[$status] ?? 'badge-soft-secondary';
}

function checkFileisStlOrNot($fileName){
    // Get the file extension
    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Check if it's .stl
    if ($extension === 'stl') {
        return true;
    }

    return false;
}

function getSimseToken($firstName,$lastName,$dob,$userId){
    $nemoService = new NemoTechService($firstName,$lastName,$dob,$userId);
    $simseToken = $nemoService->basicCentrePreAuth();
    return $simseToken;
}

?>
