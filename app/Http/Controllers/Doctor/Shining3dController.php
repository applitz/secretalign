<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Shining3Details;
use Carbon\Carbon;

class Shining3dController extends Controller
{
    protected string $baseUrl;

    public function setRegion(string $region): self
    {
        $this->baseUrl = match ($region) {
            'frankfurt' => 'https://ffapi.shining3d.com',
            'hz' => 'https://hzapi.shining3d.com',
            'ru' => 'https://ruapi.shining3d.com',
            'silicon' => 'https://sapi.shining3d.com',
            'tokyo' => 'https://tkapi.shining3d.com',
            default => throw new \InvalidArgumentException('Invalid region'),
        };
        return $this;
    }
    public function getOrderList(Request $request)
    {
        $region = $request->input('region');
        $this->setRegion($region);

        $authToken = $this->getValidAuthToken($region);

        $response = Http::withHeaders([
            'X-Auth-Token' => $authToken,
            'X-Auth-AppKey' => config('shining3d.shining3d_app_key'),
            'X-Auth-AppID' => config('shining3d.shining3d_app_id'),
        ])->get($this->baseUrl . '/sdk/dental/order/list', [
            'orgType' => 'lab',
            'orgCode' => config('shining3d.shining3d_orgcode'),
            'page' => 1,
            'pageSize' => 10,
            'startOn' => Carbon::parse($request->input('start_date'))->format('Y-m-d'),
            'endOn' => Carbon::parse($request->input('end_date'))->format('Y-m-d'),
        ]);
        return $response->json();
    }


    protected function getValidAuthToken(string $region): string
    {
        $detail = Shining3Details::where('node', $region)->first();

        if ($detail?->auth_token) {
            return $detail->auth_token;
        }
        $csrf = $this->getCsrfToken($region);
        $auth = $this->connect($region, $csrf);

        return $auth;
    }


    protected function getCsrfToken(string $region): string
    {
        $detail = Shining3Details::where('node', $region)->first();
        if ($detail?->auth_csrf) {
            return $detail->auth_csrf;
        }


        $response = Http::withHeaders([
            'X-Auth-AppID' => config('shining3d.shining3d_app_id'),
        ])->get($this->baseUrl . '/sdk/auth/dynamicEncodeToken')->json();


        Shining3Details::updateOrCreate(
            ['node' => $region],
            ['auth_csrf' => $response['result'], 'auth_token' => null]
        );


        return $response['result'];
    }


    protected function connect(string $region, string $csrfToken): string
    {
        $url = $this->baseUrl . '/sdk/auth/connect?publicKey=' . config('shining3d.shining3d_public_key');
        $body = json_encode(['publicKey' => config('shining3d.shining3d_public_key')]);


        $response = Http::withHeaders([
        'X-Auth-CSRF' => $csrfToken,
        'X-Auth-AppKey' => config('shining3d.shining3d_app_key'),
        'X-Auth-AppID' => config('shining3d.shining3d_app_id'),
        'Content-Type' => 'application/json',
        ])->withBody($body, 'application/json')->send('GET', $url)->json();


        if (($response['status'] ?? null) !== 'success') {
        throw new \RuntimeException('Failed to get auth token');
        }


        Shining3Details::updateOrCreate(
        ['node' => $region],
        ['auth_token' => $response['result']]
        );


        return $response['result'];
    }

}
