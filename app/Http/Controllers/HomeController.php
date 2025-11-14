<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Services\NemoTechService;
use App\Jobs\CheckMailJob;
use App\Models\Tasks;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\View;
use Hashids\Hashids;
use App\Services\TasksService;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CheckMail;
class HomeController extends Controller
{
    protected $tasksService;

    public function __construct(TasksService $tasksService)
    {
        $this->tasksService = $tasksService;
        $this->middleware('auth');
        $this->hashids = new Hashids();
        View::share("hashids", $this->hashids);
    }

    public $hashids;

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    private function getNemoStudioService()
    {
        //get nemostudioservice
        $curl_slus = curl_init();

        curl_setopt_array($curl_slus, array(
            CURLOPT_URL => 'https://hub.nemocloud-development.net/SimpleLookUpService/services/graphql',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"query":"query getRegisteredServiceOfCenter($name: String!, $version: String!, $centerId: String) {  getRegisteredServiceOfCenter(name: $name, version: $version, centerId: $centerId) {\\r\\n        cloudId\\r\\n        name\\r\\n        version\\r\\n        url\\r\\n        instanceName\\r\\n        statusMsg\\r\\n        alive\\r\\n        machineIp\\r\\n        }\\r\\n    }","variables":{"name":"NemoStudioService","version":"1.0","centerId":"190-18-06-67"}}',
            CURLOPT_HTTPHEADER => array(
                'User-Agent: AlsecretApp/1.0',
                'Content-Type: application/json'
            ),
        ));

        $response_slus = curl_exec($curl_slus);

        if ($response_slus === false) {
            return null;
            // dd(curl_error($curl_slus));
        }

        curl_close($curl_slus);
        $response_slus = json_decode($response_slus);

