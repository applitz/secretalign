<div class="card" id="panel">
    <div class="card-body py-4">
        <div class="mb-3">
            <label>Comment</label>
            <textarea class="form-control" name="comment" id="comment" placeholder="Write the comment here"></textarea>
        </div>

        <div class="mb-3">
            <label>Attachments (Optional)</label>
            <input type="file" class="form-control" name="attachments[]" id="attachments"
                multiple>
        </div>

        @if (Auth::user()->role == 'doctor')
            @if ($patient->is_treatment_submitted == 1 && $patient->is_completed == 0)
                @php
                    $calculation = new \App\Http\Services\PriceCalculation();
                    $final_deposit = $calculation->calc(Auth::user()->tier, $patient);

                @endphp
                @if ($final_deposit != 0)
                    <div class="alert alert-success border-2 d-flex align-items-center"
                        role="alert">
                        <div class="bg-success me-3 icon-item"><span
                                class="fas fa-check-circle text-white fs-3"></span>
                        </div>
                        <p class="mb-0 flex-1">You have to pay final amount of
                            <strong>€{{ number_format($final_deposit, 2) }}</strong>. Click
                            "Approve" to
                            complete case.
                        </p>

                    </div>
                @endif
                <div class="mb-3 ps-2">
                    <div class="form-check">
                        <input class="form-check-input" id="terms2" type="checkbox"
                            name="terms2" value="1" />
                        <label class="form-check-label" for="terms2">I did not change the
                            current set up. Please click on (<b class="text-danger">Request
                                Modification</b>), if you apply any modifications to the current
                            setup.</label>
                    </div>
                </div>
            @endif
        @endif

        @if (Auth::user()->role == 'lab' && $patient->case_holder == 'lab')
            <div class="mb-3">
                <label>Files Link</label>
                <input class="form-control hyperlink" placeholder="https://"
                    value="{{ $patient->treatment_link }}" name="treatment_link"
                    id="treatment_link">
            </div>

            <div class="mb-3">
                <label>Doctor's Link 1</label>
                <input class="form-control hyperlink" placeholder="https://"
                    value="{{ $patient->iframe_link }}" name="iframe_link" id="iframe_link">
            </div>

            <div class="mb-3">
                <label>Doctor's Link 2 (Optional) </label>
                <input class="form-control hyperlink" placeholder="https://"
                    value="{{ $patient->iframe_link_optional }}" name="iframe_link_optional" id="iframe_link_optional">
            </div>

            <div class="mb-3">
                <label>Patient's Link</label>
                <input class="form-control hyperlink patient_link" placeholder="https://"
                    value="{{ $patient->patient_link }}" name="patient_link"
                    id="patient_link">
            </div>
        @endif

        @if (Auth::user()->role == 'staff' && $patient->case_holder == 'staff')
            @if ($patient->treatment_link != null)
                <div class="mb-3">
                    <label>Files Link</label>
                    <input class="form-control hyperlink" placeholder="https://"
                        value="{{ $patient->treatment_link }}" name="treatment_link"
                        id="treatment_link">
                </div>
            @endif
            @if ($patient->is_treatment_submitted == 0 && $patient->is_continue == 0)
                <div class="mb-3">
                    <label>Lab</label>
                    <select class="form-select" name="lab" id="lab">
                        <option value="" disabled selected>Select Lab</option>
                        @foreach ($labs as $lab)
                            <option value="{{ $lab->id }}">{{ $lab->first_name }}
                                {{ $lab->last_name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if ($patient->is_sent_to_lab == 1 && $patient->is_treatment_submitted == 1 && $patient->is_completed == 0)
                <div class="mb-3">
                    <label>No. of Steps (Aligner)</label>
                    <input type="number" name="no_of_steps" id="no_of_steps"
                        @if ($patient->aligner_steps != 0) value="{{ $patient->aligner_steps }}" @endif
                        class="form-control" placeholder="No. of Steps">
                </div>
            @endif

            @if ($patient->is_completed == 1 || $patient->is_continue == 1)
                <div class="mb-3">
                    <label>Tracking Nr.</label>
                    <input type="text" name="tracking_id" id="tracking_id"
                        value="{{ @$patient->tracking_id }}" placeholder="https://"
                        class="form-control hyper link">
                </div>
            @endif

        @endif


        <div class="btn-group">
            {{-- doctor button start --}}
            @if (Auth::user()->role == 'doctor' && $patient->case_holder == 'doctor')
                @if ($patient->is_completed == 0)
                    @if ($patient->is_treatment_submitted == 1 && $patient->is_sent_to_lab == 1)
                        <button class="btn btn-success rounded-pill me-1 mb-1 btn-action"
                            id="approve">
                            <span class="fas fa-check-circle me-1"
                                data-fa-transform="shrink-3"></span>
                            Approve
                        </button>
                    @endif
                    <button class="btn btn-warning rounded-pill me-1 mb-1 btn-action"
                        type="button" id="doctor-send-to-staff">
                        <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>Send
                        for Modification
                    </button>
                @endif
            @endif

            {{-- doctor button end --}}
            {{-- staff button start --}}

            @if (Auth::user()->role == 'staff' && $patient->case_holder == 'staff')
                @if ($patient->is_treatment_submitted == 1 && $patient->is_completed == 0 && $patient->is_continue == 0)
                    <button class="btn btn-success rounded-pill me-1 mb-1 btn-action" data-send_back_to_doctor_status="0"
                        type="button" id="staff-send-to-doctor-for-approval">
                        <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>
                        Send for Doctor Approval
                    </button>
                @endif
                @if ($patient->recommended_advisor != null && $patient->is_completed == 0 && $patient->is_continue == 0)

                    @if ($patient->advisor_id == null)
                        <button class="btn btn-info rounded-pill me-1 mb-1"
                            data-bs-toggle="modal" data-bs-target="#advisorModal">
                            <span class="fas fa-cube me-2"></span>SEND TO ➡
                            {{ $advisor->first_name }} {{ $advisor->last_name }}
                            (€{{ $advisor->advisor_price }})
                        </button>

                        <!-- Advisor Modal Start -->
                    @endif
                    @if ($patient->advisor_id != null)
                        <button class="btn btn-info rounded-pill me-1 mb-1"
                            data-bs-toggle="modal" data-bs-target="#advisorModal">
                            <span class="fas fa-cube me-2"></span>SEND MOD. TO ➡
                            {{ $advisor->first_name }} {{ $advisor->last_name }}
                            (€{{ $advisor->advisor_price }})
                        </button>
                    @endif
                    <div class="modal fade" id="advisorModal" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Send to
                                        Advisor</h5>
                                    <button type="button" class="btn-close"
                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST"
                                        action="{{ url('/patient/case-overview/send-from-staff-to-advisor') }}">
                                        @csrf
                                        <input type="hidden" name="treatment_plan_id"
                                            value="{{ $patient->id }}" />
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label>Choose Advisor</label>
                                                <select class="form-contorl form-select"
                                                    name="advisor" required>
                                                    <option value="{{ $advisor->id }}"
                                                        selected>{{ $advisor->first_name }}
                                                        {{ $advisor->last_name }}
                                                        (€{{ $advisor->advisor_price }})</option>
                                                    @foreach ($advisors as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->first_name }}
                                                            {{ $item->last_name }}
                                                            (€{{ $item->advisor_price }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label>Comment for Advisor</label>
                                                    <textarea class="form-control" name="comment" id="" placeholder="Write the comment here"></textarea>
                                                </div>
                                            </div>

                                        </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Send to
                                        Advisor</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($patient->is_treatment_submitted == 0 || ($patient->is_continue == 1 || $patient->patient_link == null))
                    <button class="btn btn-warning rounded-pill me-1 mb-1 btn-action" data-staff-send-to-doctor-for-approval="0"
                        type="button" id="staff-send-to-doctor">
                        <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>Send
                        to
                        Doctor for
                        Modification
                    </button>
                @endif
                @if ($patient->is_treatment_submitted == 0 && $patient->is_continue == 0)
                    <button class="btn btn-success rounded-pill me-1 mb-1 btn-action"
                        type="button" id="request-treatment">
                        <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>Send
                        to
                        Lab
                    </button>
                @endif
                @if ($patient->is_treatment_submitted == 1 &&
                        $patient->is_approved == 0 &&
                        $patient->is_completed == 0 &&
                        $patient->is_continue == 0)
                    <button class="btn btn-warning rounded-pill me-1 mb-1 btn-action"
                        type="button" id="send-to-lab-for-modification">
                        <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>Send
                        to Lab for modification
                    </button>
                @endif
                @if (($patient->is_completed == 1 || $patient->is_continue == 1) && $patient->tracking_id == null)
                    {{-- <button class="btn btn-danger rounded-pill me-1 mb-1 btn-action"
                        type="button" id="send-to-doctor-for-modification">
                        <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>
                        Send to Doctoer for modification
                    </button> --}}
                    {{-- <button class="btn btn-warning rounded-pill me-1 mb-1 btn-action" data-staff-send-to-doctor-for-approval="1"
                        type="button" id="staff-send-to-doctor">
                        <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>Send
                        to
                        Doctor for
                        Modification
                    </button> --}}
                    <button class="btn btn-warning rounded-pill me-1 mb-1 btn-action"
                        type="button" id="staff-submit-tracking-id">
                        <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>
                        Submit Tracking Nr.
                    </button>
                @endif
                @if ($patient->is_continue == 1 || $patient->is_completed == 1)
                    <button class="btn btn-success rounded-pill me-1 mb-1 btn-action"
                        type="button" id="staff-send-to-lab">
                        <span class="fas fa-share me-1"
                            data-fa-transform="shrink-3"></span>Request Files
                    </button>
                @endif
                @if ($patient->is_completed == 0)
                    <button class="btn btn-danger rounded-pill me-1 mb-1 btn-action"
                        type="button" id="staff-reject-treatment">
                        <span class="fas fa-tint-slash me-1"
                            data-fa-transform="shrink-3"></span>Reject Treatment
                    </button>
                @endif
            @endif
            {{-- staff button end --}}

            {{-- lab button start --}}
            @if (Auth::user()->role == 'lab' && $patient->case_holder == 'lab')
                @if ($patient->is_treatment_submitted == 0 && $patient->is_continue == 0)
                    <button class="btn btn-success rounded-pill me-1 mb-1 btn-action"
                        type="button" id="submit-treatment">
                        <span class="fas fa-share me-1"
                            data-fa-transform="shrink-3"></span>Submit
                        Treatment
                    </button>
                    <button class="btn btn-danger rounded-pill me-1 mb-1 btn-action"
                        type="button" id="lab-cancel-request">
                        Cancel Request<span class="fas fa-tint-slash"
                            data-fa-transform="shrink-3"></span>
                    </button>
                @endif
                @if ($patient->is_treatment_submitted == 1 || $patient->is_continue == 1)
                    <button class="btn btn-success rounded-pill me-1 mb-1 btn-action"
                        type="button" id="submit-treatment">
                        <span class="fas fa-share me-1"
                            data-fa-transform="shrink-3"></span>Submit
                        Files
                    </button>
                    <button class="btn btn-danger rounded-pill me-1 mb-1 btn-action"
                        type="button" id="lab-cancel-request">
                        Cancel Request<span class="fas fa-tint-slash"
                            data-fa-transform="shrink-3"></span>
                    </button>
                @endif

            @endif

            {{-- lab button end --}}
            {{-- advisor button start --}}
            @if (Auth::user()->role == 'advisor' && $patient->advisor_id == Auth::id() && $patient->case_holder == 'advisor')
                <button class="btn btn-danger rounded-pill me-1 mb-1 btn-action" type="button"
                    id="advisor-send-to-doctor">
                    <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>Send for
                    Review
                </button>
            @endif
            {{-- advisor button end --}}
        </div>
    </div>
</div>

