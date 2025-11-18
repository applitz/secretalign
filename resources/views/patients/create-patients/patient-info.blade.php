{{-- Patient Info Start --}}
    <div class="tab-pane fade show active" id="pill-tab-div1" role="tabpanel">
        <div class="mb-3">
            <label class="form-label">Patient ID</label>
            <input type="text" class="form-control" placeholder="patient ID" disabled value="{{$hashids->encode($patient->patient_id)}}">
        </div>
        <div class="mb-3">
            <label class="form-label" for="first_name">First Name</label>
            <input class="form-control " id="first_name" type="text" placeholder="First Name"
                name="first_name" value="{{ @$patient->first_name }}">
        </div>
        <div class="mb-3">
            <label class="form-label" for="last_name">Last Name</label>
            <input class="form-control " id="last_name" type="text" placeholder="Last Name"
                name="last_name" value="{{ @$patient->last_name }}">
        </div>
        <div class="mb-3">
            <label class="form-label" for="dob">Date of Birth</label>
            <input class="form-control pickr" id="dob" name="dob" value="{{ @$patient->dob }}"
                type="text" placeholder="d/m/y"
                data-options='{"dateFormat":"d/m/y","disableMobile":true}' />
        </div>
        <div class="mb-3 text-end">
            <button class="btn btn-primary btn-sm waves-effect waves-light px-3" id="submit-patient-info"
                @if (@$patient->first_name && @$patient->last_name && @$patient->dob)
                    fn="1"
                @else
                    fn="0"
                @endif>Next</button>
        </div>
    </div>
{{-- Patient Info End --}}
