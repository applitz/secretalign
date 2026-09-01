<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        session(['redirect_back' => $redirectData]);
        return redirect()->away("https://openapi-auth.meditlink.com/oauth/authorize?client_id=".env("MEDIT_LINK_CLIENT_ID")."&response_type=code&redirect_uri=".env("MEDIT_LINK_REDIRECT_URL")."?me&scope=CASE FILE USER GROUP&state=updateScan");
    }
}
