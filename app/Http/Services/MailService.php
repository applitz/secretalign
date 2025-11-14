<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Exception;

class MailService
{
    public function __construct()
    {
    }
    public function mailPatient($to, $url,$doctor_name)
    {
       // dd($to,$url,$doctor_name);
        try {
            $routes = []; 
            array_push($routes, $to);

            \Illuminate\Support\Facades\Notification::route('mail', $routes)
                ->notify(new \App\Notifications\PatientAlert($url,$doctor_name));

            return true;
        } catch (Exception $e) {
          //  dd($e);
            return false;
        }
    }
}
