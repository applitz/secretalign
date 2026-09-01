<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MeditIntegrationController extends Controller
{
    public function MeditLinkObtainAuthorizationCode()
    {
       return redirect()->away("https://openapi-auth.meditlink.com/oauth/authorize?client_id=".env("MEDIT_LINK_CLIENT_ID")."&response_type=code&redirect_uri=".env("UPDATE_SCAN_MEDIT_LINK_REDIRECT_URL")."?me&scope=CASE FILE USER GROUP&state=".\Illuminate\Support\Str::random(24));
    }

    public function MeditLinkObtainAuthorizationCodeCallback(Request $request)
    {
        try {
            Log::info("got back");

            if (!Auth::user()->medit_link_access_token || !Auth::user()->medit_link_refresh_token  || !Auth::user()->medit_link_group_uuid) {
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://openapi-auth.meditlink.com/oauth/token',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => 'code='.$request->get('code').'&state='.$request->get('state').'&grant_type=authorization_code&redirect_uri='.env("UPDATE_SCAN_MEDIT_LINK_REDIRECT_URL").'?me&scope=CASE%20FILE%20USER%20GROUP',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Basic ' . base64_encode(env("MEDIT_LINK_CLIENT_ID") . ":" . env("MEDIT_LINK_CLIENT_KEY")),
                        'Content-Type: application/x-www-form-urlencoded',
                        'Host: openapi-auth.meditlink.com'
                    ),
                ));

                $response = curl_exec($curl);

                if (curl_errno($curl)) {
                    throw new \Exception('Curl error: ' . curl_error($curl));
                }

                curl_close($curl);
                $response = json_decode($response);
                Log::info("response access " . json_encode($response));

                $session_key = 'error';
                $session_msg = 'Unable to integrate with Medit Link';

                if (@$response->access_token) {
                    if ($this->MeditLinkGetUserInformation($response->access_token, $response->refresh_token)) {
                        $session_key = 'success';
                        $session_msg = 'Successfully Integrated';
                    } else {
                        $session_key = 'error';
                        $session_msg = 'Need Medit Link "CLINIC" profile.';
                    }
                }
            } else {
                $session_key = 'success';
                $session_msg = 'Successfully Integrated';
            }
        } catch (\Throwable $e) {
            Log::error('MeditLink Integration Error: ' . $e->getMessage());
            $session_key = 'error';
            $session_msg = 'An unexpected error occurred during integration.';
        }

        Session::flash($session_key, $session_msg);
        return view("integration.integration_callback");
    }
}
