<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\ThreeShape;
use App\Models\MeditLink;
use Exception;

class IntegrationDoctorController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ThreeShapeObtainAuthorizationCode(Request $request)
    {
       // dd(env('THREE_SHAPE_API_URI'));
        $previousUrl = url()->previous();
        $redirectData = [ 'url' => $previousUrl, 'type' => 'update-scan', 'patient_id' => null];
        if (preg_match('/patient\/edit\/([^\/\?]+)/', $previousUrl, $matches)) {
            $redirectData['type'] = 'edit';
            $redirectData['patient_id'] = $matches[1];
        }
        session(['redirect_back_url' => $redirectData]);
        $threeshape_api_uri = 'https://identity.3shape.com';
        $threeshape_client_id= 'SecretAlign.Production';
        $threeshape_redirect_uri = 'https://secretalign-user.com/patient/integration-3shape';
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
        dd($url);
        $threeshape_api_uri = 'https://identity.3shape.com';
        $threeshape_client_id= 'SecretAlign.Production';
        $threeshape_redirect_uri = 'https://secretalign-user.com/patient/integration-3shape';
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
                $redirectData = session('redirect_back_url', []);
                session()->forget('redirect_back_url');
                $type = $redirectData['type'] ?? 'update-scan';
                if($type == 'edit'){
                    $patientId = $redirectData['patient_id'] ?? null;
                    return redirect('/patient/upload-new-scan/'.$patientId)->with('success', 'Successfully Integrated');
                }
                return redirect('/patient/create')->with('success', 'Successfully Integrated');
            }

        }
        return redirect('/patient/create')->with('error', 'Enable to integrate with 3shape');
    }
}

