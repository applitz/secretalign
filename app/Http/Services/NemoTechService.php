<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Firebase\JWT\JWT;

class NemoTechService
{
    private $centerId = '002-85-89-82';
    private $authorization = 'Basic MjE3LTE2LTgyLTk2OjE3MDQ=';
    private $lookupservice = 'https://hub.nemocloud-services.com/SimpleLookUpService';
    private $patient_id;
    private $first_name;
    private $last_name;
    private $birth_date;
    public function __construct($first_name, $last_name, $birth_date, $patient_id = null)
    {
        $this->patient_id = $patient_id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->birth_date = $birth_date;
    }
    public function authentication()
    {
        $register_service_url = $this->getNMXRegisterService();
        if ($register_service_url) {
            return $this->basicCenterAuth($register_service_url);
        }
        return null;
    }
    public function syncDocuments($patient, $job = null)
    {
        Log::info("started");

        $patientDir = storage_path(
            'PatientFiles/Patient' . $patient->patient_id
        );

        if (!is_dir($patientDir)) {
            mkdir($patientDir, 0775, true);
        }

        if ($job == null) {
            DB::table('sync_queues')->updateOrInsert([
                "treatment_plan_id" => $patient->id,
            ]);
            $job = DB::table('sync_queues')->where('treatment_plan_id', $patient->id)->first();
        }
        if ($patient->nemotech_patient_id == null) {
            DB::table('sync_queues')->where('id', $job->id)->update([
                "is_cancelled" => 1,
            ]);
            return false;
        }
        $slime = $this->authentication();
        if ($slime) {
            $nemoservice_url = $this->getStorageService();
            if ($nemoservice_url) {
                if ($patient->fl_upper_arch != null && $patient->fl_lower_arch != null && $job->is_fl_upper_arch_synced == 0 && $job->is_fl_lower_arch_synced == 0) {
                    $models["modelPathUpper"] = storage_path() . '/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_upper_arch;
                    $models["modelPathLower"] = storage_path() . '/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_lower_arch;
                    if (!file_exists($models["modelPathUpper"]) || !file_exists($models["modelPathLower"])) {
                        DB::table('sync_queues')->where('id', $job->id)->update([
                            "is_fl_upper_arch_synced" => 2,
                            "is_fl_lower_arch_synced" => 2
                        ]);
                    }
                    $models["modelUpperName"] = "Upper Arch Treatment Plan " . $patient->phase;
                    $models["modelLowerName"] = "Lower Arch Treatment Plan " . $patient->phase;
                    $models["modelUpperMimeType"] = trim(explode(".", $patient->fl_upper_arch)[1]);
                    $models["modelLowerMimeType"] = trim(explode(".", $patient->fl_lower_arch)[1]);
                    $models["modelName"] = "Upper-Lower Models " . $patient->phase;
                    $this->mesh_acquisition($nemoservice_url, $slime, $models, $patient->nemotech_patient_id, $serie_id = "");
                    DB::table('sync_queues')->where('id', $job->id)->update([
                        "is_fl_upper_arch_synced" => 1,
                        "is_fl_lower_arch_synced" => 1,
                    ]);
                }
                if ($patient->fl_front != null && $job->fl_front_synced == 0) {
                    $image["fileName"] = "Front Treatment Plan " . $patient->phase;
                    $image["originalFileName"] = $patient->fl_front;
                    $image["filePath"] = storage_path() . '/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_front;
                    $fileSize = filesize($image["filePath"]);
                    if (!file_exists($image["filePath"]) || $fileSize === false || $fileSize === 0) {
                        DB::table('sync_queues')->where('id', $job->id)->update([
                            "fl_front_synced" => 2
                        ]);
                    }
                    $this->uploadImage($nemoservice_url, $slime, $image, $patient->nemotech_patient_id, $serie_id = "");
                    DB::table('sync_queues')->where('id', $job->id)->update([
                        "fl_front_synced" => 1,
                    ]);
                }
                if ($patient->fl_smile != null && $job->fl_smile_synced == 0) {
                    $image["fileName"] = "Smile Treatment Plan " . $patient->phase;
                    $image["originalFileName"] = $patient->fl_smile;
                    $image["filePath"] = storage_path() . '/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_smile;
                    $fileSize = filesize($image["filePath"]);
                    if (!file_exists($image["filePath"]) || $fileSize === false || $fileSize === 0) {
                        DB::table('sync_queues')->where('id', $job->id)->update([
                            "fl_smile_synced" => 2
                        ]);
                    }
                    $this->uploadImage($nemoservice_url, $slime, $image, $patient->nemotech_patient_id, $serie_id = "");
                    DB::table('sync_queues')->where('id', $job->id)->update([
                        "fl_smile_synced" => 1,
                    ]);
                }
                if ($patient->fl_profile != null && $job->fl_profile_synced == 0) {
                    $image["fileName"] = "Profile Treatment Plan " . $patient->phase;
                    $image["originalFileName"] = $patient->fl_profile;
                    $image["filePath"] = storage_path() . '/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_profile;
                    $fileSize = filesize($image["filePath"]);
                    if (!file_exists($image["filePath"]) || $fileSize === false || $fileSize === 0) {
                        DB::table('sync_queues')->where('id', $job->id)->update([
                            "fl_profile_synced" => 2
                        ]);
                    }
                    $this->uploadImage($nemoservice_url, $slime, $image, $patient->nemotech_patient_id, $serie_id = "");
                    DB::table('sync_queues')->where('id', $job->id)->update([
                        "fl_profile_synced" => 1,
                    ]);
                }
                if ($patient->fl_frontal != null && $job->fl_frontal_synced == 0) {
                    $image["fileName"] = "Frontal Treatment Plan " . $patient->phase;
                    $image["originalFileName"] = $patient->fl_frontal;
                    $image["filePath"] = storage_path() . '/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_frontal;
                    $fileSize = filesize($image["filePath"]);
                    if (!file_exists($image["filePath"]) || $fileSize === false || $fileSize === 0) {
                        DB::table('sync_queues')->where('id', $job->id)->update([
                            "fl_frontal_synced" => 2
                        ]);
                    }
                    $this->uploadImage($nemoservice_url, $slime, $image, $patient->nemotech_patient_id, $serie_id = "");
                    DB::table('sync_queues')->where('id', $job->id)->update([
                        "fl_frontal_synced" => 1,
                    ]);
                }
                if ($patient->fl_right_buccal != null && $job->fl_right_buccal_synced == 0) {
                    $image["fileName"] = "Right Buccal Treatment Plan " . $patient->phase;
                    $image["originalFileName"] = $patient->fl_right_buccal;
                    $image["filePath"] = storage_path() . '/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_right_buccal;
                    $fileSize = filesize($image["filePath"]);
                    if (!file_exists($image["filePath"]) || $fileSize === false || $fileSize === 0) {
                        DB::table('sync_queues')->where('id', $job->id)->update([
                            "fl_right_buccal_synced" => 2
                        ]);
                    }
                    $this->uploadImage($nemoservice_url, $slime, $image, $patient->nemotech_patient_id, $serie_id = "");
                    DB::table('sync_queues')->where('id', $job->id)->update([
                        "fl_right_buccal_synced" => 1,
                    ]);
                }
                if ($patient->fl_left_buccal != null && $job->fl_left_buccal_synced == 0) {
                    $image["fileName"] = "Left Buccal Treatment Plan " . $patient->phase;
                    $image["originalFileName"] = $patient->fl_left_buccal;
                    $image["filePath"] = storage_path() . '/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_left_buccal;
                    $fileSize = filesize($image["filePath"]);
                    if (!file_exists($image["filePath"]) || $fileSize === false || $fileSize === 0) {
                        DB::table('sync_queues')->where('id', $job->id)->update([
                            "fl_left_buccal_synced" => 2
                        ]);
                    }
                    $this->uploadImage($nemoservice_url, $slime, $image, $patient->nemotech_patient_id, $serie_id = "");
                    DB::table('sync_queues')->where('id', $job->id)->update([
                        "fl_left_buccal_synced" => 1,
                    ]);
                }
                if ($patient->fl_upper_occlusal != null && $job->fl_upper_occlusal_synced == 0) {
                    $image["fileName"] = "Upper Occlusal Treatment Plan " . $patient->phase;
                    $image["originalFileName"] = $patient->fl_upper_occlusal;
                    $image["filePath"] = storage_path() . '/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_upper_occlusal;
                    $fileSize = filesize($image["filePath"]);
                    if (!file_exists($image["filePath"]) || $fileSize === false || $fileSize === 0) {
                        DB::table('sync_queues')->where('id', $job->id)->update([
                            "fl_upper_occlusal_synced" => 2
                        ]);
                    }
                    $this->uploadImage($nemoservice_url, $slime, $image, $patient->nemotech_patient_id, $serie_id = "");
                    DB::table('sync_queues')->where('id', $job->id)->update([
                        "fl_upper_occlusal_synced" => 1,
                    ]);
                }
                if ($patient->fl_lower_occlusal != null && $job->fl_lower_occlusal_synced == 0) {
                    $image["fileName"] = "Lower Occlusal Treatment Plan " . $patient->phase;
                    $image["originalFileName"] = $patient->fl_lower_occlusal;
                    $image["filePath"] = storage_path() . '/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_lower_occlusal;
                    $fileSize = filesize($image["filePath"]);
                    if (!file_exists($image["filePath"]) || $fileSize === false || $fileSize === 0) {
                        DB::table('sync_queues')->where('id', $job->id)->update([
                            "fl_lower_occlusal_synced" => 2
                        ]);
                        throw new \Exception("One or both model files are missing at {$image["filePath"]}");
                    }
                    $this->uploadImage($nemoservice_url, $slime, $image, $patient->nemotech_patient_id, $serie_id = "");
                    DB::table('sync_queues')->where('id', $job->id)->update([
                        "fl_lower_occlusal_synced" => 1,
                    ]);
                }
                if ($patient->fl_panorex != null && $job->fl_panorex_synced == 0) {
                    $image["fileName"] = "Panorex Treatment Plan " . $patient->phase;
                    $image["originalFileName"] = $patient->fl_panorex;
                    $image["filePath"] = storage_path() . '/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_panorex;
                    $fileSize = filesize($image["filePath"]);
                    if (!file_exists($image["filePath"]) || $fileSize === false || $fileSize === 0) {
                        DB::table('sync_queues')->where('id', $job->id)->update([
                            "fl_panorex_synced" => 2
                        ]);
                    }
                    $this->uploadImage($nemoservice_url, $slime, $image, $patient->nemotech_patient_id, $serie_id = "");
                    DB::table('sync_queues')->where('id', $job->id)->update([
                        "fl_panorex_synced" => 1,
                    ]);
                }
                if ($patient->fl_lateral_ceph != null && $job->fl_lateral_ceph_synced == 0) {
                    $image["fileName"] = "Lateral Ceph Treatment Plan " . $patient->phase;
                    $image["originalFileName"] = $patient->fl_lateral_ceph;
                    $image["filePath"] = storage_path() . '/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_lateral_ceph;
                    $fileSize = filesize($image["filePath"]);
                    if (!file_exists($image["filePath"]) || $fileSize === false || $fileSize === 0) {
                        DB::table('sync_queues')->where('id', $job->id)->update([
                            "fl_lateral_ceph_synced" => 2
                        ]);
                    }
                    $this->uploadImage($nemoservice_url, $slime, $image, $patient->nemotech_patient_id, $serie_id = "");
                    DB::table('sync_queues')->where('id', $job->id)->update([
                        "fl_lateral_ceph_synced" => 1,
                    ]);
                }
                DB::table('sync_queues')->where('id', $job->id)->update([
                    "is_synced" => 1,
                    "synced_at" => date("Y-m-d H:i:s"),
                ]);
                return true;
            }
        }
        Log::info("ended");
    }
    public function syncPatient()
    {
        if ($this->patient_id == null) {
            $slime = $this->authentication();
            if ($slime) {
                $nemoservice_url = $this->getNemoStudioService();
                if ($nemoservice_url) {
                    $new_patient = $this->newPatient($nemoservice_url, $slime, $this->first_name, $this->last_name, $this->birth_date);
                    return $new_patient;
                }
            }
        } else {
            $slime = $this->authentication();
            if ($slime) {
                $nemoservice_url = $this->getNemoStudioService();
                if ($nemoservice_url) {
                    $retrieve_patient = $this->retrievePatient($nemoservice_url, $this->patient_id, $slime);
                    $retrieve_patient = json_decode($retrieve_patient);
                    if (@$retrieve_patient->data->retrievePatient[0]->entityId) {
                        $edit_patient = $this->editPatient($nemoservice_url, $this->patient_id, $slime, $this->first_name, $this->last_name, $this->birth_date, $retrieve_patient->data->retrievePatient[0]->admissiondate);
                        return $edit_patient;
                    }
                }
            }
        }
        return null;
    }
    private function getNemoStudioService()
    {
        //get nemostudioservice
        $curl_slus = curl_init();

        curl_setopt_array($curl_slus, array(
            CURLOPT_URL => $this->lookupservice . '/services/graphql',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"query":"query getRegisteredServiceOfCenter($name: String!, $version: String!, $centerId: String) {  getRegisteredServiceOfCenter(name: $name, version: $version, centerId: $centerId) {\\r\\n        cloudId\\r\\n        name\\r\\n        version\\r\\n        url\\r\\n        instanceName\\r\\n        statusMsg\\r\\n        alive\\r\\n        machineIp\\r\\n        }\\r\\n    }","variables":{"name":"NemoStudioService","version":"1.0","centerId":"' . $this->centerId . '"}}',
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
            CURLOPT_URL => 'https://hub.nemocloud-services.com/SimpleLookUpService/services/graphql',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"query":"query getRegisteredServiceOfCenter($name: String!, $version: String!, $centerId: String) {  getRegisteredServiceOfCenter(name: $name, version: $version, centerId: $centerId) {\\n        cloudId\\n        name\\n        version\\n        url\\n        instanceName\\n        statusMsg\\n        alive\\n        machineIp\\n        }\\n    }","variables":{"name":"StorageService","version":"1.0","centerId":"' . $this->centerId . '"}}',
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
            CURLOPT_URL => $this->lookupservice . '/services/graphql',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"query":"query getRegisteredServiceOfCenter($name: String!, $version: String!, $centerId: String) {  getRegisteredServiceOfCenter(name: $name, version: $version, centerId: $centerId) {\\r\\n        cloudId\\r\\n        name\\r\\n        version\\r\\n        url\\r\\n        instanceName\\r\\n        statusMsg\\r\\n        alive\\r\\n        machineIp\\r\\n        }\\r\\n    }","variables":{"name":"RegisterService","version":"6.0","centerId":"' . $this->centerId . '"}}',
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
                'Authorization: ' . $this->authorization,
                'CenterID: ' . $this->centerId,
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

