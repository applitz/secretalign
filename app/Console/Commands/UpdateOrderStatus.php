<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateOrderStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update order status to completed for completed treatment plans';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $treatmentPlans = DB::table('p_treatment_plans')
        //     ->where('is_completed', 1)
        //     ->get();

        // foreach ($treatmentPlans as $plan) {
        //     DB::table('orders')
        //         ->where('treatment_plan_id', $plan->id)
        //         ->update(['status' => 'completed']);
        // }
        
        $treatmentPlans = DB::table('p_treatment_plans')
            ->where('is_rejected', 1)
            ->get();

        foreach ($treatmentPlans as $plan) {
            DB::table('orders')
                ->where('treatment_plan_id', $plan->id)
                ->update(['status' => 'cancelled']);
        }

        $this->info('Order statuses updated successfully!');
        $this->info('Total: ' . $treatmentPlans->count());

        return 0;
    }
}
