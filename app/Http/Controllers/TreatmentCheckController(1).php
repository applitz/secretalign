<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TreatmentCheck;
use Illuminate\Support\Facades\View;
use Hashids\Hashids;
use PDF;

class TreatmentCheckController extends Controller
{
    public $hashids;
    public function __construct()
    {
        $this->middleware('auth');
        $this->hashids = new Hashids();
        View::share("hashids", $this->hashids);
    }
    public function store(Request $request)
    {
        $treatmentCheck = TreatmentCheck::updateOrCreate(
            ['patient_id' => $request->patient_id],
            [
                'attachments_model' => $request->attachments_model ? 1 : 0,
                'bars_model' => $request->bars_model ? 1 : 0,
                'name_patient' => $request->name_patient ? 1 : 0,
                'model_dashboard' => $request->model_dashboard ? 1 : 0,
                'cutouts_hooks' => $request->cutouts_hooks ? 1 : 0,
                'schnittlinie' => $request->schnittlinie ? 1 : 0,
                'zahlen_vergleichen' => $request->zahlen_vergleichen ? 1 : 0,
                'cutouts_schiene' => $request->cutouts_schiene ? 1 : 0,
                'folie_runtergenommen' => $request->folie_runtergenommen ? 1 : 0,
                'richtig_einpacken' => $request->richtig_einpacken ? 1 : 0,
                'richtiger_asr' => $request->richtiger_asr ? 1 : 0,
                'coworker_name' => $request->coworker_name,
            ]
        );
        
        return response()->json(['success' => 'Treatment plan checklist saved successfully!','id' => $this->hashids->encode($treatmentCheck->id)], 200);

    }
    
    public function preview($id){
        
        $id = $this->hashids->decode($id)[0];
        $treatment = TreatmentCheck::findOrFail($id);
        return view('patients.treatment_check', compact('treatment'));
        
    }
    
    public function export($id){
        $id = $this->hashids->decode($id)[0];
        $treatment = TreatmentCheck::findOrFail($id);
        $pdf = PDF::loadView('patients.treatment_export_pdf', compact('treatment'))->setPaper('a4', 'portrait');
        return $pdf->download('TreatmentChecklist_' . $this->hashids->encode($treatment->id) . '.pdf');
    }
}
