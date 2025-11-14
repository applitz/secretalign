<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Exception;

class DoctorMailService
{
    public function __construct()
    {
    }
   
    public function mailDoctor($to, $patient_email,$patient_name)
    {
       // dd($to,$patient_email,$patient_name);
        try {
            $routes = []; 
            array_push($routes, $to);

            \Illuminate\Support\Facades\Notification::route('mail', $routes)
                ->notify(new \App\Notifications\DoctorAlert($patient_email,$patient_name));

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