        return @$response_slus->data->getRegisteredServiceOfCenter->url;
    }

    private function getStorageService()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://hub.nemocloud-development.net/SimpleLookUpService/services/graphql',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"query":"query getRegisteredServiceOfCenter($name: String!, $version: String!, $centerId: String) {  getRegisteredServiceOfCenter(name: $name, version: $version, centerId: $centerId) {\\n        cloudId\\n        name\\n        version\\n        url\\n        instanceName\\n        statusMsg\\n        alive\\n        machineIp\\n        }\\n    }","variables":{"name":"StorageService","version":"1.0","centerId":"190-18-06-67"}}',
            CURLOPT_HTTPHEADER => array(
                'User-Agent: AlsecretApp/1.0',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        if ($response === false) {
            return null;
            //dd(curl_error($curl));
        }
        curl_close($curl);
        $response = json_decode($response);

        return @$response->data->getRegisteredServiceOfCenter->url;
    }

    private function getNMXRegisterService()
    {

        $curl_slus = curl_init();

        curl_setopt_array($curl_slus, array(
            CURLOPT_URL => 'https://hub.nemocloud-services.com/SimpleLookUpService/services/graphql',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"query":"query getRegisteredServiceOfCenter($name: String!, $version: String!, $centerId: String) {  getRegisteredServiceOfCenter(name: $name, version: $version, centerId: $centerId) {\\r\\n        cloudId\\r\\n        name\\r\\n        version\\r\\n        url\\r\\n        instanceName\\r\\n        statusMsg\\r\\n        alive\\r\\n        machineIp\\r\\n        }\\r\\n    }","variables":{"name":"RegisterService","version":"6.0","centerId":"002-85-89-82"}}',
            CURLOPT_HTTPHEADER => array(
                'User-Agent: AlsecretApp/1.0',
                'Content-Type: application/json'
            ),
        ));

        $response_slus = curl_exec($curl_slus);

        if ($response_slus === false) {
            return null;
            //dd(curl_error($curl_slus));
        }

        curl_close($curl_slus);
        $response_slus = json_decode($response_slus);
        return @$response_slus->data->getRegisteredServiceOfCenter->url;
    }
    private function basicCenterAuth($service_url)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $service_url . 'authentication/authenticate?loginCenters=true&remember=true',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'User-Agent: AlsecretApp/1.0',
                'Content-Type: application/json',
                'Authorization: Basic MjE3LTE2LTgyLTk2OjE3MDQ=',
                'CenterID: 002-85-89-82',
                'Accept: application/json',
            ),
        ));

        $response = curl_exec($curl);
        if ($response === false) {
            return null;
            // dd(curl_error($curl_slus));
        }
        curl_close($curl);
        $response = json_decode($response);
        return @$response->authHeader;
    }

    private function newPatient($nemoservice_url, $credential, $first_name, $last_name, $birth_date)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $nemoservice_url . 'graphql',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"query":"mutation savePatient($value: PatientInput) {\\n  savePatient(value: $value) {\\n    entityId\\n    chn\\n    preffixcode\\n    first\\n    surname\\n    birthdate\\n    type\\n    phone\\n    mobile\\n    fax\\n    email\\n    address\\n    zipcode\\n    city\\n    state\\n    countrycode\\n    externalcode\\n    sex\\n    admissiondate\\n    comments\\n    sendmail\\n    accountId\\n    accountHolder\\n    lastupdate\\n    nif\\n    ssnumber\\n    admission\\n    acls {\\n      entityId {\\n        id\\n        idUser\\n        idCenter\\n      }\\n      actions\\n    }\\n    centerId\\n    labelValue\\n  }\\n}\\n","variables":{"value":{"first":"' . $first_name . '","surname":"' . $last_name . '","birthdate":"' . $birth_date . '","address":null,"admissiondate":null,"chn":"","city":null,"comments":null,"countrycode":null,"email":null,"entityId":null,"externalcode":null,"lastupdate":null,"mobile":null,"nif":null,"phone":null,"sex":null,"ssnumber":null,"state":null,"zipcode":null,"accountHolder":false}}}',
            CURLOPT_HTTPHEADER => array(
                'User-Agent: AlsecretApp/1.0',
                'Content-Type: application/json',
                'Cookie: credential=' . $credential . '; remember_me=true',
            ),
        ));

        $response = curl_exec($curl);
        if ($response === false) {
            return null;
            //dd(curl_error($curl));
        }
        curl_close($curl);
        $response = json_decode($response);
        return @$response->data->savePatient->entityId;
        //dd($response);

    }

    private function retrievePatient($nemoservice_url, $patient_id, $credential)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $nemoservice_url . 'graphql',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"query":"query retrievePatient($id: UUID) {\\n  retrievePatient(id: $id) {\\n    entityId\\n    chn\\n    preffixcode\\n    first\\n    surname\\n    birthdate\\n    type\\n    phone\\n    mobile\\n    fax\\n    email\\n    address\\n    zipcode\\n    city\\n    state\\n    countrycode\\n    externalcode\\n    sex\\n    admissiondate\\n    comments\\n    sendmail\\n    accountId\\n    accountHolder\\n    lastupdate\\n    nif\\n    ssnumber\\n    admission\\n    acls {\\n      entityId {\\n        id\\n        idUser\\n        idCenter\\n      }\\n      actions\\n    }\\n    centerId\\n    labelValue\\n  }\\n}","variables":{"id":"' . $patient_id . '"}}',
            CURLOPT_HTTPHEADER => array(
                'User-Agent: AlsecretApp/1.0',
                'Content-Type: application/json',
                'Cookie: credential=' . $credential . '; remember_me=true'
            ),
        ));

        $response = curl_exec($curl);
        if ($response === false) {
            return null;
        }
        curl_close($curl);
        return $response;
    }

    private function editPatient($nemoservice_url, $patient_id, $credential, $first_name, $last_name, $birth_date, $admission_date)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $nemoservice_url . 'graphql',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"query":"mutation savePatient($value: PatientInput) {\\n  savePatient(value: $value) {\\n    entityId\\n    chn\\n    preffixcode\\n    first\\n    surname\\n    birthdate\\n    type\\n    phone\\n    mobile\\n    fax\\n    email\\n    address\\n    zipcode\\n    city\\n    state\\n    countrycode\\n    externalcode\\n    sex\\n    admissiondate\\n    comments\\n    sendmail\\n    accountId\\n    accountHolder\\n    lastupdate\\n    nif\\n    ssnumber\\n    admission\\n    acls {\\n      entityId {\\n        id\\n        idUser\\n        idCenter\\n      }\\n      actions\\n    }\\n    centerId\\n    labelValue\\n  }\\n}","variables":{"value":{"first":"' . $first_name . '","surname":"' . $last_name . '","birthdate":"' . $birth_date . '","address":null,"admissiondate":"' . $admission_date . '","admission":false,"chn":null,"city":null,"comments":null,"countrycode":null,"email":null,"entityId":"' . $patient_id . '","externalcode":null,"lastupdate":null,"mobile":null,"nif":null,"phone":null,"sendmail":false,"sex":null,"ssnumber":null,"state":null,"zipcode":null,"accountHolder":false}}}',
            CURLOPT_HTTPHEADER => array(
                'User-Agent: AlsecretApp/1.0',
                'Content-Type: application/json',
                'Cookie: credential=' . $credential . '; remember_me=true'
            ),
        ));

        $response = curl_exec($curl);
        if ($response === false) {
            return null;
        }
        curl_close($curl);

        return $response;
    }


    public function createSerie($nemoservice_url, $credential, $patient_id, $serie_id)
    {


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $nemoservice_url . 'graphql',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"query":"mutation createSerie($patientId: UUID, $serieTypeId: UUID) {\\n  createSerie(patientId: $patientId, serieTypeId: $serieTypeId) {\\n    entityId\\n  }\\n}\\n","variables":{"serieTypeId":"' . $serie_id . '","patientId":"' . $patient_id . '"}}',
            CURLOPT_HTTPHEADER => array(
                'User-Agent: AlsecretApp/1.0',
                'Content-Type: application/json',
                'Cookie: credential=' . $credential . '; remember_me=true'
            ),
        ));

        $response = curl_exec($curl);
        if ($response == false) {
            return null;
            //dd(curl_error($curl));
        }
        curl_close($curl);
        $response = json_decode($response);
    }


    private function uploadImage($nemoservice_url, $credential, $patient_id, $serie_id = "")
    {

        $filePath = public_path() . '/no-image.jpg';

        // Open connection
        $ch = curl_init();

        // Set URL and headers
        curl_setopt($ch, CURLOPT_URL, $nemoservice_url . '/documents/createDocument/' . $patient_id . '/Generic');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'User-Agent: AlsecretApp/1.0',
            'Cookie: credential=' . $credential . '; remember_me=true',
            'Content-Type: multipart/form-data; boundary=----WebKitFormBoundaryyGpjXBTKpBeflKVq',
        ));

        // Create header part
        $header = "------WebKitFormBoundaryyGpjXBTKpBeflKVq\r\n";
        $header .= "Content-Disposition: form-data; name=\"DocumentRawDataHeader\"; filename=\"no-image\"\r\n";
        $header .= "Content-Type: application/xml\r\n\r\n";
        $header .= "<?xml version='1.0'?><DocumentRawDataHeader><mimeType>application/vnd.com.nemotec-nsi</mimeType><docName>Generic Image 2023-04-23 17h 31m 26s</docName><orderInSerie>0</orderInSerie><creationDate>" . date("Y-m-d") . "T" . date("H:i:s") . "Z</creationDate></DocumentRawDataHeader>\r\n";

        // Open file and read contents
        $file = fopen($filePath, 'r');
        $fileData = fread($file, filesize($filePath));
        fclose($file);

        // Create file part
        $filePart = "------WebKitFormBoundaryyGpjXBTKpBeflKVq\r\n";
        $filePart .= "Content-Disposition: form-data; name=\"1\"; filename=\"no-image.jpg\"\r\n";
        $filePart .= "Content-Type: image/jpg\r\n\r\n";
        $filePart .= $fileData . "\r\n";

        // Add parts and trailing delimiter
        $body = $header . $filePart . "------WebKitFormBoundaryyGpjXBTKpBeflKVq--";

        // Set POSTFIELDS
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

        // Send request
        $result = curl_exec($ch);

        if ($result  === false) {
            dd(curl_error($ch));
        }

        // Close connection
        curl_close($ch);

        dd($result);
    }

    private function mesh_acquisition($nemoservice_url, $credential, $patient_id, $serie_id = "")
    {
        $modelPathUpper = public_path() . '/scan-UpperJawScan.stl';
        $modelPathLower = public_path() . '/scan-LowerJawScan.stl';


        // Open connection
        $ch = curl_init();

        // Set URL and headers
        curl_setopt($ch, CURLOPT_URL, $nemoservice_url . '/documents/createDocument/' . $patient_id . '/Generic');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'User-Agent: AlsecretApp/1.0',
            'Cookie: credential=' . $credential . '; remember_me=true',
            'Content-Type: multipart/form-data; boundary=----WebKitFormBoundaryyGpjXBTKpBeflKVq',
        ));

        //
        $request = "------WebKitFormBoundaryyGpjXBTKpBeflKVq\r\n";
        $request .= "Content-Disposition: form-data; name=\"DocumentRawDataHeader\"\r\n";
        $request .= "Content-Type: application/xml\r\n\r\n";
        $request .= "<?xml version='1.0'?><DocumentRawDataHeader><creationDate>" . date("Y-m-d") . "T" . date("H:i:s") . "Z</creationDate><docName>Orthodontic Upper-Lower Models 18-07-23, 15h 25 56s</docName><mimeType>application/vnd.com.nemotec-nsf; format=xml</mimeType></DocumentRawDataHeader>\r\n";

        //
        $request .= "------WebKitFormBoundaryyGpjXBTKpBeflKVq\r\n";
        $request .= "Content-Disposition: form-data; name=\"FilesHeader\"; filename=\"model/*\"\r\n";
        $request .= "Content-Type: application/xml; filenameasmimetype=true;\r\n\r\n";
        $request .= "<?xml version='1.0'?><FilesRawDataHeader><filesMimeType>model/*</filesMimeType><numFiles>2</numFiles></FilesRawDataHeader>\r\n";

        //upper model
        $request .= "------WebKitFormBoundaryyGpjXBTKpBeflKVq\r\n";
        $request .= "Content-Disposition: form-data; name=\"FilesHeader\"; filename=\"model/stl;model=upper\"\r\n";
        $request .= "Content-Type: application/xml; filenameasmimetype=true\r\n\r\n";
        $request .= "<?xml version='1.0'?><MeshRawDataHeader><filesMimeType>model/stl; model=upper</filesMimeType><model>upper</model><numFiles>1</numFiles><segmentationThreshold>0</segmentationThreshold></MeshRawDataHeader>\r\n";

        $request .= "------WebKitFormBoundaryyGpjXBTKpBeflKVq\r\n";
        $request .= "Content-Disposition: form-data; name=\"scan-UpperJawScan\"\r\n";
        $request .= "Content-Type: model/stl; model=upper\r\n\r\n";
        // Open file and read contents
        $modelUpper = fopen($modelPathUpper, 'r');
        $modelUpperData = fread($modelUpper, filesize($modelPathUpper));
        fclose($modelUpper);
        $request .= $modelUpperData . "\r\n";

        //lower model
        $request .= "------WebKitFormBoundaryyGpjXBTKpBeflKVq\r\n";
        $request .= "Content-Disposition: form-data; name=\"FilesHeader\"; filename=\"model/stl;model=lower\"\r\n";
        $request .= "Content-Type: application/xml; filenameasmimetype=true\r\n\r\n";
        $request .= "<?xml version='1.0'?><MeshRawDataHeader><filesMimeType>model/stl; model=lower</filesMimeType><model>lower</model><numFiles>1</numFiles><segmentationThreshold>0</segmentationThreshold></MeshRawDataHeader>\r\n";

        $request .= "------WebKitFormBoundaryyGpjXBTKpBeflKVq\r\n";
        $request .= "Content-Disposition: form-data; name=\"scan-LowerJawScan\"\r\n";
        $request .= "Content-Type: model/stl; model=lower\r\n\r\n";
        // Open file and read contents
        $modelLower = fopen($modelPathLower, 'r');
        $modelLowerData = fread($modelLower, filesize($modelPathLower));
        fclose($modelLower);
        $request .= $modelLowerData . "\r\n";

        $request .= "------WebKitFormBoundaryyGpjXBTKpBeflKVq--";




        // Set POSTFIELDS
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);

        // Send request
        $result = curl_exec($ch);

        if ($result  === false) {
            dd(curl_error($ch));
        }

        // Close connection
        curl_close($ch);

        dd($result);
    }

    public function testNemotech()
    {
        $register_service_url = $this->getNMXRegisterService();
        if ($register_service_url) {
            $slime = $this->basicCenterAuth($register_service_url);

            if ($slime) {

                // $storage_service_url = $this->getStorageService();

                // $this->uploadImage($storage_service_url, $slime, "98f7db31-2857-4c1f-9e8f-2341daf744c8");
                return view("test", compact("slime"));


                // $nemoservice_url = $this->getNemoStudioService();
                // if($nemoservice_url) {
                //   //  $new_patient = $this->newPatient($nemoservice_url, $slime, "khalid", "latif", "2000-10-12");
                //   //  $retrieve_patient1 = $this->retrievePatient($nemoservice_url, $new_patient, $slime);

                //    // $this->createSerie($nemoservice_url, $slime, "98f7db31-2857-4c1f-9e8f-2341daf744c8", "99EE8E3B-F6CE-4011-B8F6-E2EECF690848");

                // }
            }
        }
    }



    private function ThreeShapeObtainAccessToken($code)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://staging-identity.3shape.com/connect/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'code=' . $code . '&client_id=SecretAlign.Staging&grant_type=authorization_code&redirect_uri=https%3A%2F%2Falsecret.app%2Fintegration-3shape&code_verifier=8Fapi5V_cIkAcZryEeFZmXP9xR57VVWxTSzVeKuWxE0',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }


    private function ThreeShapeObtainScanFile()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://staging-eumetadata.3shapecommunicate.com/api/cases/c01222fa-7074-4df9-bec8-ba70b0766b9b/attachments/0e998b72d7f29af9abc419ca32d894fef696eeb2',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer eyJhbGciOiJSUzI1NiIsImtpZCI6IjM4RTg2MTA1RjJGRDNBNzkzOUMwODg4QzE4RjlCMUQwRTA3Q0EzQzVSUzI1NiIsIng1dCI6Ik9PaGhCZkw5T25rNXdJaU1HUG14ME9COG84VSIsInR5cCI6ImF0K2p3dCJ9.eyJpc3MiOiJodHRwczovL3N0YWdpbmctaWRlbnRpdHkuM3NoYXBlLmNvbSIsIm5iZiI6MTcwMjI5MDM4MiwiaWF0IjoxNzAyMjkwMzgyLCJleHAiOjE3MDIyOTM5ODIsImF1ZCI6WyJhcGkiLCJjb21tdW5pY2F0ZSIsImRhdGEiXSwic2NvcGUiOlsib3BlbmlkIiwiYXBpIiwiY29tbXVuaWNhdGUuY29ubmVjdGlvbnMubWFuYWdlIiwiZGF0YS5jb21wYW5pZXMucmVhZF9vbmx5IiwiZGF0YS51c2Vycy5yZWFkX29ubHkiLCJvZmZsaW5lX2FjY2VzcyJdLCJhbXIiOlsicHdkIl0sImNsaWVudF9pZCI6IlNlY3JldEFsaWduLlN0YWdpbmciLCJyb2xlIjpbIlN0bEFjY2VzcyIsIkxhYiIsIkVtcGxveWVlLkFkbWluaXN0cmF0b3IiLCJFbXBsb3llZS5Pd25lciIsIlVzZXIuQ29tcGFueS5BZG1pbmlzdHJhdG9yIiwiVXNlci5Db21wYW55Lk93bmVyIl0sInN1YiI6IjQzZmU1Zjc0LTk0YTktNGM5OC04NDIwLTI2M2Y0Y2MzMjg4YiIsImF1dGhfdGltZSI6MTcwMjI5MDM1NCwiaWRwIjoibG9jYWwiLCJuYW1lIjoieW91c2lmYWxqYm91cmlAZ21haWwuY29tIiwiZW1haWwiOiJ5b3VzaWZhbGpib3VyaUBnbWFpbC5jb20iLCJwcmVmZXJyZWRfdXNlcm5hbWUiOiJ5b3VzaWZhbGpib3VyaUBnbWFpbC5jb20iLCJmaXJzdE5hbWUiOiJZb3VzaWYiLCJsYXN0TmFtZSI6IllvdXNpZiIsInZlcmlmaWVkIjoiVHJ1ZSIsImNvbXBhbnlJZCI6IjkzZjU1YjBlLWI0YWYtNDNjMC1iMDI5LTkzMGUwMjU3NGNiZiIsInNlbGVjdGVkQ29tcGFueUlkIjoiOTNmNTViMGUtYjRhZi00M2MwLWIwMjktOTMwZTAyNTc0Y2JmIiwicmVnaW9uSWQiOiIxIiwidXNlcl9pcCI6IjExMy4yMDMuMTk0LjM3Iiwic2lkIjoiMEZDM0I3NDQ0NzNCM0RFNzZFNUY2RjQ5RTQzQjAyRDAifQ.TymQhmvVrvQhZyeC9FpQdGFKhrGnFJZDku1v4u5ecsW9yHRMdLCFC_gOMRFgyJctyLDkYwzVEI2ubRAyYzaK366VnkfdVFUagh1uO9u-kA0D03bRmB0Ejk_cgCSmaKVsZLgO5CJCAwjTp2eah2k-DjD9J5lUkqSub2heowgRBJBrtT82IMbBZglvVyGDdVOW_Np6H63IrW1tU3hAQbjsa4y3cFwMkw21DudshVi0pGCZwax6AnxblADfu98b4PcUsAyZzZyESpynGfnABUFUu6ifJLamvUCCN-QSwIZgvvWEDMuQm_0nGObFvtZE1jGj63rmF_5bNZtdJQUbSUCMOA'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        //dd($response);

        // Specify the path where you want to save the STL file
        $filePath = public_path() . "/test-3shape.stl";

        // Open the file in binary write mode
        $fileHandle = fopen($filePath, 'wb');

        // Write the received data to the file
        fwrite($fileHandle, $response);

        // Close the file handle
        fclose($fileHandle);
    }

    public function index(Request $request)
    {
        $data = [];
        $data['events'] = DB::table('events')->where('is_deleted', 0)
            ->where('date', '>=', date("Y-m-d"))
            ->orderBy('date', 'desc')
            ->limit(100)
            ->get();

        $data['tasks'] = Tasks::distinct()->orderBy('task', 'ASC')->pluck('task');

        if($request->ajax()) {
            return $this->tasksService->getTasks($request);
        }
        if (Auth::user()->role == 'staff' || Auth::user()->role == 'advisor') {
            $data['doctors'] = DB::table('tasks as t')
            ->join('p_treatment_plans as tp', function ($join) {
                $join->on('t.treatment_plan_id', '=', 'tp.id')
                    ->where('tp.is_deleted', 0);
            })
            ->join('patients as p', function ($join) {
                $join->on('p.id', '=', 'tp.patient_id')
                    ->where('p.is_deleted', 0);
            })
            ->join('users as u', 'u.id', '=', 'p.user_id')
            ->select(
                'u.id',
                DB::raw("CONCAT(u.first_name, ' ', u.last_name) as user_full_name")
            )
            ->distinct()
            ->orderBy('user_full_name', 'asc')
            ->get();

            if(Auth::user()->role == 'staff'){
                return view('staff.home', $data);
            }
            return view('advisor.home', $data);
        } elseif (Auth::user()->role == 'lab') {
            $data['plans'] = $tasks = DB::table('tasks as t')
                ->where('t.status', '!=', 'completed')
                ->where('t.type', Auth::user()->role)
                ->join("p_treatment_plans as tp", function ($join) {
                    $join->on("t.treatment_plan_id", "=", "tp.id")->where('tp.is_deleted', 0);
                })
                ->distinct()
                ->orderBy('tp.phase', 'ASC')
                ->pluck('tp.phase');
            return view('lab.home', $data);
        } elseif (Auth::user()->role == 'doctor') {
            return view('doctor.home', $data);
        }



        $data['events'] = DB::table('events')->where('is_deleted', 0)
            ->where('date', '>=', date("Y-m-d"))
            ->orderBy('date', 'desc')
            ->limit(100)
            ->get();

        return view('home', $data);
    }

    public function view_events()
    {
        $events = DB::table('events')
            ->where('is_deleted', 0)
            ->orderBy('date', 'desc')
            ->paginate(20);
        return view("events.show_events", compact("events"));
    }
    public function handle_dropzone_files(Request $request)
    {
        $key = $request->get('key');
        $fname = 'file' . $key;
        if ($request->hasFile($fname)) {
            $file = $request->file($fname);
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('/tests'), $fileName);
            return response()->json([
                "status" => "success",
                "fileName" => $fileName,
            ]);
        }
        return response()->json([
            "status" => "error",
        ]);
    }

    public function handle_dropzone_files_delete(Request $request)
    {
        return response()->json([
            "status" => "success",
        ]);
    }

    public function checkMail(){
        $details = [
            'subject' => 'This is testing mail',
            'title' => 'This is testing mail',
            'email' => "parthkhunt12@gmail.com",
        ];
        $email = $details['email'];
        Notification::route('mail', $email)
                ->notify(new CheckMail($details));
        // CheckMailJob::dispatch($details);
    }

    public function checkMailJob()
    {
        $details = [
            'email' => "parthkhunt12@gmail.com",
            'subject' => 'This is testing mail via job',
            'title' => 'This is testing mail via job',
        ];
        CheckMailJob::dispatch($details);
    }
}
