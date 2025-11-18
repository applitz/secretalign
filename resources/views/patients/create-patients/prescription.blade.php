 <div class="tab-pane fade" id="pill-tab-div4" role="tabpanel">
    <h3>Your preferred treatment instructions.</h3>
    <div class="mb-3">
        <div class="form-check form-check-inline">
            <input class="form-check-input" id="treat_upper_arch" name="upper_arch" type="checkbox"
                value="1" @if ($patient->treat_upper_arch == 1) checked @endif />
            <label class="form-check-label" for="treat_upper_arch">Treat Upper Arch</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" id="treat_lower_arch" name="lower_arch" type="checkbox"
                value="1" @if ($patient->treat_lower_arch == 1) checked @endif />
            <label class="form-check-label" for="treat_lower_arch">Treat Lower Arch</label>
        </div>

    </div>
    <div class="accordion border-x border-top rounded mb-3" id="accordionFaq">
        <div class="card shadow-none border-bottom rounded-bottom-0 mb-0">
            <div class="card-header p-0" id="faqAccordionHeading1">
                <button
                    class="accordion-button btn btn-link text-decoration-none d-block w-100 py-2 px-3 collapsed border-0 text-start"
                    data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion1"
                    aria-expanded="false" aria-controls="collapseFaqAccordion1"><span
                        class="fas fa-caret-right accordion-icon me-3"
                        data-fa-transform="shrink-2"></span><span
                        class="fw-medium font-sans-serif text-900">Midline</span></button>
            </div>
            <div class="collapse bg-light" id="collapseFaqAccordion1"
                aria-labelledby="faqAccordionHeading1" data-parent="#accordionFaq">
                <div class="card-body">
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" id="midline1" type="checkbox"
                                name="midline" value="maintain" @if ($patient->midline ==
                            'maintain') checked @endif />
                            <label class="form-check-label" for="midline1">Maintain</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" id="midline2" type="checkbox"
                                name="midline" value="Move Upper to Lower" @if ($patient->midline == 'Move Upper to Lower')
                            checked @endif />
                            <label class="form-check-label" for="midline2">Move Upper to Lower</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" id="midline3" type="checkbox"
                                name="midline" value="Move Lower to Upper" @if ($patient->midline == 'Move Lower to Upper')
                            checked @endif />
                            <label class="form-check-label" for="midline3">Move Lower to Upper</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" id="midline4" type="checkbox"
                                name="midline" value="Independent (move both)" @if ($patient->midline == 'Independent (move both)')
                            checked @endif />
                            <label class="form-check-label" for="midline4">Independent (move both)*</label> <span class="mb-0 text-danger" >*Please describe in Notes</span>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3 d-none">
                        <div class="form-check form-check-inline mb-2">
                            <input class="form-check-input" type="radio" name="align_to_facial_midline" id="align_to_facial_midline1" value="Maintain" {{$patient->align_to_facial_midline == 'Maintain' ? 'checked' : ''}} {{$patient->align_to_facial_midline == "" || $patient->align_to_facial_midline == null ? 'checked' : ''}}>
                            <label class="form-check-label" for="align_to_facial_midline1">
                                Maintain
                            </label>
                        </div>
                        <div class="form-check form-check-inline mb-2">
                            <input class="form-check-input" type="radio" name="align_to_facial_midline" id="align_to_facial_midline2" value="Move Upper to Lower" {{$patient->align_to_facial_midline == 'Move Upper to Lower' ? 'checked' : ''}}>
                            <label class="form-check-label" for="align_to_facial_midline2">
                                Move Upper to Lower
                            </label>
                        </div>
                        <div class="form-check form-check-inline mb-2">
                            <input class="form-check-input" type="radio" name="align_to_facial_midline" id="align_to_facial_midline3" value="Move Lower to Upper" {{$patient->align_to_facial_midline == 'Move Lower to Upper' ? 'checked' : ''}}>
                            <label class="form-check-label" for="align_to_facial_midline3">
                                Move Lower to Upper
                            </label>
                        </div>
                        <div class="form-check form-check-inline mb-2">
                            <input class="form-check-input" type="radio" name="align_to_facial_midline" id="align_to_facial_midline4" value="Independent (move both)" {{$patient->align_to_facial_midline == 'Independent (move both)' ? 'checked' : ''}}>
                            <label class="form-check-label" for="align_to_facial_midline4">
                                Independent (move both)*
                                <span class="mb-0 text-danger" >*Please describe in Notes</span>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Notes</label>
                        <textarea class="form-control" id="midline_notes"
                            name="midline_notes">{{ $patient->midline_notes }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-none border-bottom rounded-0 mb-0">
            <div class="card-header p-0" id="faqAccordionHeading2">
                <button
                    class="accordion-button btn btn-link text-decoration-none d-block w-100 py-2 px-3 collapsed border-0 text-start"
                    data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion2"
                    aria-expanded="false" aria-controls="collapseFaqAccordion2"><span
                        class="fas fa-caret-right accordion-icon me-3"
                        data-fa-transform="shrink-2"></span><span
                        class="fw-medium font-sans-serif text-900">Archform</span></button>
            </div>
            <div class="collapse bg-light" id="collapseFaqAccordion2"
                aria-labelledby="faqAccordionHeading2" data-parent="#accordionFaq">
                <div class="card-body">
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" id="archform1" type="checkbox"
                                name="archform" value="maintain" @if ($patient->archform ==
                            'maintain') checked @endif />
                            <label class="form-check-label" for="archform1">Maintain</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" id="archform2" type="checkbox"
                                name="archform" value="correct" @if ($patient->archform ==
                            'correct') checked @endif />
                            <label class="form-check-label" for="archform2">Correct</label>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label>Notes</label>
                        <textarea class="form-control" id="archform_notes"
                            name="archform_notes">{{ $patient->archform_notes }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-none border-bottom rounded-0 mb-0">
            <div class="card-header p-0" id="faqAccordionHeading3">
                <button
                    class="accordion-button btn btn-link text-decoration-none d-block w-100 py-2 px-3 collapsed border-0 text-start"
                    data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion3"
                    aria-expanded="false" aria-controls="collapseFaqAccordion3"><span
                        class="fas fa-caret-right accordion-icon me-3"
                        data-fa-transform="shrink-2"></span><span
                        class="fw-medium font-sans-serif text-900">Class</span></button>
            </div>
            <div class="collapse bg-light" id="collapseFaqAccordion3"
                aria-labelledby="faqAccordionHeading3" data-parent="#accordionFaq">
                <div class="card-body">
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" id="class1" type="checkbox" name="class"
                                value="maintain" @if ($patient->class == 'maintain') checked @endif
                            />
                            <label class="form-check-label" for="class1">Maintain</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" id="class2" type="checkbox" name="class"
                                value="correct" @if ($patient->class == 'correct') checked @endif />
                            <label class="form-check-label" for="class2">Correct</label>
                        </div>
                    </div>
                    <hr>
                    <h5 class="text-center mb-3">Precision Cuts Placement
                        <a href="javascript:;" class="text-info" data-bs-toggle="modal" data-bs-target="#precision-cuts-placement-modal">
                            <i class="fas fa-info-circle"></i>
                        </a>
                    </h5>
                    <div class="row justify-content-center">
                        <div class="col-8">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6  top left tw">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div class="side-label left">
                                                U
                                            </div>
                                            <div class="direction-label left">
                                                R
                                            </div>
                                            <div
                                                class="card-body d-flex justify-content-between left-jaw">
                                                @php
                                                $pcp_ur = [];
                                                if ($patient->pcp_ur != '' && $patient->pcp_ur !=
                                                null) {
                                                $pcp_ur = unserialize($patient->pcp_ur);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="pcp_ur" id="pcp_ur8" @if (in_array(8,
                                                    $pcp_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="pcp_ur" id="pcp_ur7" @if (in_array(7,
                                                    $pcp_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="pcp_ur" id="pcp_ur6" @if (in_array(6,
                                                    $pcp_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="pcp_ur" id="pcp_ur5" @if (in_array(5,
                                                    $pcp_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="pcp_ur" id="pcp_ur4" @if (in_array(4,
                                                    $pcp_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="pcp_ur" id="pcp_ur3" @if (in_array(3,
                                                    $pcp_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="pcp_ur" id="pcp_ur2" @if (in_array(2,
                                                    $pcp_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="pcp_ur" id="pcp_ur1" @if (in_array(1,
                                                    $pcp_ur)) checked @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 top right tw">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex justify-content-between right-jaw">
                                                @php
                                                $pcp_ul = [];
                                                if ($patient->pcp_ul != '' && $patient->pcp_ul !=
                                                null) {
                                                $pcp_ul = unserialize($patient->pcp_ul);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="pcp_ul" id="pcp_ul1" @if (in_array(1,
                                                    $pcp_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="pcp_ul" id="pcp_ul2" @if (in_array(2,
                                                    $pcp_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="pcp_ul" id="pcp_ul3" @if (in_array(3,
                                                    $pcp_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="pcp_ul" id="pcp_ul4" @if (in_array(4,
                                                    $pcp_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="pcp_ul" id="pcp_ul5" @if (in_array(5,
                                                    $pcp_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="pcp_ul" id="pcp_ul6" @if (in_array(6,
                                                    $pcp_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="pcp_ul" id="pcp_ul7" @if (in_array(7,
                                                    $pcp_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="pcp_ul" id="pcp_ul8" @if (in_array(8,
                                                    $pcp_ul)) checked @endif>
                                            </div>
                                            <div class="side-label right">
                                                U
                                            </div>
                                            <div class="direction-label right">
                                                L
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 tw bottom left">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div class="side-label left">
                                                L
                                            </div>
                                            <div
                                                class="card-body d-flex justify-content-between left-jaw">
                                                @php
                                                $pcp_lr = [];
                                                if ($patient->pcp_lr != '' && $patient->pcp_lr !=
                                                null) {
                                                $pcp_lr = unserialize($patient->pcp_lr);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="pcp_lr" id="pcp_lr8" @if (in_array(8,
                                                    $pcp_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="pcp_lr" id="pcp_lr7" @if (in_array(7,
                                                    $pcp_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="pcp_lr" id="pcp_lr6" @if (in_array(6,
                                                    $pcp_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="pcp_lr" id="pcp_lr5" @if (in_array(5,
                                                    $pcp_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="pcp_lr" id="pcp_lr4" @if (in_array(4,
                                                    $pcp_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="pcp_lr" id="pcp_lr3" @if (in_array(3,
                                                    $pcp_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="pcp_lr" id="pcp_lr2" @if (in_array(2,
                                                    $pcp_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="pcp_lr" id="pcp_lr1" @if (in_array(1,
                                                    $pcp_lr)) checked @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 bottom right tw">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex justify-content-between right-jaw">
                                                @php
                                                $pcp_ll = [];
                                                if ($patient->pcp_ll != '' && $patient->pcp_ll !=
                                                null) {
                                                $pcp_ll = unserialize($patient->pcp_ll);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="pcp_ll" id="pcp_ll1" @if (in_array(1,
                                                    $pcp_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="pcp_ll" id="pcp_ll2" @if (in_array(2,
                                                    $pcp_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="pcp_ll" id="pcp_ll3" @if (in_array(3,
                                                    $pcp_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="pcp_ll" id="pcp_ll4" @if (in_array(4,
                                                    $pcp_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="pcp_ll" id="pcp_ll5" @if (in_array(5,
                                                    $pcp_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="pcp_ll" id="pcp_ll6" @if (in_array(6,
                                                    $pcp_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="pcp_ll" id="pcp_ll7" @if (in_array(7,
                                                    $pcp_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="pcp_ll" id="pcp_ll8" @if (in_array(8,
                                                    $pcp_ll)) checked @endif>
                                            </div>
                                            <div class="side-label right">
                                                L
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h5 class="text-center my-3">Cutouts Placement
                        <a href="javascript:;" class="text-info" data-bs-toggle="modal" data-bs-target="#cutouts-placement-modal">
                            <i class="fas fa-info-circle"></i>
                        </a>
                    </h5>
                    <div class="row justify-content-center">
                        <div class="col-8">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6  top left tw">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div class="side-label left">
                                                U
                                            </div>
                                            <div class="direction-label left">
                                                R
                                            </div>
                                            <div
                                                class="card-body d-flex justify-content-between left-jaw">
                                                @php
                                                $ctp_ur = [];
                                                if ($patient->ctp_ur != '' && $patient->ctp_ur !=
                                                null) {
                                                $ctp_ur = unserialize($patient->ctp_ur);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="ctp_ur" id="ctp_ur8" @if (in_array(8,
                                                    $ctp_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="ctp_ur" id="ctp_ur7" @if (in_array(7,
                                                    $ctp_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="ctp_ur" id="ctp_ur6" @if (in_array(6,
                                                    $ctp_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="ctp_ur" id="ctp_ur5" @if (in_array(5,
                                                    $ctp_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="ctp_ur" id="ctp_ur4" @if (in_array(4,
                                                    $ctp_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="ctp_ur" id="ctp_ur3" @if (in_array(3,
                                                    $ctp_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="ctp_ur" id="ctp_ur2" @if (in_array(2,
                                                    $ctp_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="ctp_ur" id="ctp_ur1" @if (in_array(1,
                                                    $ctp_ur)) checked @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 top right tw">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex justify-content-between right-jaw">
                                                @php
                                                $ctp_ul = [];
                                                if ($patient->ctp_ul != '' && $patient->ctp_ul !=
                                                null) {
                                                $ctp_ul = unserialize($patient->ctp_ul);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="ctp_ul" id="ctp_ul1" @if (in_array(1,
                                                    $ctp_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="ctp_ul" id="ctp_ul2" @if (in_array(2,
                                                    $ctp_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="ctp_ul" id="ctp_ul3" @if (in_array(3,
                                                    $ctp_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="ctp_ul" id="ctp_ul4" @if (in_array(4,
                                                    $ctp_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="ctp_ul" id="ctp_ul5" @if (in_array(5,
                                                    $ctp_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="ctp_ul" id="ctp_ul6" @if (in_array(6,
                                                    $ctp_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="ctp_ul" id="ctp_ul7" @if (in_array(7,
                                                    $ctp_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="ctp_ul" id="ctp_ul8" @if (in_array(8,
                                                    $ctp_ul)) checked @endif>
                                            </div>
                                            <div class="side-label right">
                                                U
                                            </div>
                                            <div class="direction-label right">
                                                L
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 tw bottom left">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div class="side-label left">
                                                L
                                            </div>
                                            <div
                                                class="card-body d-flex justify-content-between left-jaw">
                                                @php
                                                $ctp_lr = [];
                                                if ($patient->ctp_lr != '' && $patient->ctp_lr !=
                                                null) {
                                                $ctp_lr = unserialize($patient->ctp_lr);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="ctp_lr" id="ctp_lr8" @if (in_array(8,
                                                    $ctp_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="ctp_lr" id="ctp_lr7" @if (in_array(7,
                                                    $ctp_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="ctp_lr" id="ctp_lr6" @if (in_array(6,
                                                    $ctp_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="ctp_lr" id="ctp_lr5" @if (in_array(5,
                                                    $ctp_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="ctp_lr" id="ctp_lr4" @if (in_array(4,
                                                    $ctp_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="ctp_lr" id="ctp_lr3" @if (in_array(3,
                                                    $ctp_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="ctp_lr" id="ctp_lr2" @if (in_array(2,
                                                    $ctp_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="ctp_lr" id="ctp_lr1" @if (in_array(1,
                                                    $ctp_lr)) checked @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 bottom right tw">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex justify-content-between right-jaw">
                                                @php
                                                $ctp_ll = [];
                                                if ($patient->ctp_ll != '' && $patient->ctp_ll !=
                                                null) {
                                                $ctp_ll = unserialize($patient->ctp_ll);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="ctp_ll" id="ctp_ll1" @if (in_array(1,
                                                    $ctp_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="ctp_ll" id="ctp_ll2" @if (in_array(2,
                                                    $ctp_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="ctp_ll" id="ctp_ll3" @if (in_array(3,
                                                    $ctp_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="ctp_ll" id="ctp_ll4" @if (in_array(4,
                                                    $ctp_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="ctp_ll" id="ctp_ll5" @if (in_array(5,
                                                    $ctp_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="ctp_ll" id="ctp_ll6" @if (in_array(6,
                                                    $ctp_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="ctp_ll" id="ctp_ll7" @if (in_array(7,
                                                    $ctp_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="ctp_ll" id="ctp_ll8" @if (in_array(8,
                                                    $ctp_ll)) checked @endif>
                                            </div>
                                            <div class="side-label right">
                                                L
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h5 class="text-center mb-3">I-Hook
                        <a href="javascript:;" class="text-info" data-bs-toggle="modal" data-bs-target="#i-hook-modal">
                            <i class="fas fa-info-circle"></i>
                        </a>
                    </h5>
                    <div class="row justify-content-center">
                        <div class="col-8">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6  top left tw">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div class="side-label left">
                                                U
                                            </div>
                                            <div class="direction-label left">
                                                R
                                            </div>
                                            <div
                                                class="card-body d-flex justify-content-between left-jaw">
                                                @php
                                                $ihook_ur = [];
                                                if ($patient->ihook_ur != '' && $patient->ihook_ur !=
                                                null) {
                                                $ihook_ur = unserialize($patient->ihook_ur);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="ihook_ur" id="ihook_ur8" @if (in_array(8,
                                                    $ihook_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="ihook_ur" id="ihook_ur7" @if (in_array(7,
                                                    $ihook_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="ihook_ur" id="ihook_ur6" @if (in_array(6,
                                                    $ihook_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="ihook_ur" id="ihook_ur5" @if (in_array(5,
                                                    $ihook_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="ihook_ur" id="ihook_ur4" @if (in_array(4,
                                                    $ihook_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="ihook_ur" id="ihook_ur3" @if (in_array(3,
                                                    $ihook_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="ihook_ur" id="ihook_ur2" @if (in_array(2,
                                                    $ihook_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="ihook_ur" id="ihook_ur" @if (in_array(1,
                                                    $ihook_ur)) checked @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 top right tw">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex justify-content-between right-jaw">
                                                @php
                                                $ihook_ul = [];
                                                if ($patient->ihook_ul != '' && $patient->ihook_ul !=
                                                null) {
                                                $ihook_ul = unserialize($patient->ihook_ul);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="ihook_ul" id="ihook_ul1" @if (in_array(1,
                                                    $ihook_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="ihook_ul" id="ihook_ul2" @if (in_array(2,
                                                    $ihook_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="ihook_ul" id="ihook_ul3" @if (in_array(3,
                                                    $ihook_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="ihook_ul" id="ihook_ul4" @if (in_array(4,
                                                    $ihook_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="ihook_ul" id="ihook_ul5" @if (in_array(5,
                                                    $ihook_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="ihook_ul" id="ihook_ul6" @if (in_array(6,
                                                    $ihook_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="ihook_ul" id="ihook_ul7" @if (in_array(7,
                                                    $ihook_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="ihook_ul" id="ihook_ul8" @if (in_array(8,
                                                    $ihook_ul)) checked @endif>
                                            </div>
                                            <div class="side-label right">
                                                U
                                            </div>
                                            <div class="direction-label right">
                                                L
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 tw bottom left">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div class="side-label left">
                                                L
                                            </div>
                                            <div
                                                class="card-body d-flex justify-content-between left-jaw">
                                                @php
                                                $ihook_lr = [];
                                                if ($patient->ihook_lr != '' && $patient->ihook_lr !=
                                                null) {
                                                $ihook_lr = unserialize($patient->ihook_lr);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="ihook_lr" id="ihook_lr8" @if (in_array(8,
                                                    $ihook_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="ihook_lr" id="ihook_lr7" @if (in_array(7,
                                                    $ihook_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="ihook_lr" id="ihook_lr6" @if (in_array(6,
                                                    $ihook_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="pcp_lr" id="ihook_lr5" @if (in_array(5,
                                                    $ihook_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="ihook_lr" id="ihook_lr4" @if (in_array(4,
                                                    $ihook_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="ihook_lr" id="ihook_lr3" @if (in_array(3,
                                                    $ihook_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="ihook_lr" id="ihook_lr2" @if (in_array(2,
                                                    $ihook_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="ihook_lr" id="ihook_lr1" @if (in_array(1,
                                                    $ihook_lr)) checked @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 bottom right tw">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex justify-content-between right-jaw">
                                                @php
                                                $ihook_ll = [];
                                                if ($patient->ihook_ll != '' && $patient->ihook_ll !=
                                                null) {
                                                $ihook_ll = unserialize($patient->ihook_ll);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="ihook_ll" id="ihook_ll1" @if (in_array(1,
                                                    $ihook_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="ihook_ll" id="ihook_ll2" @if (in_array(2,
                                                    $ihook_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="ihook_ll" id="ihook_ll3" @if (in_array(3,
                                                    $ihook_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="ihook_ll" id="ihook_ll4" @if (in_array(4,
                                                    $ihook_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="ihook_ll" id="ihook_ll5" @if (in_array(5,
                                                    $ihook_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="ihook_ll" id="ihook_ll6" @if (in_array(6,
                                                    $ihook_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="ihook_ll" id="ihook_ll7" @if (in_array(7,
                                                    $ihook_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="ihook_ll" id="ihook_ll8" @if (in_array(8,
                                                    $ihook_ll)) checked @endif>
                                            </div>
                                            <div class="side-label right">
                                                L
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="mb-3">
                        <label>Notes</label>
                        <textarea class="form-control" id="class_notes"
                            name="class_notes">{{ $patient->class_notes }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-none border-bottom mb-0">
            <div class="card-header p-0" id="faqAccordionHeading4">
                <button
                    class="accordion-button btn btn-link text-decoration-none d-block w-100 py-2 px-3 collapsed border-0 text-start"
                    data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion4"
                    aria-expanded="false" aria-controls="collapseFaqAccordion4"><span
                        class="fas fa-caret-right accordion-icon me-3"
                        data-fa-transform="shrink-2"></span><span
                        class="fw-medium font-sans-serif text-900">Resolutions</span></button>
            </div>

            <div class="collapse bg-light" id="collapseFaqAccordion4"
                aria-labelledby="faqAccordionHeading4" data-parent="#accordionFaq">
                <div class="card-body">
                    <h5>Resolve Tooth Size Issues</h5>
                    <div class="mb-3">
                        <label>Please select one of the following options.</label>
                        <div class="form-check">
                            <input class="form-check-input" id="size_issues1" type="radio"
                                name="size_issues" value="IPR" @if ($patient->tooth_size_issues ==
                            'IPR') checked @endif />
                            <label class="form-check-label" for="size_issues1">IPR</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" id="size_issues2" type="radio"
                                name="size_issues" value="Restorative (No IPR)"
                                @if($patient->tooth_size_issues == 'Restorative (No IPR)')
                            checked @endif />
                            <label class="form-check-label" for="size_issues2">Restorative (No
                                IPR)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" id="size_issues3" type="radio"
                                name="size_issues" value="Accept best fit (No IPR/Restorative)"
                                @if($patient->tooth_size_issues == 'Accept best fit (No
                            IPR/Restorative)') checked @endif />
                            <label class="form-check-label" for="size_issues3">Accept best fit (No IPR/Restorative)</label>
                        </div>
                    </div>
                    <hr>
                    <div id="presc-location-section" class="{{ $patient->tooth_size_issues == 'IPR' ? '' : 'd-none'}}">
                    <h5>Location</h5>
                    <div class="mb-3">
                        <label>Upper</label>
                        <select id="location_upper" name="location_upper" class="form-select">
                            <option value="" selected disabled>Select</option>
                            <option value="3-3" @if ($patient->location_upper == '3-3') selected
                                @endif>3-3</option>
                            <option value="4-4" @if ($patient->location_upper == '4-4') selected
                                @endif>4-4</option>
                            <option value="6-6" @if ($patient->location_upper == '6-6') selected
                                @endif>6-6</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Lower</label>
                        <select id="location_lower" name="location_lower" class="form-select">
                            <option value="" selected disabled>Select</option>
                            <option value="3-3" @if ($patient->location_lower == '3-3') selected
                                @endif>3-3</option>
                            <option value="4-4" @if ($patient->location_lower == '4-4') selected
                                @endif>4-4</option>
                            <option value="6-6" @if ($patient->location_lower == '6-6') selected
                                @endif>6-6</option>
                        </select>
                    </div>
                    <hr>
                    </div>
                    <div id="pres-limits-section"  class="{{ $patient->tooth_size_issues == 'IPR' ? '' : 'd-none'}}">
                        <h5>Limits</h5>
                        <div class="mb-3">
                            <label>Maximum Ant. IPR/Contact 0.1-0.6mm</label>
                            <input class="form-control" type="number" name="limits"
                                value="{{ $patient->limits }}" id="limits" step="0.05" min="0.1"
                                max="0.6">
                        </div>
                        <hr>
                    </div>
                                                            <h5 class="text-center mb-3">Open space for future Prosthesis</h5>
                    <div class="row justify-content-center">
                        <div class="col-8">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6  top left tw">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div class="side-label left">
                                                U
                                            </div>
                                            <div class="direction-label left">
                                                R
                                            </div>
                                            <div
                                                class="card-body d-flex justify-content-between left-jaw">
                                                @php
                                                $ofp_ur = [];
                                                if ($patient->ofp_ur != '' && $patient->ofp_lr !=
                                                null) {
                                                $ofp_ur = unserialize($patient->ofp_ur);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="ofp_ur" id="ofp_ur8" @if (in_array(8,
                                                    $ofp_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="ofp_ur" id="ofp_ur7" @if (in_array(7,
                                                    $ofp_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="ofp_ur" id="ofp_ur6" @if (in_array(6,
                                                    $ofp_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="ofp_ur" id="ofp_ur5" @if (in_array(5,
                                                    $ofp_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="ofp_ur" id="ofp_ur4" @if (in_array(4,
                                                    $ofp_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="ofp_ur" id="ofp_ur3" @if (in_array(3,
                                                    $ofp_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="ofp_ur" id="ofp_ur2" @if (in_array(2,
                                                    $ofp_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="ofp_ur" id="ofp_ur1" @if (in_array(1,
                                                    $ofp_ur)) checked @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 top right tw">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex justify-content-between right-jaw">
                                                @php
                                                $ofp_ul = [];
                                                if ($patient->ofp_ul != '' && $patient->ofp_ul !=
                                                null) {
                                                $ofp_ul = unserialize($patient->ofp_ul);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="ofp_ul" id="ofp_ul1" @if (in_array(1,
                                                    $ofp_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="ofp_ul" id="ofp_ul2" @if (in_array(2,
                                                    $ofp_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="ofp_ul" id="ofp_ul3" @if (in_array(3,
                                                    $ofp_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="ofp_ul" id="ofp_ul4" @if (in_array(4,
                                                    $ofp_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="ofp_ul" id="ofp_ul5" @if (in_array(5,
                                                    $ofp_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="ofp_ul" id="ofp_ul6" @if (in_array(6,
                                                    $ofp_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="ofp_ul" id="ofp_ul7" @if (in_array(7,
                                                    $ofp_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="ofp_ul" id="ofp_ul8" @if (in_array(8,
                                                    $ofp_ul)) checked @endif>
                                            </div>
                                            <div class="side-label right">
                                                U
                                            </div>
                                            <div class="direction-label right">
                                                L
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 tw bottom left">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div class="side-label left">
                                                L
                                            </div>
                                            <div
                                                class="card-body d-flex justify-content-between left-jaw">
                                                @php
                                                $ofp_lr = [];
                                                if ($patient->ofp_lr != '' && $patient->ofp_lr !=
                                                null) {
                                                $ofp_lr = unserialize($patient->ofp_lr);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="ofp_lr" id="ofp_lr8" @if (in_array(8,
                                                    $ofp_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="ofp_lr" id="ofp_lr7" @if (in_array(7,
                                                    $ofp_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="ofp_lr" id="ofp_lr6" @if (in_array(6,
                                                    $ofp_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="ofp_lr" id="ofp_lr5" @if (in_array(5,
                                                    $ofp_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="ofp_lr" id="ofp_lr4" @if (in_array(4,
                                                    $ofp_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="ofp_lr" id="ofp_lr3" @if (in_array(3,
                                                    $ofp_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="ofp_lr" id="ofp_lr2" @if (in_array(2,
                                                    $ofp_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="ofp_lr" id="ofp_lr1" @if (in_array(1,
                                                    $ofp_lr)) checked @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 bottom right tw">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex justify-content-between right-jaw">
                                                @php
                                                $ofp_ll = [];
                                                if ($patient->ofp_ll != '' && $patient->ofp_ll !=
                                                null) {
                                                $ofp_ll = unserialize($patient->ofp_ll);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="ofp_ll" id="ofp_ll1" @if (in_array(1,
                                                    $ofp_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="ofp_ll" id="ofp_ll2" @if (in_array(2,
                                                    $ofp_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="ofp_ll" id="ofp_ll3" @if (in_array(3,
                                                    $ofp_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="ofp_ll" id="ofp_ll4" @if (in_array(4,
                                                    $ofp_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="ofp_ll" id="ofp_ll5" @if (in_array(5,
                                                    $ofp_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="ofp_ll" id="ofp_ll6" @if (in_array(6,
                                                    $ofp_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="ofp_ll" id="ofp_ll7" @if (in_array(7,
                                                    $ofp_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="ofp_ll" id="ofp_ll8" @if (in_array(8,
                                                    $ofp_ll)) checked @endif>
                                            </div>
                                            <div class="side-label right">
                                                L
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h5 class="text-center mb-3">Tooth Movement Restrictions</h5>
                    <div class="row justify-content-center">
                        <div class="col-8">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6  top left tw">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div class="side-label left">
                                                U
                                            </div>
                                            <div class="direction-label left">
                                                R
                                            </div>
                                            <div
                                                class="card-body d-flex justify-content-between left-jaw">
                                                @php
                                                $tmr_ur = [];
                                                if ($patient->tmr_ur != '' && $patient->tmr_ur !=
                                                null) {
                                                $tmr_ur = unserialize($patient->tmr_ur);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="tmr_ur" id="tmr_ur8" @if (in_array(8,
                                                    $tmr_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="tmr_ur" id="tmr_ur7" @if (in_array(7,
                                                    $tmr_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="tmr_ur" id="tmr_ur6" @if (in_array(6,
                                                    $tmr_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="tmr_ur" id="tmr_ur5" @if (in_array(5,
                                                    $tmr_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="tmr_ur" id="tmr_ur4" @if (in_array(4,
                                                    $tmr_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="tmr_ur" id="tmr_ur3" @if (in_array(3,
                                                    $tmr_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="tmr_ur" id="tmr_ur2" @if (in_array(2,
                                                    $tmr_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="tmr_ur" id="tmr_ur1" @if (in_array(1,
                                                    $tmr_ur)) checked @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 top right tw">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex justify-content-between right-jaw">
                                                @php
                                                $tmr_ul = [];
                                                if ($patient->tmr_ul != '' && $patient->tmr_ul !=
                                                null) {
                                                $tmr_ul = unserialize($patient->tmr_ul);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="tmr_ul" id="tmr_ul1" @if (in_array(1,
                                                    $tmr_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="tmr_ul" id="tmr_ul2" @if (in_array(2,
                                                    $tmr_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="tmr_ul" id="tmr_ul3" @if (in_array(3,
                                                    $tmr_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="tmr_ul" id="tmr_ul4" @if (in_array(4,
                                                    $tmr_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="tmr_ul" id="tmr_ul5" @if (in_array(5,
                                                    $tmr_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="tmr_ul" id="tmr_ul6" @if (in_array(6,
                                                    $tmr_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="tmr_ul" id="tmr_ul7" @if (in_array(7,
                                                    $tmr_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="tmr_ul" id="tmr_ul8" @if (in_array(8,
                                                    $tmr_ul)) checked @endif>
                                            </div>
                                            <div class="side-label right">
                                                U
                                            </div>
                                            <div class="direction-label right">
                                                L
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 tw bottom left">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div class="side-label left">
                                                L
                                            </div>
                                            <div
                                                class="card-body d-flex justify-content-between left-jaw">
                                                @php
                                                $tmr_lr = [];
                                                if ($patient->tmr_lr != '' && $patient->tmr_lr !=
                                                null) {
                                                $tmr_lr = unserialize($patient->tmr_lr);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="tmr_lr" id="tmr_lr8" @if (in_array(8,
                                                    $tmr_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="tmr_lr" id="tmr_lr7" @if (in_array(7,
                                                    $tmr_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="tmr_lr" id="tmr_lr6" @if (in_array(6,
                                                    $tmr_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="tmr_lr" id="tmr_lr5" @if (in_array(5,
                                                    $tmr_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="tmr_lr" id="tmr_lr4" @if (in_array(4,
                                                    $tmr_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="tmr_lr" id="tmr_lr3" @if (in_array(3,
                                                    $tmr_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="tmr_lr" id="tmr_lr2" @if (in_array(2,
                                                    $tmr_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="tmr_lr" id="tmr_lr1" @if (in_array(1,
                                                    $tmr_lr)) checked @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 bottom right tw">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex justify-content-between right-jaw">
                                                @php
                                                $tmr_ll = [];
                                                if ($patient->tmr_ll != '' && $patient->tmr_ll !=
                                                null) {
                                                $tmr_ll = unserialize($patient->tmr_ll);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="tmr_ll" id="tmr_ll1" @if (in_array(1,
                                                    $tmr_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="tmr_ll" id="tmr_ll2" @if (in_array(2,
                                                    $tmr_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="tmr_ll" id="tmr_ll3" @if (in_array(3,
                                                    $tmr_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="tmr_ll" id="tmr_ll4" @if (in_array(4,
                                                    $tmr_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="tmr_ll" id="tmr_ll5" @if (in_array(5,
                                                    $tmr_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="tmr_ll" id="tmr_ll6" @if (in_array(6,
                                                    $tmr_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="tmr_ll" id="tmr_ll7" @if (in_array(7,
                                                    $tmr_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="tmr_ll" id="tmr_ll8" @if (in_array(8,
                                                    $tmr_ll)) checked @endif>
                                            </div>
                                            <div class="side-label right">
                                                L
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h5 class="text-center my-3">Missing or Unerupted teeth</h5>
                    <div class="row justify-content-center">
                        <div class="col-8">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6  top left tw">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div class="side-label left">
                                                U
                                            </div>
                                            <div class="direction-label left">
                                                R
                                            </div>
                                            <div
                                                class="card-body d-flex justify-content-between left-jaw">
                                                @php
                                                $mut_ur = [];
                                                if ($patient->mut_ur != '' && $patient->mut_ur !=
                                                null) {
                                                $mut_ur = unserialize($patient->mut_ur);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="mut_ur" id="mut_ur8" @if (in_array(8,
                                                    $mut_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="mut_ur" id="mut_ur7" @if (in_array(7,
                                                    $mut_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="mut_ur" id="mut_ur6" @if (in_array(6,
                                                    $mut_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="mut_ur" id="mut_ur5" @if (in_array(5,
                                                    $mut_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="mut_ur" id="mut_ur4" @if (in_array(4,
                                                    $mut_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="mut_ur" id="mut_ur3" @if (in_array(3,
                                                    $mut_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="mut_ur" id="mut_ur2" @if (in_array(2,
                                                    $mut_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="mut_ur" id="mut_ur1" @if (in_array(1,
                                                    $mut_ur)) checked @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 top right tw">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex justify-content-between right-jaw">
                                                @php
                                                $mut_ul = [];
                                                if ($patient->mut_ul != '' && $patient->mut_ul !=
                                                null) {
                                                $mut_ul = unserialize($patient->mut_ul);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="mut_ul" id="mut_ul1" @if (in_array(1,
                                                    $mut_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="mut_ul" id="mut_ul2" @if (in_array(2,
                                                    $mut_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="mut_ul" id="mut_ul3" @if (in_array(3,
                                                    $mut_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="mut_ul" id="mut_ul4" @if (in_array(4,
                                                    $mut_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="mut_ul" id="mut_ul5" @if (in_array(5,
                                                    $mut_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="mut_ul" id="mut_ul6" @if (in_array(6,
                                                    $mut_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="mut_ul" id="mut_ul7" @if (in_array(7,
                                                    $mut_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="mut_ul" id="mut_ul8" @if (in_array(8,
                                                    $mut_ul)) checked @endif>
                                            </div>
                                            <div class="side-label right">
                                                U
                                            </div>
                                            <div class="direction-label right">
                                                L
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 tw bottom left">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex justify-content-between left-jaw">
                                                @php
                                                $mut_lr = [];
                                                if ($patient->mut_lr != '' && $patient->mut_lr !=
                                                null) {
                                                $mut_lr = unserialize($patient->mut_lr);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="mut_lr" id="mut_lr8" @if (in_array(8,
                                                    $mut_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="mut_lr" id="mut_lr7" @if (in_array(7,
                                                    $mut_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="mut_lr" id="mut_lr6" @if (in_array(6,
                                                    $mut_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="mut_lr" id="mut_lr5" @if (in_array(5,
                                                    $mut_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="mut_lr" id="mut_lr4" @if (in_array(4,
                                                    $mut_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="mut_lr" id="mut_lr3" @if (in_array(3,
                                                    $mut_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="mut_lr" id="mut_lr2" @if (in_array(2,
                                                    $mut_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="mut_lr" id="mut_lr1" @if (in_array(1,
                                                    $mut_lr)) checked @endif>
                                            </div>
                                            <div class="side-label left">
                                                L
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 tw bottom right">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex justify-content-between right-jaw">
                                                @php
                                                $mut_ll = [];
                                                if ($patient->mut_ll != '' && $patient->mut_ll !=
                                                null) {
                                                $mut_ll = unserialize($patient->mut_ll);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="mut_ll" id="mut_ll1" @if (in_array(1,
                                                    $mut_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="mut_ll" id="mut_ll2" @if (in_array(2,
                                                    $mut_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="mut_ll" id="mut_ll3" @if (in_array(3,
                                                    $mut_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="mut_ll" id="mut_ll4" @if (in_array(4,
                                                    $mut_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="mut_ll" id="mut_ll5" @if (in_array(5,
                                                    $mut_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="mut_ll" id="mut_ll6" @if (in_array(6,
                                                    $mut_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="mut_ll" id="mut_ll7" @if (in_array(7,
                                                    $mut_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="mut_ll" id="mut_ll8" @if (in_array(8,
                                                    $mut_ll)) checked @endif>
                                            </div>
                                            <div class="side-label right">
                                                L
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="text-center my-3">To be Extracted</h5>
                    <div class="row justify-content-center">
                        <div class="col-8">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6  top left tw">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div class="side-label left">
                                                U
                                            </div>
                                            <div class="direction-label left">
                                                R
                                            </div>
                                            <div
                                                class="card-body d-flex justify-content-between left-jaw">
                                                @php
                                                $tbe_ur = [];
                                                if ($patient->tbe_ur != '' && $patient->tbe_ur !=
                                                null) {
                                                $tbe_ur = unserialize($patient->tbe_ur);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="tbe_ur" id="tbe_ur8" @if (in_array(8,
                                                    $tbe_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="tbe_ur" id="tbe_ur7" @if (in_array(7,
                                                    $tbe_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="tbe_ur" id="tbe_ur6" @if (in_array(6,
                                                    $tbe_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="tbe_ur" id="tbe_ur5" @if (in_array(5,
                                                    $tbe_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="tbe_ur" id="tbe_ur4" @if (in_array(4,
                                                    $tbe_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="tbe_ur" id="tbe_ur3" @if (in_array(3,
                                                    $tbe_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="tbe_ur" id="tbe_ur2" @if (in_array(2,
                                                    $tbe_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="tbe_ur" id="tbe_ur1" @if (in_array(1,
                                                    $tbe_ur)) checked @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 tw top right">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex justify-content-between right-jaw">
                                                @php
                                                $tbe_ul = [];
                                                if ($patient->tbe_ul != '' && $patient->tbe_ul !=
                                                null) {
                                                $tbe_ul = unserialize($patient->tbe_ul);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="tbe_ul" id="tbe_ul1" @if (in_array(1,
                                                    $tbe_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="tbe_ul" id="tbe_ul2" @if (in_array(2,
                                                    $tbe_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="tbe_ul" id="tbe_ul3" @if (in_array(3,
                                                    $tbe_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="tbe_ul" id="tbe_ul4" @if (in_array(4,
                                                    $tbe_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="tbe_ul" id="tbe_ul5" @if (in_array(5,
                                                    $tbe_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="tbe_ul" id="tbe_ul6" @if (in_array(6,
                                                    $tbe_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="tbe_ul" id="tbe_ul7" @if (in_array(7,
                                                    $tbe_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="tbe_ul" id="tbe_ul8" @if (in_array(8,
                                                    $tbe_ul)) checked @endif>
                                            </div>
                                            <div class="side-label right">
                                                U
                                            </div>
                                            <div class="direction-label right">
                                                L
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 tw bottom left">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex justify-content-between left-jaw">
                                                @php
                                                $tbe_lr = [];
                                                if ($patient->tbe_lr != '' && $patient->tbe_lr !=
                                                null) {
                                                $tbe_lr = unserialize($patient->tbe_lr);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="tbe_lr" id="tbe_lr8" @if (in_array(8,
                                                    $tbe_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="tbe_lr" id="tbe_lr7" @if (in_array(7,
                                                    $tbe_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="tbe_lr" id="tbe_lr6" @if (in_array(6,
                                                    $tbe_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="tbe_lr" id="tbe_lr5" @if (in_array(5,
                                                    $tbe_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="tbe_lr" id="tbe_lr4" @if (in_array(4,
                                                    $tbe_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="tbe_lr" id="tbe_lr3" @if (in_array(3,
                                                    $tbe_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="tbe_lr" id="tbe_lr2" @if (in_array(2,
                                                    $tbe_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="tbe_lr" id="tbe_lr1" @if (in_array(1,
                                                    $tbe_lr)) checked @endif>
                                            </div>
                                            <div class="side-label left">
                                                L
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 tw bottom right">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex justify-content-between right-jaw">
                                                @php
                                                $tbe_ll = [];
                                                if ($patient->tbe_ll != '' && $patient->tbe_ll !=
                                                null) {
                                                $tbe_ll = unserialize($patient->tbe_ll);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="tbe_ll" id="tbe_ll1" @if (in_array(1,
                                                    $tbe_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="tbe_ll" id="tbe_ll2" @if (in_array(2,
                                                    $tbe_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="tbe_ll" id="tbe_ll3" @if (in_array(3,
                                                    $tbe_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="tbe_ll" id="tbe_ll4" @if (in_array(4,
                                                    $tbe_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="tbe_ll" id="tbe_ll5" @if (in_array(5,
                                                    $tbe_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="tbe_ll" id="tbe_ll6" @if (in_array(6,
                                                    $tbe_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="tbe_ll" id="tbe_ll7" @if (in_array(7,
                                                    $tbe_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="tbe_ll" id="tbe_ll8" @if (in_array(8,
                                                    $tbe_ll)) checked @endif>
                                            </div>
                                            <div class="side-label right">
                                                L
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label>Notes</label>
                        <textarea name="resolution_notes" id="resolution_notes"
                            class="form-control"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-none border-bottom mb-0">
            <div class="card-header p-0" id="faqAccordionHeading5">
                <button
                    class="accordion-button btn btn-link text-decoration-none d-block w-100 py-2 px-3 collapsed border-0 text-start"
                    data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion5"
                    aria-expanded="false" aria-controls="collapseFaqAccordion5"><span
                        class="fas fa-caret-right accordion-icon me-3"
                        data-fa-transform="shrink-2"></span><span
                        class="fw-medium font-sans-serif text-900">Occlusal
                        Plane</span></button>
            </div>
            <div class="collapse bg-light" id="collapseFaqAccordion5"
                aria-labelledby="faqAccordionHeading5" data-parent="#accordionFaq">
                <div class="card-body">
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" id="occlusal_plan1" type="checkbox"
                                name="occlusal_plan" value="maintain" @if ($patient->occlusal_plane
                            == 'maintain') checked @endif />
                            <label class="form-check-label" for="occlusal_plan1">Maintain</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" id="occlusal_plan2" type="checkbox"
                                name="occlusal_plan" value="correct" @if ($patient->occlusal_plane
                            == 'correct') checked @endif />
                            <label class="form-check-label" for="occlusal_plan2">Correct</label>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label>Notes</label>
                        <textarea class="form-control" name="occlusal_plane_notes"
                            id="occlusal_plane_notes"
                            placeholder="Leveling as needed">{{ $patient->occlusal_plane_notes }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-none border-bottom mb-0">
            <div class="card-header p-0" id="faqAccordionHeading6">
                <button
                    class="accordion-button btn btn-link text-decoration-none d-block w-100 py-2 px-3 collapsed border-0 text-start"
                    data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion6"
                    aria-expanded="false" aria-controls="collapseFaqAccordion6"><span
                        class="fas fa-caret-right accordion-icon me-3"
                        data-fa-transform="shrink-2"></span><span
                        class="fw-medium font-sans-serif text-900">Special
                        Instructions</span></button>
            </div>
            <div class="collapse bg-light" id="collapseFaqAccordion6"
                aria-labelledby="faqAccordionHeading6" data-parent="#accordionFaq">
                <div class="card-body">

                    <h5 class="">Additional Attachments</h5>
                    <div class="mb-3">
                        @php
                                                $additional_attachments = [];
                                                if ($patient->additional_attachments != '' && $patient->additional_attachments !=
                                                null) {
                                                $additional_attachments = unserialize($patient->additional_attachments);
                                                }
                                                @endphp
                            {{-- <div class="form-check">
                                <input class="form-check-input" id="additional_attachments1" name="additional_attachments" type="checkbox" value="Add Pontic" @if(in_array("Add Pontic", $additional_attachments)) checked @endif />
                                <label class="form-check-label" for="additional_attachments1">Add Pontic</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" id="additional_attachments2" name="additional_attachments" type="checkbox" value="Add Bite Turbos" @if(in_array("Add Bite Turbos", $additional_attachments)) checked @endif />
                                <label class="form-check-label" for="additional_attachments2">Add Bite Turbos</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" id="additional_attachments1" name="additional_attachments" type="checkbox" value="Posterior Bite Turbos" @if(in_array("Posterior Bite Turbos", $additional_attachments)) checked @endif />
                                <label class="form-check-label" for="additional_attachments1">Posterior Bite Turbos</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" id="additional_attachments2" name="additional_attachments" type="checkbox" value="Anterior Bite Turbos" @if(in_array("Anterior Bite Turbos", $additional_attachments)) checked @endif />
                                <label class="form-check-label" for="additional_attachments2">Anterior Bite Turbos</label>
                            </div> --}}

                            <div class="form-check">
                                <input class="form-check-input" id="additional_attachments3" name="additional_attachments" type="checkbox" value="Bite Keeper" @if(in_array("Bite Keeper", $additional_attachments)) checked @endif />
                                <label class="form-check-label" for="additional_attachments3">Bite Keeper
                                    <a href="javascript:;" class="text-info" data-bs-toggle="modal" data-bs-target="#bite-keeper-modal">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" id="additional_attachments4" name="additional_attachments" type="checkbox" value="Secret Wings" @if(in_array("Secret Wings", $additional_attachments)) checked @endif />
                                <label class="form-check-label" for="additional_attachments4">SECRET Wings
                                    <a href="javascript:;" class="text-info" data-bs-toggle="modal" data-bs-target="#secret-wings-modal">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                </label>
                            </div>
                    </div>
                    <h5 class="text-center my-3">Add Pontic
                        <a href="javascript:;" class="text-info" data-bs-toggle="modal" data-bs-target="#add-pontic-modal">
                            <i class="fas fa-info-circle"></i>
                        </a>
                    </h5>
                    <div class="row justify-content-center">
                        <div class="col-8">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6  top left tw">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div class="side-label left">
                                                U
                                            </div>
                                            <div class="direction-label left">
                                                R
                                            </div>
                                            <div
                                                class="card-body d-flex justify-content-between left-jaw">
                                                @php
                                                $add_pontic_ur = [];
                                                if ($patient->add_pontic_ur != '' && $patient->add_pontic_ur !=
                                                null) {
                                                $add_pontic_ur = unserialize($patient->add_pontic_ur);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="add_pontic_ur" id="add_pontic_ur8" @if (in_array(8,
                                                    $add_pontic_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="add_pontic_ur" id="add_pontic_ur7" @if (in_array(7,
                                                    $add_pontic_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="add_pontic_ur" id="add_pontic_ur6" @if (in_array(6,
                                                    $add_pontic_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="add_pontic_ur" id="add_pontic_ur5" @if (in_array(5,
                                                    $add_pontic_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="add_pontic_ur" id="add_pontic_ur4" @if (in_array(4,
                                                    $add_pontic_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="add_pontic_ur" id="add_pontic_ur3" @if (in_array(3,
                                                    $add_pontic_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="add_pontic_ur" id="add_pontic_ur2" @if (in_array(2,
                                                    $add_pontic_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="add_pontic_ur" id="add_pontic_ur1" @if (in_array(1,
                                                    $add_pontic_ur)) checked @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 tw top right">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex justify-content-between right-jaw">
                                                @php
                                                $add_pontic_ul = [];
                                                if ($patient->add_pontic_ul != '' && $patient->add_pontic_ul !=
                                                null) {
                                                $add_pontic_ul = unserialize($patient->add_pontic_ul);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="add_pontic_ul" id="add_pontic_ul1" @if (in_array(1,
                                                    $add_pontic_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="add_pontic_ul" id="add_pontic_ul2" @if (in_array(2,
                                                    $add_pontic_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="add_pontic_ul" id="add_pontic_ul3" @if (in_array(3,
                                                    $add_pontic_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="add_pontic_ul" id="add_pontic_ul4" @if (in_array(4,
                                                    $add_pontic_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="add_pontic_ul" id="add_pontic_ul5" @if (in_array(5,
                                                    $add_pontic_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="add_pontic_ul" id="add_pontic_ul6" @if (in_array(6,
                                                    $add_pontic_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="add_pontic_ul" id="add_pontic_ul7" @if (in_array(7,
                                                    $add_pontic_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="add_pontic_ul" id="add_pontic_ul8" @if (in_array(8,
                                                    $add_pontic_ul)) checked @endif>
                                            </div>
                                            <div class="side-label right">
                                                U
                                            </div>
                                            <div class="direction-label right">
                                                L
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 tw bottom left">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex justify-content-between left-jaw">
                                                @php
                                                $add_pontic_lr = [];
                                                if ($patient->add_pontic_lr != '' && $patient->add_pontic_lr !=
                                                null) {
                                                $add_pontic_lr = unserialize($patient->add_pontic_lr);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="add_pontic_lr" id="add_pontic_lr8" @if (in_array(8,
                                                    $add_pontic_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="add_pontic_lr" id="add_pontic_lr7" @if (in_array(7,
                                                    $add_pontic_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="add_pontic_lr" id="add_pontic_lr6" @if (in_array(6,
                                                    $add_pontic_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="add_pontic_lr" id="add_pontic_lr5" @if (in_array(5,
                                                    $add_pontic_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="add_pontic_lr" id="add_pontic_lr4" @if (in_array(4,
                                                    $add_pontic_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="add_pontic_lr" id="add_pontic_lr3" @if (in_array(3,
                                                    $add_pontic_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="add_pontic_lr" id="add_pontic_lr2" @if (in_array(2,
                                                    $add_pontic_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="add_pontic_lr" id="add_pontic_lr1" @if (in_array(1,
                                                    $add_pontic_lr)) checked @endif>
                                            </div>
                                            <div class="side-label left">
                                                L
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 tw bottom right">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex justify-content-between right-jaw">
                                                @php
                                                $add_pontic_ll = [];
                                                if ($patient->add_pontic_ll != '' && $patient->add_pontic_ll !=
                                                null) {
                                                $add_pontic_ll = unserialize($patient->add_pontic_ll);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="add_pontic_ll" id="add_pontic_ll1" @if (in_array(1,
                                                    $add_pontic_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="add_pontic_ll" id="add_pontic_ll2" @if (in_array(2,
                                                    $add_pontic_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="add_pontic_ll" id="add_pontic_ll3" @if (in_array(3,
                                                    $add_pontic_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="add_pontic_ll" id="add_pontic_ll4" @if (in_array(4,
                                                    $add_pontic_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="add_pontic_ll" id="add_pontic_ll5" @if (in_array(5,
                                                    $add_pontic_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="add_pontic_ll" id="add_pontic_ll6" @if (in_array(6,
                                                    $add_pontic_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="add_pontic_ll" id="add_pontic_ll7" @if (in_array(7,
                                                    $add_pontic_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="add_pontic_ll" id="add_pontic_ll8" @if (in_array(8,
                                                    $add_pontic_ll)) checked @endif>
                                            </div>
                                            <div class="side-label right">
                                                L
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <h5 class="text-center my-3">Add Pontic
                        <a href="javascript:;" class="text-info" data-bs-toggle="modal" data-bs-target="#add-pontic-modal">
                            <i class="fas fa-info-circle"></i>
                        </a>
                    </h5>
                    <div class="row justify-content-center">
                        <div class="col-8">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6  top left tw">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div class="side-label left">
                                                U
                                            </div>
                                            <div class="direction-label left">
                                                R
                                            </div>
                                            <div
                                                class="card-body d-flex justify-content-between left-jaw">
                                                @php
                                                $tla_ur = [];
                                                if ($patient->tla_ur != '' && $patient->tla_ur !=
                                                null) {
                                                $tla_ur = unserialize($patient->tla_ur);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="tla_ur" id="tla_ur8" @if (in_array(8,
                                                    $tla_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="tla_ur" id="tla_ur7" @if (in_array(7,
                                                    $tla_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="tla_ur" id="tla_ur6" @if (in_array(6,
                                                    $tla_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="tla_ur" id="tla_ur5" @if (in_array(5,
                                                    $tla_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="tla_ur" id="tla_ur4" @if (in_array(4,
                                                    $tla_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="tla_ur" id="tla_ur3" @if (in_array(3,
                                                    $tla_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="tla_ur" id="tla_ur2" @if (in_array(2,
                                                    $tla_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="tla_ur" id="tla_ur1" @if (in_array(1,
                                                    $tla_ur)) checked @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 tw top right">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex justify-content-between right-jaw">
                                                @php
                                                $tla_ul = [];
                                                if ($patient->tla_ul != '' && $patient->tla_ul !=
                                                null) {
                                                $tla_ul = unserialize($patient->tla_ul);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="tla_ul" id="tla_ul1" @if (in_array(1,
                                                    $tla_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="tla_ul" id="tla_ul2" @if (in_array(2,
                                                    $tla_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="tla_ul" id="tla_ul3" @if (in_array(3,
                                                    $tla_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="tla_ul" id="tla_ul4" @if (in_array(4,
                                                    $tla_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="tla_ul" id="tla_ul5" @if (in_array(5,
                                                    $tla_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="tla_ul" id="tla_ul6" @if (in_array(6,
                                                    $tla_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="tla_ul" id="tla_ul7" @if (in_array(7,
                                                    $tla_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="tla_ul" id="tla_ul8" @if (in_array(8,
                                                    $tla_ul)) checked @endif>
                                            </div>
                                            <div class="side-label right">
                                                U
                                            </div>
                                            <div class="direction-label right">
                                                L
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 tw bottom left">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex justify-content-between left-jaw">
                                                @php
                                                $tla_lr = [];
                                                if ($patient->tla_lr != '' && $patient->tla_lr !=
                                                null) {
                                                $tla_lr = unserialize($patient->tla_lr);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="tla_lr" id="tla_lr8" @if (in_array(8,
                                                    $tla_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="tla_lr" id="tla_lr7" @if (in_array(7,
                                                    $tla_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="tla_lr" id="tla_lr6" @if (in_array(6,
                                                    $tla_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="tla_lr" id="tla_lr5" @if (in_array(5,
                                                    $tla_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="tla_lr" id="tla_lr4" @if (in_array(4,
                                                    $tla_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="tla_lr" id="tla_lr3" @if (in_array(3,
                                                    $tla_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="tla_lr" id="tla_lr2" @if (in_array(2,
                                                    $tla_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="tla_lr" id="tla_lr1" @if (in_array(1,
                                                    $tla_lr)) checked @endif>
                                            </div>
                                            <div class="side-label left">
                                                L
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 tw bottom right">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex justify-content-between right-jaw">
                                                @php
                                                $tla_ll = [];
                                                if ($patient->tla_ll != '' && $patient->tla_ll !=
                                                null) {
                                                $tla_ll = unserialize($patient->tla_ll);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="tla_ll" id="tla_ll1" @if (in_array(1,
                                                    $tla_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="tla_ll" id="tla_ll2" @if (in_array(2,
                                                    $tla_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="tla_ll" id="tla_ll3" @if (in_array(3,
                                                    $tla_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="tla_ll" id="tla_ll4" @if (in_array(4,
                                                    $tla_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="tla_ll" id="tla_ll5" @if (in_array(5,
                                                    $tla_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="tla_ll" id="tla_ll6" @if (in_array(6,
                                                    $tla_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="tla_ll" id="tla_ll7" @if (in_array(7,
                                                    $tla_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="tla_ll" id="tla_ll8" @if (in_array(8,
                                                    $tla_ll)) checked @endif>
                                            </div>
                                            <div class="side-label right">
                                                L
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <h5 class="text-center my-3">Add Bite Turbos
                        <a href="javascript:;" class="text-info" data-bs-toggle="modal" data-bs-target="#add-bite-turbos-modal">
                            <i class="fas fa-info-circle"></i>
                        </a>
                    </h5>
                    <div class="row justify-content-center">
                        <div class="col-8">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6  top left tw">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div class="side-label left">
                                                U
                                            </div>
                                            <div class="direction-label left">
                                                R
                                            </div>
                                            <div
                                                class="card-body d-flex justify-content-between left-jaw">
                                                @php
                                                $add_bite_turbos_ur = [];
                                                if ($patient->add_bite_turbos_ur != '' && $patient->add_bite_turbos_ur !=
                                                null) {
                                                $add_bite_turbos_ur = unserialize($patient->add_bite_turbos_ur);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="add_bite_turbos_ur" id="add_bite_turbos_ur8" @if (in_array(8,
                                                    $add_bite_turbos_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="add_bite_turbos_ur" id="add_bite_turbos_ur7" @if (in_array(7,
                                                    $add_bite_turbos_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="add_bite_turbos_ur" id="add_bite_turbos_ur6" @if (in_array(6,
                                                    $add_bite_turbos_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="add_bite_turbos_ur" id="add_bite_turbos_ur5" @if (in_array(5,
                                                    $add_bite_turbos_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="add_bite_turbos_ur" id="add_bite_turbos_ur4" @if (in_array(4,
                                                    $add_bite_turbos_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="add_bite_turbos_ur" id="add_bite_turbos_ur3" @if (in_array(3,
                                                    $add_bite_turbos_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="add_bite_turbos_ur" id="add_bite_turbos_ur2" @if (in_array(2,
                                                    $add_bite_turbos_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="add_bite_turbos_ur" id="add_bite_turbos_ur1" @if (in_array(1,
                                                    $add_bite_turbos_ur)) checked @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 tw top right">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex justify-content-between right-jaw">
                                                @php
                                                $add_bite_turbos_ul = [];
                                                if ($patient->add_bite_turbos_ul != '' && $patient->add_bite_turbos_ul !=
                                                null) {
                                                $add_bite_turbos_ul = unserialize($patient->add_bite_turbos_ul);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="add_bite_turbos_ul" id="add_bite_turbos_ul1" @if (in_array(1,
                                                    $add_bite_turbos_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="add_bite_turbos_ul" id="add_bite_turbos_ul2" @if (in_array(2,
                                                    $add_bite_turbos_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="add_bite_turbos_ul" id="add_bite_turbos_ul3" @if (in_array(3,
                                                    $add_bite_turbos_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="add_bite_turbos_ul" id="add_bite_turbos_ul4" @if (in_array(4,
                                                    $add_bite_turbos_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="add_bite_turbos_ul" id="add_bite_turbos_ul5" @if (in_array(5,
                                                    $add_bite_turbos_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="add_bite_turbos_ul" id="add_bite_turbos_ul6" @if (in_array(6,
                                                    $add_bite_turbos_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="add_bite_turbos_ul" id="add_bite_turbos_ul7" @if (in_array(7,
                                                    $add_bite_turbos_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="add_bite_turbos_ul" id="add_bite_turbos_ul8" @if (in_array(8,
                                                    $add_bite_turbos_ul)) checked @endif>
                                            </div>
                                            <div class="side-label right">
                                                U
                                            </div>
                                            <div class="direction-label right">
                                                L
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 tw bottom left">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex justify-content-between left-jaw">
                                                @php
                                                $add_bite_turbos_lr = [];
                                                if ($patient->add_bite_turbos_lr != '' && $patient->add_bite_turbos_lr !=
                                                null) {
                                                $add_bite_turbos_lr = unserialize($patient->add_bite_turbos_lr);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="add_bite_turbos_lr" id="add_bite_turbos_lr8" @if (in_array(8,
                                                    $add_bite_turbos_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="add_bite_turbos_lr" id="add_bite_turbos_lr7" @if (in_array(7,
                                                    $add_bite_turbos_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="add_bite_turbos_lr" id="add_bite_turbos_lr6" @if (in_array(6,
                                                    $add_bite_turbos_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="add_bite_turbos_lr" id="add_bite_turbos_lr5" @if (in_array(5,
                                                    $add_bite_turbos_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="add_bite_turbos_lr" id="add_bite_turbos_lr4" @if (in_array(4,
                                                    $add_bite_turbos_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="add_bite_turbos_lr" id="add_bite_turbos_lr3" @if (in_array(3,
                                                    $add_bite_turbos_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="add_bite_turbos_lr" id="add_bite_turbos_lr2" @if (in_array(2,
                                                    $add_bite_turbos_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="add_bite_turbos_lr" id="add_bite_turbos_lr1" @if (in_array(1,
                                                    $add_bite_turbos_lr)) checked @endif>
                                            </div>
                                            <div class="side-label left">
                                                L
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 tw bottom right">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex justify-content-between right-jaw">
                                                @php
                                                $add_bite_turbos_ll = [];
                                                if ($patient->add_bite_turbos_ll != '' && $patient->add_bite_turbos_ll !=
                                                null) {
                                                $add_bite_turbos_ll = unserialize($patient->add_bite_turbos_ll);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="add_bite_turbos_ll" id="add_bite_turbos_ll1" @if (in_array(1,
                                                    $add_bite_turbos_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="add_bite_turbos_ll" id="add_bite_turbos_ll2" @if (in_array(2,
                                                    $add_bite_turbos_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="add_bite_turbos_ll" id="add_bite_turbos_ll3" @if (in_array(3,
                                                    $add_bite_turbos_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="add_bite_turbos_ll" id="add_bite_turbos_ll4" @if (in_array(4,
                                                    $add_bite_turbos_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="add_bite_turbos_ll" id="add_bite_turbos_ll5" @if (in_array(5,
                                                    $add_bite_turbos_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="add_bite_turbos_ll" id="add_bite_turbos_ll6" @if (in_array(6,
                                                    $add_bite_turbos_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="add_bite_turbos_ll" id="add_bite_turbos_ll7" @if (in_array(7,
                                                    $add_bite_turbos_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="add_bite_turbos_ll" id="add_bite_turbos_ll8" @if (in_array(8,
                                                    $add_bite_turbos_ll)) checked @endif>
                                            </div>
                                            <div class="side-label right">
                                                L
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label>Notes</label>
                        <textarea class="form-control" name="additional_attachments_notes"
                            id="additional_attachments_notes"
                            placeholder="Notes">{{ @$patient->additional_attachments_notes }}</textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" id="keep_already_placed_attachments"
                                value="1" type="checkbox" name="keep_already_placed_attachments"
                                @if($patient->keep_already_placed_attachments == 1) checked @endif
                                @if($mode == 'add') checked @endif
                            />
                            <label class="form-check-label"
                                for="keep_already_placed_attachments">Keep already placed
                                attachments</label>
                        </div>
                    </div>
                    <h5>Aligner Trim Type</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Upper</label>
                            <select id="trim_type_upper" name="trim_type_upper"
                                class="form-control">
                                <option value="Straight" @if ($patient->trim_type_upper ==
                                    'Straight') selected @endif>Straight
                                </option>
                                <option value="Scalloped" @if ($patient->trim_type_upper ==
                                    'Scalloped') selected @endif>Scalloped
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Lower</label>
                            <select id="trim_type_lower" name="trim_type_lower"
                                class="form-control">
                                <option value="Straight" @if ($patient->trim_type_lower ==
                                    'Straight') selected @endif>Straight
                                </option>
                                <option value="Scalloped" @if ($patient->trim_type_lower ==
                                    'Scalloped') selected @endif>Scalloped
                                </option>
                            </select>
                        </div>
                    </div>

                    <h5 class="text-center my-3">Please Mark the last tooth you want the aligners to cover</h5>
                    <div class="row justify-content-center">
                        <div class="col-8">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6  top left tw">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div class="side-label left">
                                                U
                                            </div>
                                            <div class="direction-label left">
                                                R
                                            </div>
                                            <div
                                                class="card-body d-flex justify-content-between left-jaw">
                                                @php
                                                $tla_ur = [];
                                                if ($patient->tla_ur != '' && $patient->tla_ur !=
                                                null) {
                                                $tla_ur = unserialize($patient->tla_ur);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="tla_ur" id="tla_ur8" @if (in_array(8,
                                                    $tla_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="tla_ur" id="tla_ur7" @if (in_array(7,
                                                    $tla_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="tla_ur" id="tla_ur6" @if (in_array(6,
                                                    $tla_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="tla_ur" id="tla_ur5" @if (in_array(5,
                                                    $tla_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="tla_ur" id="tla_ur4" @if (in_array(4,
                                                    $tla_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="tla_ur" id="tla_ur3" @if (in_array(3,
                                                    $tla_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="tla_ur" id="tla_ur2" @if (in_array(2,
                                                    $tla_ur)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="tla_ur" id="tla_ur1" @if (in_array(1,
                                                    $tla_ur)) checked @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 tw top right">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex justify-content-between right-jaw">
                                                @php
                                                $tla_ul = [];
                                                if ($patient->tla_ul != '' && $patient->tla_ul !=
                                                null) {
                                                $tla_ul = unserialize($patient->tla_ul);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="tla_ul" id="tla_ul1" @if (in_array(1,
                                                    $tla_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="tla_ul" id="tla_ul2" @if (in_array(2,
                                                    $tla_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="tla_ul" id="tla_ul3" @if (in_array(3,
                                                    $tla_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="tla_ul" id="tla_ul4" @if (in_array(4,
                                                    $tla_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="tla_ul" id="tla_ul5" @if (in_array(5,
                                                    $tla_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="tla_ul" id="tla_ul6" @if (in_array(6,
                                                    $tla_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="tla_ul" id="tla_ul7" @if (in_array(7,
                                                    $tla_ul)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="tla_ul" id="tla_ul8" @if (in_array(8,
                                                    $tla_ul)) checked @endif>
                                            </div>
                                            <div class="side-label right">
                                                U
                                            </div>
                                            <div class="direction-label right">
                                                L
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 tw bottom left">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex justify-content-between left-jaw">
                                                @php
                                                $tla_lr = [];
                                                if ($patient->tla_lr != '' && $patient->tla_lr !=
                                                null) {
                                                $tla_lr = unserialize($patient->tla_lr);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="tla_lr" id="tla_lr8" @if (in_array(8,
                                                    $tla_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="tla_lr" id="tla_lr7" @if (in_array(7,
                                                    $tla_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="tla_lr" id="tla_lr6" @if (in_array(6,
                                                    $tla_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="tla_lr" id="tla_lr5" @if (in_array(5,
                                                    $tla_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="tla_lr" id="tla_lr4" @if (in_array(4,
                                                    $tla_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="tla_lr" id="tla_lr3" @if (in_array(3,
                                                    $tla_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="tla_lr" id="tla_lr2" @if (in_array(2,
                                                    $tla_lr)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="tla_lr" id="tla_lr1" @if (in_array(1,
                                                    $tla_lr)) checked @endif>
                                            </div>
                                            <div class="side-label left">
                                                L
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 tw bottom right">
                                    <div class="teeth-wrapper">
                                        <div class="card border-0">
                                            <div
                                                class="card-body d-flex justify-content-between right-jaw">
                                                @php
                                                $tla_ll = [];
                                                if ($patient->tla_ll != '' && $patient->tla_ll !=
                                                null) {
                                                $tla_ll = unserialize($patient->tla_ll);
                                                }
                                                @endphp
                                                <input type="checkbox" class="tooth" data-number="1"
                                                    name="tla_ll" id="tla_ll1" @if (in_array(1,
                                                    $tla_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="2"
                                                    name="tla_ll" id="tla_ll2" @if (in_array(2,
                                                    $tla_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="3"
                                                    name="tla_ll" id="tla_ll3" @if (in_array(3,
                                                    $tla_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="4"
                                                    name="tla_ll" id="tla_ll4" @if (in_array(4,
                                                    $tla_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="5"
                                                    name="tla_ll" id="tla_ll5" @if (in_array(5,
                                                    $tla_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="6"
                                                    name="tla_ll" id="tla_ll6" @if (in_array(6,
                                                    $tla_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="7"
                                                    name="tla_ll" id="tla_ll7" @if (in_array(7,
                                                    $tla_ll)) checked @endif>
                                                <input type="checkbox" class="tooth" data-number="8"
                                                    name="tla_ll" id="tla_ll8" @if (in_array(8,
                                                    $tla_ll)) checked @endif>
                                            </div>
                                            <div class="side-label right">
                                                L
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3 text-end">
        <button class="btn btn-primary btn-sm waves-effect waves-light px-3 previous-tab" data-target="#pill-tab-li3">Previous</button>
        <button class="btn btn-primary btn-sm waves-effect waves-light px-3" id="submit-prescription"
            @if(($patient->treat_upper_arch == 1 || $patient->treat_lower_arch == 1) &&
            $patient->is_prescription_submitted == 1) fn="1"
            @else
            fn="0" @endif>Next</button>
    </div>
</div>
