<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\ThreeShape;
use App\Models\MeditLink;
use Exception;


class IntegrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //threeshape  helper
    private function refreshThreeShapeToken()
{
    $usershape = DB::table('users')
    ->where('id', Auth::id())
    ->orderBy('id', 'desc')
    ->first();
    $token = ThreeShape::where('user_id', Auth::id())->orderBy('id', 'desc')->first();
    if ($token && $this->isTokenExpired($usershape->three_shape_access_token)) {
        $threeshape_api_uri = 'https://identity.3shape.com';
        $threeshape_client_id = 'SecretAlign.Production';
        // $threeshape_redirect_uri = 'https://secretalign-user.com/integration-3shape';
        // $threeshape_code_verifier = '4-WXwM2gMHWu5RoHcYmbcrQPUBYmpgwYlz8_4GHNbXo';

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $threeshape_api_uri . '/connect/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query([
                'refresh_token' => $usershape->three_shape_refresh_token,
                'client_id' => $threeshape_client_id,
                'grant_type' => 'refresh_token',
            ]),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded',
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
        DB::table('users')->where('id', Auth::user()->id)->update([
            "three_shape_access_token" => @$response->access_token,
            "three_shape_refresh_token" => @$response->refresh_token,
        ]);

        // if ($response->access_token) {
            $token->access_token = $response->access_token;
            $token->refresh_token = $response->refresh_token;
            $token->save();
        // } else {
            // return redirect('/patients/view')->with('success', 'Session expired you need to login again');
            //return redirect('/patient/create')->with('success', 'Successfully Disabled Medit Link Integration');
        // }
        $usernew=DB::table('users')
        ->where('id', Auth::id())
        ->orderBy('id', 'desc')
        ->first();
        return $usernew;
    }
    return $usershape;
}

