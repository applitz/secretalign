<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\MeditLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MeditIntegrationController extends Controller
{
    public function MeditLinkObtainAuthorizationCode()
    {
        $previousUrl = url()->previous();
        $redirectData = [ 'url' => $previousUrl, 'type' => 'update-scan', 'patient_id' => null];
        if (preg_match('/patient\/upload-new-scan\/([^\/\?]+)/', $previousUrl, $matches)) {
            $redirectData['type'] = 'update-scan';
            $redirectData['patient_id'] = $matches[1];
        }
        session(['redirect_back_medit' => $redirectData]);
        return redirect()->away("https://openapi-auth.meditlink.com/oauth/authorize?client_id=".env("MEDIT_LINK_CLIENT_ID")."&response_type=code&redirect_uri=".env("MEDIT_LINK_REDIRECT_URL")."?me&scope=CASE FILE USER GROUP&state=updateScan");
    }

    public function DisableMeditLinkIntegration()
    {
        $previousUrl = url()->previous();
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
        return redirect($previousUrl)->with('success', 'Successfully Disabled Medit Link Integration');
    }
}
