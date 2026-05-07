{{-- Patient  treatment type Start --}}
<div class="tab-pane fade" id="pill-tab-li-treatment-type-div" role="tabpanel">
    <div class="container py-3">
        <div class="row g-4">
            <div class="col-12 col-md-6" style="height:580px">
                <div class="plan-box d-flex flex-column justify-content-end" data-plan-type="treatment" style="background-image: url('{{ asset('public') }}/assets/Treatment-Plan-Service-light.webp'); background-size: cover; background-position: center; " onclick="selectPlan(this)">

                    <div style="border-radius: 10px; background-color: #80C6C7; padding: 15px; text-align: justify;height: 160px;">
                        <div class="plan-title text-center text-white mb-2"  >Treatment Planning Service</div>
                        <h4 class="page-title mb-0 font-size-18 text-justify" style="color:#209194;text-align:center">
                            Precise Staging: From Patient's Scans to Print-Ready STL Files
                        </h4>

                        <!-- Centered Button -->
                        <div class="d-flex justify-content-center mt-3">
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#serviceModal">
                                Pricing Info
                            </button>
                        </div>
                    </div>

                    <input type="radio" name="plan" class="d-none" value="1"
                        @if(!empty($patient->treatment_type) && $patient->treatment_type == 1)
                            checked="checked"
                        @elseif($change_plan == 'false')
                            checked="checked"
                        @endif
                    >
                </div>
            </div>

            <div class="col-12 col-md-6" style="height:580px">
                <div class="plan-box d-flex flex-column justify-content-end"  data-plan-type="aligners" style="background-image: url('{{ asset('public') }}/assets/Aligners-light.webp'); background-size: cover; background-position: center; " @if($change_plan == 'true') onclick="selectPlan(this)" @endif>

                    <div style="border-radius: 10px; background-color: #80C6C7; padding: 15px; text-align: justify; height: 160px;">
                        <div class="plan-title text-center text-white mb-2" >Aligners Full-Service</div>
                        <h4 class="page-title mb-0 font-size-18 text-justify" style="color:#209194;text-align:center">
                            Digital Planning and Precision Production
                        </h4>
                    </div>

                    <input type="radio" name="plan" class="d-none" value="2"
                        @if(!empty($patient->treatment_type) && $patient->treatment_type == 2 && $change_plan == 'true')
                            checked="checked"
                        @endif>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3 text-end">
        <button class="btn btn-primary btn-sm waves-effect waves-light px-3 previous-tab" data-target="#pill-tab-li1">Previous</button>
        <button  class="btn btn-primary btn-sm waves-effect waves-light px-3"  id="submit-treatment-plan" @if(empty($patient->treatment_type)) disabled="disabled" @endif>
            Next
        </button>
    </div>
</div>
{{-- Patient  treatment type End --}}
