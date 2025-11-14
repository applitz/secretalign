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

        </div>
    </div>
</div>