        $response = json_decode($response);
        return @$response->data->savePatient->entityId;
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
        return @$response->data->createSerie->entityId;
    }


    private function uploadImage($nemoservice_url, $credential, $image, $patient_id, $serie_id = "")
    {

        $filename = $image["fileName"];
        $original_filename = $image["originalFileName"];
        $filePath = $image["filePath"];
        if (!file_exists($filePath)) {
            throw new \Exception("File not found: " . $filePath);
        }


        $ext = explode(".", $original_filename);
        $filename_without_ext = $ext[0];
        $ext = $ext[1];
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
        $header .= "Content-Disposition: form-data; name=\"DocumentRawDataHeader\"; filename=\"" . $filename_without_ext . "\"\r\n";
        $header .= "Content-Type: application/xml\r\n\r\n";
        $header .= "<?xml version='1.0'?><DocumentRawDataHeader><mimeType>application/vnd.com.nemotec-nsi</mimeType><docName>" . $filename . "</docName><creationDate>" . date("Y-m-d") . "T" . date("H:i:s") . "Z</creationDate></DocumentRawDataHeader>\r\n";

        // Open file and read contents
        // $file = fopen($filePath, 'r');
        $file = fopen($filePath, 'rb');

        // $fileData = fread($file, filesize($filePath));
        $fileSize = filesize($filePath);

        if ($fileSize === false || $fileSize === 0) {
            throw new \Exception("File is empty or unreadable: " . $filePath);
        }

        $fileData = fread($file, $fileSize);

        fclose($file);

        // Create file part
        $filePart = "------WebKitFormBoundaryyGpjXBTKpBeflKVq\r\n";
        $filePart .= "Content-Disposition: form-data; name=\"1\"; filename=\"" . $original_filename . "\"\r\n";
        $filePart .= "Content-Type: image/" . $ext . "\r\n\r\n";
        $filePart .= $fileData . "\r\n";

        // Add parts and trailing delimiter
        $body = $header . $filePart . "------WebKitFormBoundaryyGpjXBTKpBeflKVq--";

        // Set POSTFIELDS
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

        // Send request
        $result = curl_exec($ch);

        if ($result  === false) {

            //dd(curl_error($ch));
        }

        // Close connection
        curl_close($ch);
    }

    private function mesh_acquisition($nemoservice_url, $credential, $models, $patient_id, $serie_id = "")
    {

        $modelPathUpper = $models["modelPathUpper"];
        $modelPathLower = $models["modelPathLower"];
        $modelUpperName = $models["modelUpperName"];
        $modelLowerName = $models["modelLowerName"];
        $modelUpperMimeType = $models["modelUpperMimeType"];
        $modelLowerMimeType = $models["modelLowerMimeType"];
        $modelName = $models["modelName"];

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
        $request .= "<?xml version='1.0'?><DocumentRawDataHeader><creationDate>" . date("Y-m-d") . "T" . date("H:i:s") . "Z</creationDate><docName>" . $modelName . "</docName><mimeType>application/vnd.com.nemotec-nsf; format=xml</mimeType></DocumentRawDataHeader>\r\n";

        //
        $request .= "------WebKitFormBoundaryyGpjXBTKpBeflKVq\r\n";
        $request .= "Content-Disposition: form-data; name=\"FilesHeader\"; filename=\"model/*\"\r\n";
        $request .= "Content-Type: application/xml; filenameasmimetype=true;\r\n\r\n";
        $request .= "<?xml version='1.0'?><FilesRawDataHeader><filesMimeType>model/*</filesMimeType><numFiles>2</numFiles></FilesRawDataHeader>\r\n";

        //upper model
        $request .= "------WebKitFormBoundaryyGpjXBTKpBeflKVq\r\n";
        $request .= "Content-Disposition: form-data; name=\"FilesHeader\"; filename=\"model/" . $modelUpperMimeType . ";model=upper\"\r\n";
        $request .= "Content-Type: application/xml; filenameasmimetype=true\r\n\r\n";
        $request .= "<?xml version='1.0'?><MeshRawDataHeader><filesMimeType>model/" . $modelUpperMimeType . "; model=upper</filesMimeType><model>upper</model><numFiles>1</numFiles><segmentationThreshold>0</segmentationThreshold></MeshRawDataHeader>\r\n";

        $request .= "------WebKitFormBoundaryyGpjXBTKpBeflKVq\r\n";
        $request .= "Content-Disposition: form-data; name=\"" . $modelUpperName . "\"\r\n";
        $request .= "Content-Type: model/" . $modelUpperMimeType . "; model=upper\r\n\r\n";
        // Open file and read contents
        //$modelUpper = fopen($modelPathUpper, 'r');
        if (!file_exists($modelPathUpper)) {
            // Check if it's an STL file
            if (strtolower($modelUpperMimeType) === 'stl') {
                // Try the ".stl" version instead
                $alternativePath = str_replace('.stl.stl', '.stl', $modelPathUpper);

                if (file_exists($alternativePath)) {
                    $modelPathUpper = $alternativePath; // Use ".stl" if found
                } else {
                    throw new \Exception("File not found: " . $modelPathUpper);
                }
            }
            // Check if it's a PLY file
            else if (strtolower($modelUpperMimeType) === 'ply') {
                // Try alternative paths for PLY files
                $alternativePath = str_replace('.ply.ply', '.ply', $modelPathUpper);

                if (file_exists($alternativePath)) {
                    $modelPathUpper = $alternativePath; // Use ".ply" if found
                } else {
                    throw new \Exception("File not found: " . $modelPathUpper);
                }
            } else {
                throw new \Exception("File not found: " . $modelPathUpper);
            }
        }

        // Now, safely open the file since it exists
        $modelUpper = fopen($modelPathUpper, 'r');
        $modelUpperData = fread($modelUpper, filesize($modelPathUpper));
        fclose($modelUpper);
        // $modelUpperData = fread($modelUpper, filesize($modelPathUpper));
        // fclose($modelUpper);
        $request .= $modelUpperData . "\r\n";

        //lower model
        $request .= "------WebKitFormBoundaryyGpjXBTKpBeflKVq\r\n";
        $request .= "Content-Disposition: form-data; name=\"FilesHeader\"; filename=\"model/" . $modelLowerMimeType . ";model=lower\"\r\n";
        $request .= "Content-Type: application/xml; filenameasmimetype=true\r\n\r\n";
        $request .= "<?xml version='1.0'?><MeshRawDataHeader><filesMimeType>model/" . $modelLowerMimeType . "; model=lower</filesMimeType><model>lower</model><numFiles>1</numFiles><segmentationThreshold>0</segmentationThreshold></MeshRawDataHeader>\r\n";

        $request .= "------WebKitFormBoundaryyGpjXBTKpBeflKVq\r\n";
        $request .= "Content-Disposition: form-data; name=\"" . $modelLowerName . "\"\r\n";
        $request .= "Content-Type: model/" . $modelLowerMimeType . "; model=lower\r\n\r\n";
        // Open file and read contents
        // $modelLower = fopen($modelPathLower, 'r');
        // $modelLowerData = fread($modelLower, filesize($modelPathLower));
        // fclose($modelLower);

        if (!file_exists($modelPathLower)) {
            // Check if it's an STL file
            if (strtolower($modelLowerMimeType) === 'stl') {
                // Try the ".stl" version instead
                $alternativePath = str_replace('.stl.stl', '.stl', $modelPathLower);

                if (file_exists($alternativePath)) {
                    $modelPathLower = $alternativePath; // Use ".stl" if found
                } else {
                    throw new \Exception("File not found: " . $modelPathLower);
                }
            }
            // Check if it's a PLY file
            else if (strtolower($modelLowerMimeType) === 'ply') {
                // Try alternative paths for PLY files
                $alternativePath = str_replace('.ply.ply', '.ply', $modelPathLower);

                if (file_exists($alternativePath)) {
                    $modelPathLower = $alternativePath; // Use ".ply" if found
                } else {
                    throw new \Exception("File not found: " . $modelPathLower);
                }
            } else {
                throw new \Exception("File not found: " . $modelPathLower);
            }
        }

        // Now, safely open the file since it exists
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
            $error = curl_error($ch);
            throw new \Exception("cURL Error: $error");
            //dd(curl_error($ch));
        }

        // Close connection
        curl_close($ch);
    }
    public function basicCentrePreAuth(){

        $partnerId = "38";
        $doctorId = "230-45-80-84";
        $centerId = '002-85-89-82';
        $issuedAt = time();
        $base64UrlSecret = "QKtXPoH8P8FG9wgLbIFmUYSMpPOObjkHFx9EVa64MhEM81GLfXQZg28DhkSvqvxY_vCbQrBi5_bclA1YPLAJcw";
        $secretKey = base64_decode(strtr($base64UrlSecret, '-_', '+/'));
        $payload = ['iss' => $partnerId,'sub' => $doctorId,'iat' => $issuedAt,'atc' => $centerId];
        $authCode = JWT::encode($payload, $secretKey, 'HS256');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://community.nemocloud-services.com/NMXRegisterService/authentication/authenticate?loginCenters=true&remember=true',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Partner ' . $authCode,
                'Accept: application/json',
            ),
        ));

        $response = curl_exec($curl);
        if ($response === false) {
            return null;
        }
        curl_close($curl);
        $response = json_decode($response);
        return @$response->authHeader;
    }

    public function getSecretToken($nemoTechId, $phase)
    {

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://community.nemocloud-development.net/NMXRegisterService/authentication/authenticate?loginCenters=true&remember=true',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => '{"query":"","variables":{}}',
            CURLOPT_HTTPHEADER => [
                'Authorization: Simse FD2BD93162C5D90060AB0EFF03CE48B285E78B2283D4F308799D2BD4D246AB1A4B085163972A417DB55F23D102A8E838A93658',
                'Content-Type: application/json',
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        if (!$response) {
            return 1;
        }

        $cleaned = trim(preg_replace('/\s+/', ' ', $response));

        if (!preg_match('/Simse\s+([A-Za-z0-9]+)/', $cleaned, $matches)) {
            return 1;
        }

        $token = 'Simse ' . preg_replace('/[^A-Za-z0-9\s]/', '', $matches[1]);
        $queryDataPatientId = [
            "query" => "query documentsOfPatient(\$patientId: UUID) {
                documentsOfPatient(patientId: \$patientId) {
                    id
                    name
                }
            }",
            "variables" => [
                "patientId" => $nemoTechId,
            ]
        ];
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://downloads-default.nemocloud-services.com/DownloadUploadService/storage/graphql',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($queryDataPatientId),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'User-Agent: AlsecretApp/1.0',
                'Authorization: ' . $token,
            ],
        ]);

        $response2 = curl_exec($curl);
        curl_close($curl);

        if (!$response2) {
            return 2;
        }

        $allDocumentLink = json_decode($response2, true);
        $targetFile = "TP{$phase} SETUPGO.nsf";
        $documents = $allDocumentLink['data']['documentsOfPatient'] ?? [];
        $documentId = null;

        foreach ($documents as $doc) {
            if (isset($doc['name']) && stripos($doc['name'], $targetFile) !== false) {
                $documentId = $doc['id'];
                break;
            }
        }

        if ($documentId) {
            $queryData = [
                "query" => "mutation shareDocument(\$id: UUID, \$shared: Boolean, \$version: Int) {
                    shareDocument(documentId: \$id, shared: \$shared, version: \$version) {
                        id
                        link
                        sharedLink
                        doctorSharedLink
                        patientSharedLink
                    }
                }",
                "variables" => [
                    "id" => $documentId,
                    "shared" => true,
                ]
            ];

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://downloads-default.nemocloud-services.com/DownloadUploadService/storage/graphql',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($queryData),
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'Authorization: ' . $token,
                    'User-Agent: AlsecretApp/1.0',
                ],
            ]);

            $response3 = curl_exec($curl);
            curl_close($curl);
            if (!$response3) {
                return 4;
            }
            $allSharedDocumentLink = json_decode($response3, true);
            $documents = $allSharedDocumentLink['data']['shareDocument'] ?? [];
            return $documents;
        } else {
            return 3;
        }

    }


    public function getSecretIframeToken(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://community.nemocloud-development.net/NMXRegisterService/authentication/authenticate?loginCenters=true&remember=true',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_POSTFIELDS =>'{"query":"","variables":{}}',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Simse FD2BD93162C5D90060AB0EFF03CE48B285E78B2283D4F308799D2BD4D246AB1A4B085163972A417DB55F23D102A8E838A93658',
            'Content-Type: application/json',
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        if ($response) {
            $cleaned = trim(preg_replace('/\s+/', ' ', $response));
            if (preg_match('/Simse\s+([A-Za-z0-9]+)/', $cleaned, $matches)) {
                $token = 'Simse ' . $matches[1];
            } else {
                die('token not found. Response was: <br><pre>' . htmlspecialchars($cleaned) . '</pre>');
            }

            $token = trim(preg_replace('/[^A-Za-z0-9\s]/', '', $token));
            return $token;
        }
    }
}