private function isTokenExpired($accessToken)
{
    try {
        // Token must have three parts separated by '.'
        $tokenParts = explode('.', $accessToken);
        if (count($tokenParts) !== 3) {
            Log::warning('Invalid JWT format: ' . $accessToken);
            return true; // Consider invalid/malformed token as expired
        }

        // Decode the payload (2nd part of the JWT)
        $payload = json_decode(base64_decode(strtr($tokenParts[1], '-_', '+/')), true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($payload)) {
            Log::error('Failed to decode JWT payload: ' . json_last_error_msg());
            return true;
        }


        // Check for 'exp' field
        if (!isset($payload['exp'])) {
            Log::warning('No expiry (exp) found in JWT payload.');
            return true;
        }

        return ($payload['exp'] < time());

    } catch (\Exception $e) {
        Log::error('Error checking token expiry: ' . $e->getMessage());
        return true;
    }
}
private function searchThreeShapeCases($baseUri, $searchString, $accessToken)
{
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $baseUri . '/api/v3/cases/search?searchString=' . urlencode($searchString) . '&page=0',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $accessToken,
        ],
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response);
}


    //threeshape end

    public function MeditLinkObtainAuthorizationCode()
    {
       // return redirect()->away("https://".env("MEDIT_LINK_OPENAPI_SERVER")."openapi-auth.meditlink.com/oauth/authorize?client_id=".env("MEDIT_LINK_CLIENT_ID")."&response_type=code&redirect_uri=".env("MEDIT_LINK_REDIRECT_URL")."?me&scope=CASE FILE USER GROUP&state=".\Illuminate\Support\Str::random(24));
       Log::info("redirected");
       return redirect()->away("https://openapi-auth.meditlink.com/oauth/authorize?client_id=".env("MEDIT_LINK_CLIENT_ID")."&response_type=code&redirect_uri=".env("MEDIT_LINK_REDIRECT_URL")."?me&scope=CASE FILE USER GROUP&state=".\Illuminate\Support\Str::random(24));
    }
    public function DisableMeditLinkIntegration()
    {
        DB::table('users')->where('id', Auth::user()->id)->update([
            "medit_link_access_token" => null,
            "medit_link_refresh_token" => null,
            "medit_link_group_uuid" => null,
        ]);
        $tokens = MeditLink::where('user_id',Auth::id())->get();
        foreach($tokens as $token)
        {
            $delete= $token->delete();
        }
        return redirect('/patient/create')->with('success', 'Successfully Disabled Medit Link Integration');
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
            CURLOPT_POSTFIELDS => 'code='.$request->get('code').'&state='.$request->get('state').'&grant_type=authorization_code&redirect_uri='.env("MEDIT_LINK_REDIRECT_URL").'?me&scope=CASE%20FILE%20USER%20GROUP',
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

private function MeditLinkGetUserInformation($access_token, $refresh_token)
{
    try {
        $medit_link_group_uuid = null;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://openapi-resources.meditlink.com/v1/me',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $access_token,
                'x-meditlink-client-id: ' . env('MEDIT_LINK_CLIENT_ID'),
                'Host: openapi-resources.meditlink.com'
            ),
        ));

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            throw new \Exception('Curl error: ' . curl_error($curl));
        }

        curl_close($curl);
        $response = json_decode($response);

        Log::info("MeditLink user response: " . json_encode($response));

        if ($response->group->uuid) {
            $medit_link_group_uuid = $response->group->uuid;
        } else {
            $access_token = null;
            $refresh_token = null;
        }

        DB::table('users')->where('id', Auth::user()->id)->update([
            "medit_link_group_uuid" => $medit_link_group_uuid,
            "medit_link_access_token" => $access_token,
            "medit_link_refresh_token" => $refresh_token
        ]);

        // Store tokens in MeditLink table
        MeditLink::updateOrCreate(
            ['user_id' => Auth::id()], // Search condition
            [
                'medit_link_group_uuid' => $medit_link_group_uuid,
                'medit_link_access_token' => $access_token,
                'medit_link_refresh_token' => $refresh_token,
            ]
        );

        return $medit_link_group_uuid;
    } catch (\Throwable $e) {
        Log::error('Error fetching MeditLink user information: ' . $e->getMessage());
        return null;
    }
}

    public function MeditLinkSearchCase(Request $request)
    {
        $results = [];

         Log::info($request);
        // solved by Tapas Web Solution x dotprogrammers
        $token = DB::table('medit_links')
                ->where('user_id', Auth::user()->id)
                ->get();

//        Log::info($token);
        //$medit_client_id
            $medit_link_search_for_case = @$request->post('medit_link_search_for_case') ? $request->post('medit_link_search_for_case') : "";
            $medit_link_start_date = $request->post('medit_link_start_date') ? strtotime(date("Y-m-d", strtotime($request->post('medit_link_start_date')))."T00:00:00Z") * 1000 : "";
            $medit_link_end_date = $request->post('medit_link_end_date') ? strtotime(date("Y-m-d", strtotime($request->post('medit_link_end_date')))."T23:59:59Z") * 1000 : "";
            $curl = curl_init();
          //  dd(env('MEDIT_LINK_CLIENT_ID'));

            curl_setopt_array($curl, array(
             // CURLOPT_URL => 'https://'.env('MEDIT_LINK_OPENAPI_SERVER').'openapi-resources.meditlink.com/v1/cases/search?schema=latest&size=100&page=0&start='.$medit_link_start_date.'&end='.$medit_link_end_date.'&name='.urlencode($medit_link_search_for_case).'&status=',
            //CURLOPT_URL => 'https://stage-openapi-resources.meditlink.com/v1/cases/search?schema=latest&size=100&page=0&start='.$medit_link_start_date.'&end='.$medit_link_end_date.'&name='.$medit_link_search_for_case.'&status=',
            CURLOPT_URL => 'https://openapi-resources.meditlink.com/v1/cases/search?schema=latest&size=100&page=0&start=' . $medit_link_start_date . '&end=' . $medit_link_end_date . '&name=' . urlencode($medit_link_search_for_case) . '&status=',

            CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
              CURLOPT_HTTPHEADER => array(
               // 'Host: '.env('MEDIT_LINK_OPENAPI_SERVER').'openapi-resources.meditlink.com',
               'Host: openapi-resources.meditlink.com',
                'Authorization: Bearer '.$token[0]->medit_link_access_token,
                'x-meditlink-client-id: '.env('MEDIT_LINK_CLIENT_ID'),
                'x-meditlink-group-uuid: '.$token[0]->medit_link_group_uuid,
                'Content-Type: application/json'
              ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $response = json_decode($response);
            log::info("THis is it".json_encode($response));
            // solved by Tapas Web Solution x dotprogrammers

            if(@$response->numberOfElements > 0) {
                $results = $response->content;
            }
        return view("layouts.medit_link_patients", compact("results"))->render();
    }
    public function SetupThreeShapeIntegration()
    {
        return view("integration.3shape_integration");
    }
    public function ThreeShapeObtainAuthorizationCode(Request $request)
    {
       // dd(env('THREE_SHAPE_API_URI'));
        $previousUrl = url()->previous();
        $redirectData = [ 'url' => $previousUrl, 'type' => 'create', 'patient_id' => null];
        if (preg_match('/patient\/edit\/([^\/\?]+)/', $previousUrl, $matches)) {
            $redirectData['type'] = 'edit';
            $redirectData['patient_id'] = $matches[1];
        }
        session(['redirect_back' => $redirectData]);
        $threeshape_api_uri = 'https://identity.3shape.com';
        $threeshape_client_id= 'SecretAlign.Production';
        $threeshape_redirect_uri = 'https://secretalign-user.com/integration-3shape';
        $threeshape_challenge = 'NpwHAEDhRMkZVKi0JyVBvivx9QR3wF-UU1WKobImKwE';

      // return redirect()->away(env('THREE_SHAPE_API_URI').'/connect/authorize?client_id='.env('THREE_SHAPE_CLIENT_ID').'&response_type=code&scope=openid+api+offline_access+communicate.connections.manage+data.companies.read_only+data.users.read_only&redirect_uri='. env('THREE_SHAPE_REDIRECT_URI') .'&code_challenge='.env('THREE_SHAPE_CHALLENGE').'&code_challenge_method=S256&response_mode=query');
        //  return redirect()->away($threeshape_api_uri).'/connect/authorize?client_id='.$threeshape_client_id.'&response_type=code&scope=openid+api+offline_access+communicate.connections.manage+data.companies.read_only+data.users.read_only&redirect_uri='. $threeshape_redirect_uri .'&code_challenge='.$threeshape_challenge.'&code_challenge_method=S256&response_mode=query');
        return redirect()->away(
            $threeshape_api_uri . '/connect/authorize?' . http_build_query([
                'client_id' => $threeshape_client_id,
                'response_type' => 'code',
                'scope' => 'openid api offline_access communicate.connections.manage data.companies.read_only data.users.read_only',
                'redirect_uri' => $threeshape_redirect_uri,
                'code_challenge' => $threeshape_challenge,
                'code_challenge_method' => 'S256',
                'response_mode' => 'query',
            ])
        );

    }
    public function ThreeShapeObtainAuthorizationCodeCallback(Request $request)
    {
        $url = $request->getRequestUri();
        $threeshape_api_uri = 'https://identity.3shape.com';
        $threeshape_client_id= 'SecretAlign.Production';
        $threeshape_redirect_uri = 'https://secretalign-user.com/integration-3shape';
        $threeshape_challenge = 'NpwHAEDhRMkZVKi0JyVBvivx9QR3wF-UU1WKobImKwE';
        $threeshape_code_verifier ='4-WXwM2gMHWu5RoHcYmbcrQPUBYmpgwYlz8_4GHNbXo';
        $query = parse_url($url, PHP_URL_QUERY);
        parse_str($query, $params);
        $code = $params['code'] ?? null;
        if(@$code) {

            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => $threeshape_api_uri.'/connect/token',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => 'code='.$code.'&client_id='.$threeshape_client_id.'&grant_type=authorization_code&redirect_uri='.$threeshape_redirect_uri.'&code_verifier='.$threeshape_code_verifier,
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
              ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $response = json_decode($response);
            Log::info("access_token:".@$response->access_token);
            Log::info("refresh_token:".@$response->refresh_token);
            if(@$response->access_token) {
                DB::table('users')->where('id', Auth::user()->id)->update([
                    "three_shape_access_token" => @$response->access_token,
                    "three_shape_refresh_token" => @$response->refresh_token,
                ]);
                $user  = auth()->user();
                //$user->medit_link_group_uuid = $medit_link_group_uuid;
                $user->three_shape_access_token = @$response->access_token;
                $user->three_shape_refresh_token = @$response->refresh_token;
                $user->save();
                //dd($user);
                $token = new ThreeShape();
                $token->access_token = @$response->access_token;
                $token->refresh_token = @$response->refresh_token;
                $token->user_id = Auth::id();
                $token->save();
               // dd($token);
                $redirectData = session('redirect_back', []);
                session()->forget('redirect_back');
                $type = $redirectData['type'] ?? 'create';
                if($type == 'edit'){
                    $patientId = $redirectData['patient_id'] ?? null;
                    return redirect('/patient/edit/'.$patientId)->with('success', 'Successfully Integrated');
                }
                return redirect('/patient/create')->with('success', 'Successfully Integrated');
            }

        }
        return redirect('/patient/create')->with('error', 'Enable to integrate with 3shape');
    }
    public function DisableThreeShapeIntegration()
    {
        DB::table('users')->where('id', Auth::user()->id)->update([
           "three_shape_access_token" => null,
           "three_shape_refresh_token" => null,
        ]);
        $tokens = ThreeShape::where('user_id',Auth::id())->get();
        foreach($tokens as $token)
        {
            $delete= $token->delete();
        }
        return redirect('/patient/create')->with('success', 'Successfully Disabled 3Shape Integration');
    }
    // public function ThreeShapeSearchCase(Request $request)
    // {
    //     $threeshape_api_uri = 'https://identity.3shape.com';
    //     $threeshape_client_id= 'SecretAlign.Production';
    //     $threeshape_redirect_uri = 'https://secretalign-user.com/integration-3shape';
    //     $threeshape_challenge = 'NpwHAEDhRMkZVKi0JyVBvivx9QR3wF-UU1WKobImKwE';
    //     $threeshape_code_verifier ='4-WXwM2gMHWu5RoHcYmbcrQPUBYmpgwYlz8_4GHNbXo';
    //     $threeshape_region_uri = 'https://eumetadata.3shapecommunicate.com';
    //   // dd(Auth::user());
    //   $token= ThreeShape::where('user_id',Auth::id())->orderBy('id','desc')->first();
    //     $results = [];
    //     if($token != null) {
    //         $three_shape_case_id = trim(@$request->post('three_shape_case_id'));
    //         $three_shape_search_for_case = trim(@$request->post('three_shape_search_for_patient'));
    //         if(!empty($three_shape_case_id) || !empty($three_shape_search_for_case)) {
    //             if(!empty($three_shape_case_id)) {


    //                 $curl = curl_init();

    //                 curl_setopt_array($curl, array(
    //                     CURLOPT_URL => $threeshape_region_uri.'/api/cases/'.$three_shape_case_id,
    //                     CURLOPT_RETURNTRANSFER => true,
    //                     CURLOPT_ENCODING => '',
    //                     CURLOPT_MAXREDIRS => 10,
    //                     CURLOPT_TIMEOUT => 0,
    //                     CURLOPT_FOLLOWLOCATION => true,
    //                     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //                     CURLOPT_CUSTOMREQUEST => 'GET',
    //                     CURLOPT_HTTPHEADER => array(
    //                         'Authorization: Bearer ' . $token->access_token,
    //                     ),
    //                 ));

    //                 $response = curl_exec($curl);

    //                 curl_close($curl);
    //                 $response = json_decode($response);

    //                 if(@$response->Id == $three_shape_case_id) {
    //                     $results = [$response];
    //                 }
    //                 return response()->json($results);
    //             } else {

    //                 $curl = curl_init();

    //                 curl_setopt_array($curl, array(
    //                     CURLOPT_URL => $threeshape_region_uri.'/api/v3/cases/search?searchString='.str_replace(" ", "%20", $three_shape_search_for_case).'&page=0',
    //                     CURLOPT_RETURNTRANSFER => true,
    //                     CURLOPT_ENCODING => '',
    //                     CURLOPT_MAXREDIRS => 10,
    //                     CURLOPT_TIMEOUT => 0,
    //                     CURLOPT_FOLLOWLOCATION => true,
    //                     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //                     CURLOPT_CUSTOMREQUEST => 'GET',
    //                     CURLOPT_HTTPHEADER => array(
    //                         'Authorization: Bearer '.$token->access_token,
    //                     ),
    //                 ));

    //                 $response = curl_exec($curl);

    //                 curl_close($curl);
    //                 $response = json_decode($response);

    //                 if(@$response->Count > 0) {
    //                     $results = @$response->Cases ?? [];
    //                 }
    //             }
    //         }
    //     }
    //     return view("layouts.three_shape_patients", compact("results"))->render();
    // }
    public function ThreeShapeSearchCase(Request $request)
{
    $threeshape_region_uri = 'https://eumetadata.3shapecommunicate.com';

    try {
        // Refresh or validate the token
        $token = $this->refreshThreeShapeToken();

        if ($token) {
            $three_shape_case_id = trim($request->post('three_shape_case_id'));
            $three_shape_search_for_case = trim($request->post('three_shape_search_for_patient'));
            $results = [];

            if (!empty($three_shape_case_id)) {
                $response = $this->fetchThreeShapeCase($threeshape_region_uri, $three_shape_case_id, $token->three_shape_access_token);
                if (@$response->Id == $three_shape_case_id) {
                    $results = [$response];
                }
            } elseif (!empty($three_shape_search_for_case)) {
                $response = $this->searchThreeShapeCases($threeshape_region_uri, $three_shape_search_for_case, $token->three_shape_access_token);
                if (@$response->Count > 0) {
                    $results = $response->Cases ?? [];
                }
            }

            return view("layouts.three_shape_patients", compact("results"))->render();
        }
    } catch (Exception $e) {
       // return response()->json(['error' => $e->getMessage()], 500);
       Log::info($e->getMessage());
      return redirect('/integrations/3shape-disable')->with('success', 'Session expired');
    }
}
private function fetchThreeShapeCase($baseUri, $caseId, $accessToken)
{
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $baseUri . '/api/cases/' . $caseId,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $accessToken,
        ],
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response);
}




}
