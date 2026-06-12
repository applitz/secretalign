@extends('layouts.app_base_horizontal')

@section('content')
<div class="page-content">
    {{-- @include('layouts.breadcrumb') --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18" >Clinical Preferences</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('/home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Clinical Preferences</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Clinical Preferences</h4>
                    <!-- <p class="text-muted">These clinical preferences apply by default to all of your SECRET patients. If you would like to make a patient specific request, please note this on the product order form during the submission process.</p> -->

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('clinical-preferences.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-12 mb-4">
                                <span class="fw-bold font-sans-serif text-900">Anterior Teeth Leveling: Upper incisal edges:</span>
                                @php
                                    $anteriorOptions = [
                                        'Canines and centrals at same level, laterals 0.5mm above' => 'Canines and centrals at same level, laterals 0.5mm above',
                                        'Laterals 0.5mm above centrals, canines 0.5mm above laterals' => 'Laterals 0.5mm above centrals, canines 0.5mm above laterals',
                                        'All anterior teeth at same level' => 'All anterior teeth at same level',
                                    ];
                                @endphp
                                @foreach($anteriorOptions as $value => $label)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="anterior_teeth_leveling" id="anterior_{{ md5($value) }}" value="{{ $value }}"
                                            {{ old('anterior_teeth_leveling', $preference->anterior_teeth_leveling ?? '') === $value ? 'checked' : '' }}>
                                        <label class="form-check-label" for="anterior_{{ md5($value) }}">{{ $label }}</label>
                                    </div>
                                @endforeach
                                @error('anterior_teeth_leveling')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12 mb-4">
                                <span class="fw-bold font-sans-serif text-900">Pontics (i: By default, pontics will be placed when spaces are larger than 4mm)</span>
                                @php
                                    $ponticsOptions = [
                                        'Always apply pontics' => 'Always apply pontics',
                                        'Apply pontics in the anterior region/ bridges in the posterior region.' => 'Apply pontics in the anterior region/ bridges in the posterior region.',
                                        'Always apply bridges' => 'Always apply bridges',
                                    ];
                                @endphp
                                @foreach($ponticsOptions as $value => $label)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="pontics_selection" id="pontics_{{ md5($value) }}" value="{{ $value }}"
                                            {{ old('pontics_selection', $preference->pontics_selection ?? '') === $value ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pontics_{{ md5($value) }}">{{ $label }}</label>
                                    </div>
                                @endforeach
                                @error('pontics_selection')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12 mb-4">
                                <span class="fw-bold font-sans-serif text-900">Arch Expansion</span>
                                <p class="text-muted">After derotations and bucco-palatal uprighting, what is the max amount of acceptable bodily posterior expansion?</p>
                                @php
                                    $archOptions = ['1 mm', '2 mm', '3 mm', '4 mm'];
                                @endphp
                                @foreach($archOptions as $value)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="arch_expansion" id="arch_{{ str_replace(' ', '_', $value) }}" value="{{ $value }}"
                                            {{ old('arch_expansion', $preference->arch_expansion ?? '') === $value ? 'checked' : '' }}>
                                        <label class="form-check-label" for="arch_{{ str_replace(' ', '_', $value) }}">{{ $value }}</label>
                                    </div>
                                @endforeach
                                @error('arch_expansion')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12 mb-4">
                                <span class="fw-bold font-sans-serif text-900">Overcorrection</span>
                                <div class="row">
                                    @php
                                        $overcorrectionGroups = [
                                            'Derotation' => ['0%', '10%', '20%'],
                                            'Long axis' => ['0%', '10%', '20%'],
                                            'Crossbite' => ['0mm', '1mm per side', '2mm per side'],
                                            'Intrusion' => ['0%', '10%', '20%'],
                                            'Extrusion' => ['0%', '10%', '20%'],
                                        ];
                                    @endphp
                                    @foreach($overcorrectionGroups as $group => $options)
                                        @php
                                            $fieldName = strtolower(str_replace([' ', '%', 'mm'], ['_', '', ''], $group));
                                        @endphp
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <label class="form-label">{{ $group }}</label>
                                            @foreach($options as $option)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="{{ $fieldName }}" id="{{ $fieldName }}_{{ md5($group . $option) }}" value="{{ $option }}"
                                                        {{ old($fieldName, $preference->{$fieldName} ?? '') === $option ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="{{ $fieldName }}_{{ md5($group . $option) }}">{{ $option }}</label>
                                                </div>
                                            @endforeach
                                            @error($fieldName)<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-12 mb-4">
                                <span class="fw-bold font-sans-serif text-900">Ensure even tooth movement per stage</span>
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 mb-3">
                                        <label class="form-label">Rotation / Aligner</label>
                                        @php $rotationOptions = ['2.0° (Standard)', '1.5°', '1.0°']; @endphp
                                        @foreach($rotationOptions as $value)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="rotation_aligner" id="rotation_{{ str_replace([' ', '.', '(', ')'], ['_', '', '', ''], $value) }}" value="{{ $value }}"
                                                    {{ old('rotation_aligner', $preference->rotation_aligner ?? '') === $value ? 'checked' : '' }}>
                                                <label class="form-check-label" for="rotation_{{ str_replace([' ', '.', '(', ')'], ['_', '', '', ''], $value) }}">{{ $value }}</label>
                                            </div>
                                        @endforeach
                                        @error('rotation_aligner')<div class="text-danger">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-lg-4 col-md-6 mb-3">
                                        <label class="form-label">Translation / Aligner</label>
                                        @php $translationOptions = ['0.2 mm (Standard)', '0.15 mm', '0.1 mm']; @endphp
                                        @foreach($translationOptions as $value)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="translation_aligner" id="translation_{{ str_replace([' ', '.', '(', ')'], ['_', '', '', ''], $value) }}" value="{{ $value }}"
                                                    {{ old('translation_aligner', $preference->translation_aligner ?? '') === $value ? 'checked' : '' }}>
                                                <label class="form-check-label" for="translation_{{ str_replace([' ', '.', '(', ')'], ['_', '', '', ''], $value) }}">{{ $value }}</label>
                                            </div>
                                        @endforeach
                                        @error('translation_aligner')<div class="text-danger">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-lg-4 col-md-6 mb-3">
                                        <label class="form-label">Intrusion or extrusion / Aligner</label>
                                        @php $intrusionOptions = ['0.15 mm', '0.12 mm (Standard)']; @endphp
                                        @foreach($intrusionOptions as $value)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="intrusion_extrusion_aligner" id="intrusion_{{ str_replace([' ', '.', '(', ')'], ['_', '', '', ''], $value) }}" value="{{ $value }}"
                                                    {{ old('intrusion_extrusion_aligner', $preference->intrusion_extrusion_aligner ?? '') === $value ? 'checked' : '' }}>
                                                <label class="form-check-label" for="intrusion_{{ str_replace([' ', '.', '(', ')'], ['_', '', '', ''], $value) }}">{{ $value }}</label>
                                            </div>
                                        @endforeach
                                        @error('intrusion_extrusion_aligner')<div class="text-danger">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mb-4">
                                <span class="fw-bold font-sans-serif text-900">Perform sequential distalization/mesialisation</span>
                                @php $sequentialOptions = ['30%', '50%', '100%']; @endphp
                                @foreach($sequentialOptions as $value)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sequential_distalization_mesialisation" id="sequential_{{ str_replace('%', '', $value) }}" value="{{ $value }}"
                                            {{ old('sequential_distalization_mesialisation', $preference->sequential_distalization_mesialisation ?? '') === $value ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sequential_{{ str_replace('%', '', $value) }}">{{ $value }}</label>
                                    </div>
                                @endforeach
                                @error('sequential_distalization_mesialisation')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12 mb-4">
                                <span class="fw-bold font-sans-serif text-900">Ensure same number of aligners for both arches</span>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="same_number_aligners_for_both_arches" id="same_aligners_yes" value="Yes"
                                        {{ old('same_number_aligners_for_both_arches', $preference->same_number_aligners_for_both_arches ?? '') === 'Yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="same_aligners_yes">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="same_number_aligners_for_both_arches" id="same_aligners_no" value="No"
                                        {{ old('same_number_aligners_for_both_arches', $preference->same_number_aligners_for_both_arches ?? '') === 'No' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="same_aligners_no">No</label>
                                </div>
                                @error('same_number_aligners_for_both_arches')<div class="text-danger">{{ $message }}</div>@enderror

                                <div id="same-number-type-section" class="mt-3 {{ old('same_number_aligners_for_both_arches', $preference->same_number_aligners_for_both_arches ?? '') !== 'Yes' ? 'd-none' : '' }}">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="same_number_aligners_type" id="same_number_passive" value="Passive aligners"
                                            {{ old('same_number_aligners_type', $preference->same_number_aligners_type ?? '') === 'Passive aligners' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="same_number_passive">Passive aligners</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="same_number_aligners_type" id="same_number_active" value="Active Aligners"
                                            {{ old('same_number_aligners_type', $preference->same_number_aligners_type ?? '') === 'Active Aligners' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="same_number_active">Active Aligners</label>
                                    </div>
                                </div>
                                @error('same_number_aligners_type')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12 mb-4">
                                <span class="fw-bold font-sans-serif text-900">En masse distalization while using distal slider?</span>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="en_masse_distalization" id="distalization_yes" value="Yes"
                                        {{ old('en_masse_distalization', $preference->en_masse_distalization ?? '') === 'Yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="distalization_yes">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="en_masse_distalization" id="distalization_no" value="No"
                                        {{ old('en_masse_distalization', $preference->en_masse_distalization ?? '') === 'No' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="distalization_no">No</label>
                                </div>
                                @error('en_masse_distalization')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12 mb-4">
                                <span class="fw-medium font-sans-serif text-900" >Resolve Tooth Size Issues</span>
                                <div class="mb-3">
                                    <label>Please select one of the following options.</label>
                                    @php
                                        $iprOptions = ['IPR' => 'IPR', 'Restorative (No IPR)' => 'Restorative (No IPR)', 'Accept best fit (No IPR/Restorative)' => 'Accept best fit (No IPR/Restorative)'];
                                    @endphp
                                    @foreach($iprOptions as $value => $label)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="ipr_preference" id="ipr_{{ md5($value) }}" value="{{ $value }}"
                                                {{ old('ipr_preference', $preference->ipr_preference ?? '') === $value ? 'checked' : '' }}>
                                            <label class="form-check-label" for="ipr_{{ md5($value) }}">{{ $label }}</label>
                                        </div>
                                    @endforeach
                                    @error('ipr_preference')<div class="text-danger">{{ $message }}</div>@enderror

                                    <div id="ipr-limit-section" class="mt-3 {{ old('ipr_preference', $preference->ipr_preference ?? '') !== 'IPR' ? 'd-none' : '' }}">

                                        <span class="fw-medium font-sans-serif text-900">Location</span>
                                        <div class="mb-3">
                                            <label class="form-label">Location Upper</label>
                                            <select class="form-select" name="ipr_location_upper">
                                                <option value="">Select</option>
                                                @foreach(['3-3', '4-4', '6-6'] as $location)
                                                    <option value="{{ $location }}" {{ old('ipr_location_upper', $preference->ipr_location_upper ?? '') === $location ? 'selected' : '' }}>{{ $location }}</option>
                                                @endforeach
                                            </select>
                                            @error('ipr_location_upper')<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Location Lower</label>
                                            <select class="form-select" name="ipr_location_lower">
                                                <option value="">Select</option>
                                                @foreach(['3-3', '4-4', '6-6'] as $location)
                                                    <option value="{{ $location }}" {{ old('ipr_location_lower', $preference->ipr_location_lower ?? '') === $location ? 'selected' : '' }}>{{ $location }}</option>
                                                @endforeach
                                            </select>
                                            @error('ipr_location_lower')<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>

                                        <span class="fw-medium font-sans-serif text-900">Limits</span>
                                        <label class="form-label">Maximum Ant. IPR/Contact 0.1-0.6mm</label>
                                        <input class="form-control" type="number" name="ipr_max_limit" step="0.05" min="0.1" max="0.6" value="{{ old('ipr_max_limit', $preference->ipr_max_limit ?? '') }}">
                                        @error('ipr_max_limit')<div class="text-danger">{{ $message }}</div>@enderror

                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label">Additional Comments</label>
                                <textarea class="form-control" name="additional_comments" rows="4">{{ old('additional_comments', $preference->additional_comments ?? '') }}</textarea>
                                @error('additional_comments')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Save Preferences</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    function toggleIprLimit() {
        var selected = document.querySelector('input[name="ipr_preference"]:checked');
        var section = document.getElementById('ipr-limit-section');
        if (section) {
            section.classList.toggle('d-none', !selected || selected.value !== 'IPR');
        }
    }

    function toggleSameNumberType() {
        var selected = document.querySelector('input[name="same_number_aligners_for_both_arches"]:checked');
        var section = document.getElementById('same-number-type-section');
        if (section) {
            section.classList.toggle('d-none', !selected || selected.value !== 'Yes');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('input[name="ipr_preference"]').forEach(function (input) {
            input.addEventListener('change', toggleIprLimit);
        });
        document.querySelectorAll('input[name="same_number_aligners_for_both_arches"]').forEach(function (input) {
            input.addEventListener('change', toggleSameNumberType);
        });

        toggleIprLimit();
        toggleSameNumberType();
    });
</script>
@endsection
