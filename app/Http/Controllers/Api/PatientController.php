<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Hashids\Hashids;
use Throwable;

class PatientController extends Controller
{
    public function store(Request $request)
    {
        // Get authenticated user
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $userId = $user->id;

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */
        $validator = Validator::make(
            $request->all(),
            [
                'platform'  => 'required|string|max:255',
                'patientId' => 'required|string|max:255',
                'firstName' => 'required|string|max:255',
                'lastName'  => 'required|string|max:255',
                'dob'       => 'nullable|date_format:d-m-Y',
            ],
            [
                'platform.required' => 'Platform is required.',
                'platform.string'   => 'Platform must be a valid string.',
                'platform.max'      => 'Platform may not be greater than 255 characters.',

                'patientId.required' => 'Patient ID is required.',
                'patientId.string'   => 'Patient ID must be a valid string.',
                'patientId.max'      => 'Patient ID may not be greater than 255 characters.',

                'firstName.required' => 'First name is required.',
                'firstName.string'   => 'First name must be a valid string.',
                'firstName.max'      => 'First name may not be greater than 255 characters.',

                'lastName.required' => 'Last name is required.',
                'lastName.string'   => 'Last name must be a valid string.',
                'lastName.max'      => 'Last name may not be greater than 255 characters.',

                'dob.date_format' => 'Date of birth must be in DD-MM-YYYY format.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation failed.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Platform
        |--------------------------------------------------------------------------
        */
        $platform = strtolower(trim($request->input('platform')));

        $platformColumn = match ($platform) {
            'vodett' => 'vodett_patients_id',

            // Add other platforms here when required.
            // 'dental_monitoring' => 'dm_patients_id',

            default => null,
        };

        if (!$platformColumn) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid platform.',
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | DOB
        |--------------------------------------------------------------------------
        */
        $dob = null;

        if ($request->filled('dob')) {
            $dob = Carbon::createFromFormat(
                'd-m-Y',
                $request->input('dob')
            )->format('Y-m-d');
        }

        try {
            /*
            |--------------------------------------------------------------------------
            | Check Existing Patient
            |--------------------------------------------------------------------------
            */
            $existingPatient = DB::table('patients')
                ->where('user_id', $userId)
                ->where($platformColumn, $request->input('patientId'))
                ->first();

            if ($existingPatient) {

                // Get latest treatment plan for existing patient
                $existingTreatmentPlan = DB::table('p_treatment_plans')
                    ->where('patient_id', $existingPatient->id)
                    ->orderByDesc('id')
                    ->first();

                /*
                |--------------------------------------------------------------------------
                | Existing Patient + Treatment Plan
                |--------------------------------------------------------------------------
                */
                if ($existingTreatmentPlan) {

                    $hashids = new Hashids();
                    $hashCode = $hashids->encode($existingTreatmentPlan->id);

                    $redirectUrl = url(
                        '/patient/case-overview/' . $hashCode
                    );

                    return response()->json([
                        'status'  => true,
                        'message' => 'Patient already exists.',
                        'data'    => [
                            'patient_id'       => $existingPatient->id,
                            'treatment_plan_id' => $existingTreatmentPlan->id,
                            'redirect_url'     => $redirectUrl,
                        ],
                    ], 200);
                }

                /*
                |--------------------------------------------------------------------------
                | Existing Patient but No Treatment Plan
                |--------------------------------------------------------------------------
                |
                | This can happen if patient creation succeeded but treatment
                | plan creation failed previously.
                |
                */
                $treatmentPlanId = DB::table('p_treatment_plans')->insertGetId([
                    'patient_id' => $existingPatient->id,
                ]);

                $hashids = new Hashids();
                $hashCode = $hashids->encode($treatmentPlanId);

                $redirectUrl = url(
                    '/patient/case-overview/' . $hashCode
                );

                return response()->json([
                    'status'  => true,
                    'message' => 'Treatment plan created for existing patient.',
                    'data'    => [
                        'patient_id'        => $existingPatient->id,
                        'treatment_plan_id' => $treatmentPlanId,
                        'redirect_url'      => $redirectUrl,
                    ],
                ], 201);
            }

            /*
            |--------------------------------------------------------------------------
            | Create Patient + Treatment Plan
            |--------------------------------------------------------------------------
            */
            $result = DB::transaction(function () use (
                $userId,
                $platformColumn,
                $request,
                $dob
            ) {
                $patientId = DB::table('patients')->insertGetId([
                    'user_id'       => $userId,
                    $platformColumn => $request->input('patientId'),
                    'first_name'    => $request->input('firstName'),
                    'last_name'     => $request->input('lastName'),
                    'dob'           => $dob,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);

                $treatmentPlanId = DB::table('p_treatment_plans')->insertGetId([
                    'patient_id' => $patientId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return [
                    'patient_id'        => $patientId,
                    'treatment_plan_id' => $treatmentPlanId,
                ];
            });

            /*
            |--------------------------------------------------------------------------
            | Redirect URL
            |--------------------------------------------------------------------------
            */
            $hashids = new Hashids();

            $hashCode = $hashids->encode(
                $result['treatment_plan_id']
            );

            $redirectUrl = url(
                '/patient/case-overview/' . $hashCode
            );

            return response()->json([
                'status'  => true,
                'message' => 'Patient created successfully.',
                'data'    => [
                    'patient_id'        => $result['patient_id'],
                    'treatment_plan_id' => $result['treatment_plan_id'],
                    'redirect_url'      => $redirectUrl,
                ],
            ], 201);

        } catch (Throwable $e) {

            report($e);

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong while creating the patient.',
            ], 500);
        }
    }
}
