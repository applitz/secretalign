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

    public function DisableThreeShapeIntegration()
    {
        $previousUrl = url()->previous();
        dd($previousUrl);
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

    public function ThreeShapeObtainAuthorizationCode(Request $request)
    {
       // dd(env('THREE_SHAPE_API_URI'));
        $previousUrl = url()->previous();
        $redirectData = [ 'url' => $previousUrl, 'type' => 'update-scan', 'patient_id' => null];
        if (preg_match('/patient\/upload-new-scan\/([^\/\?]+)/', $previousUrl, $matches)) {
            $redirectData['type'] = 'update-scan';
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
}

