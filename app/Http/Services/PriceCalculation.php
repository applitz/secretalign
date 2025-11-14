<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PriceCalculation
{
    public function calc($tier, $patient)
    {
        if($patient->treatment_type == 2){
            $user_tier = DB::table('tiers')->where('id', $tier)->first();
            $patient_id = $patient->patient_id;
            $treatment_plan1 = DB::table('p_treatment_plans')->where('patient_id', $patient_id)->first();
            if($patient->pricing_package == 'AL-SECRET-SELECT') { //user preferred package
                $aligner_steps = $patient->aligner_steps;
                $one_jaw_aligners = 'one_jaw_price_10';
                $two_jaws_aligners = 'two_jaw_price_10';
                $package = 'AL-SECRET-SELECT-10';
                if ($aligner_steps > 10 && $aligner_steps <= 20) {
                    $one_jaw_aligners = 'one_jaw_price_20';
                    $two_jaws_aligners = 'two_jaw_price_20';
                    $package = 'AL-SECRET-SELECT-20';
                }
                if($aligner_steps > 20 && $aligner_steps <= 30) {
                    $one_jaw_aligners = 'one_jaw_price_30';
                    $two_jaws_aligners = 'two_jaw_price_30';
                    $package = 'AL-SECRET-SELECT-30';
                }
                if ($aligner_steps > 30) {
                    $one_jaw_aligners = 'one_jaw_price_infinite';
                    $two_jaws_aligners = 'two_jaw_price_infinite';
                    $package = 'AL-SECRET-SELECT-INFINITE';
                }
                if($patient->phase == 1) {//phase 1 calc

                    $one_jaw_price = @$user_tier->$one_jaw_aligners ? @$user_tier->$one_jaw_aligners : 0;
                    $two_jaw_price = @$user_tier->$two_jaws_aligners ? @$user_tier->$two_jaws_aligners : 0;
                    $deposit = DB::table('payments')->where('is_paid', 1)->where('treatment_plan_id', $patient->id)->where('mode', 'initial-deposit')->sum("amount");

                    $final_deposit = 0;
                    if ($patient->treat_upper_arch == 1 && $patient->treat_lower_arch == 1) {
                        $final_deposit = $two_jaw_price - $deposit;
                    } else {
                        $final_deposit = $one_jaw_price - $deposit;
                    }

                    if(($package=='AL-SECRET-SELECT-30' || $package=='AL-SECRET-SELECT-INFINITE') && $patient->phase!=1){
                        $final_deposit=0;
                    }


                    return $final_deposit;
                }

                if($treatment_plan1->aligner_steps>20) {
                    if($patient->phase > 2) {
                        return (22 * $patient->aligner_steps) + 100;//phase 3 and onwards price calc
                    }
                    return 0;
                }
                return (22 * $patient->aligner_steps) + 100; //phase 2 and onwards price calc
            } else if($patient->pricing_package == 'AL-SECRET-CONFIDENCE') {
                if($patient->phase == 1) {//phase 1 calc
                    $two_jaw_price = $user_tier->two_jaw_price_confidence;
                    $deposit = DB::table('payments')->where('is_paid', 1)->where('treatment_plan_id', $patient->id)->where('mode', 'initial-deposit')->sum("amount");
                    $final_deposit = $two_jaw_price - $deposit;
                    return $final_deposit;
                }
                return 0;//phases > 1 are free
            }
        } else {

            $countTreatmentPlanService = DB::table('p_treatment_plans')
                                ->where('treatment_type', 1)
                                ->where('patient_id', $patient->patientId)
                                ->count();
            $countAlignersService = DB::table('p_treatment_plans')
                                ->where('treatment_type', 2)
                                ->where('patient_id', $patient->patientId)
                                ->count();

            if ($countTreatmentPlanService <= 1) {
                if ($countTreatmentPlanService == 1 && $countAlignersService == 0) {
                    return 200; // first ever treatment
                } else {
                    return 100; // either aligner-first switch OR already 1 treatment
                }
            } else {
                return 100; // further treatment plans
            }
        }

    }
}
