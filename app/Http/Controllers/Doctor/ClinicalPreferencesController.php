<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\DoctorClinicalPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClinicalPreferencesController extends Controller
{
    public function index()
    {
        $preference = DoctorClinicalPreference::where('doctor_id', Auth::id())->first();

        return view('doctor.clinical_preferences.index', compact('preference'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'anterior_teeth_leveling' => 'required|string',
            'pontics_selection' => 'required|string',
            'arch_expansion' => 'required|string',
            'derotation' => 'required|string',
            'long_axis' => 'required|string',
            'crossbite' => 'required|string',
            'intrusion' => 'required|string',
            'extrusion' => 'required|string',
            'rotation_aligner' => 'required|string',
            'translation_aligner' => 'required|string',
            'intrusion_extrusion_aligner' => 'required|string',
            'sequential_distalization_mesialisation' => 'required|string',
            'same_number_aligners_for_both_arches' => 'required|string',
            'same_number_aligners_type' => 'required_if:same_number_aligners_for_both_arches,Yes|nullable|string',
            'en_masse_distalization' => 'required|string',
            'ipr_preference' => 'required|string',
            'ipr_max_limit' => 'required_if:ipr_preference,IPR|nullable|numeric|between:0.1,0.6',
            'additional_comments' => 'nullable|string',
        ]);

        $data = $request->only([
            'anterior_teeth_leveling',
            'pontics_selection',
            'arch_expansion',
            'derotation',
            'long_axis',
            'crossbite',
            'intrusion',
            'extrusion',
            'rotation_aligner',
            'translation_aligner',
            'intrusion_extrusion_aligner',
            'sequential_distalization_mesialisation',
            'same_number_aligners_for_both_arches',
            'same_number_aligners_type',
            'en_masse_distalization',
            'ipr_preference',
            'ipr_max_limit',
            'additional_comments',
        ]);

        if ($data['same_number_aligners_for_both_arches'] !== 'Yes') {
            $data['same_number_aligners_type'] = null;
        }

        if ($data['ipr_preference'] !== 'IPR') {
            $data['ipr_max_limit'] = null;
        }

        DoctorClinicalPreference::updateOrCreate(
            ['doctor_id' => Auth::id()],
            $data
        );

        return redirect()->back()->with('success', 'Clinical preferences saved successfully.');
    }
}
