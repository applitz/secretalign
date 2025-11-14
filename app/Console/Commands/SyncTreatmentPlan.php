<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Http\Services\NemoTechService;
use Illuminate\Support\Facades\Log;

class SyncTreatmentPlan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Nemo Data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = DB::table('sync_queues')
        ->where('is_synced', 0)
        ->where('is_cancelled', 0)
        ->orderBy('id', 'desc')
        ->get();

    foreach ($data as $row) {
        try {
            $patient = DB::table('p_treatment_plans as tp')
                ->where('tp.is_deleted', 0)
                ->where('tp.id', $row->treatment_plan_id)
                ->join("patients as p", function ($join) {
                    $join->on("tp.patient_id", '=', "p.id")
                        ->where('p.is_deleted', 0);
                })
                ->select("tp.*", "p.first_name", "p.last_name", "p.dob", "p.user_id", "p.pricing_package", "p.nemotech_patient_id")
                ->first();

            if (!$patient) {
                Log::warning("Patient not found for treatment plan ID: {$row->treatment_plan_id}");
                continue; // Skip this iteration and move to the next one
            }

            if ($patient->first_name == null) {
                $patient->first_name = 'Mr';
            }

            $nemotech = new NemoTechService(
                $patient->first_name,
                $patient->last_name,
                $patient->dob,
                $patient->nemotech_patient_id
            );

            $nemotech->syncDocuments($patient);

        } catch (\Exception $e) {
            Log::error("Error processing treatment plan ID: {$row->treatment_plan_id}. Error: " . $e->getMessage());
            continue; // Ignore this entry and move to the next one
        }
    }

    $this->info('Successfully synced.');
       
    }
}
