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
    @php
        $preferredSizeIssues = $patient->tooth_size_issues ?: ($doctorClinicalPreference->ipr_preference ?? '');
        $preferredLocationUpper = $patient->location_upper ?: ($doctorClinicalPreference->ipr_location_upper ?? '');
        $preferredLocationLower = $patient->location_lower ?: ($doctorClinicalPreference->ipr_location_lower ?? '');
        $preferredLimits = $patient->limits ?: ($doctorClinicalPreference->ipr_max_limit ?? '');
        $preferredResolutionNotes = $patient->resolutions_notes ?: ($doctorClinicalPreference->resolutions_notes ?? '');
    @endphp
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
                <div class="card-body" >
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

                    <span class="fw-medium font-sans-serif text-900" >Additional Attachments</span>
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

                            <div class="form-check">
                                <input class="form-check-input" id="additional_attachments5" name="additional_attachments" type="checkbox" value="Secret Blocks" @if(in_array("Secret Blocks", $additional_attachments)) checked @endif />
                                <label class="form-check-label" for="additional_attachments5">SECRET Blocks
                                    <a href="javascript:;" class="text-info" data-bs-toggle="modal" data-bs-target="#secret-blocks-modal">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                </label>
                            </div>
                    </div>
                    <hr>

                    @if ($patient->is_new == '1')
                    <div class="form-group" style="align-items: center; justify-content: center; display: flex;">
                        <div id="buttons" style="justify-content: center">

                            <style>

                                .attachment-inline {
                                    display: flex;
                                    gap: 8px;
                                    flex-wrap: wrap;
                                    justify-content: center;
                                }
                                .choose-tooth-section-2 {
                                    cursor: pointer;
                                }
                                .inline-item {
                                    display: flex;
                                    flex-direction: column;
                                    align-items: center;
                                    justify-content: center;
                                    gap: 4px;

                                    width: 120px;
                                    min-height: 70px;
                                    padding: 8px 14px;
                                    border-radius: 10px;
                                    border: 1px solid #ddd;
                                    background: #fff;

                                    font-size: 14px;
                                    color: #6b7280;

                                    cursor: pointer;
                                    transition: all 0.2s ease;
                                }

                                .inline-item:has(input:checked) {
                                    border-color: #2bb6a8;
                                    background: #e8fbf8;
                                }

                                /* Hide radio */
                                .inline-item input {
                                    display: none;
                                }

                                /* ICON FIX */
                                .inline-item img {
                                    width: 24px;
                                    height: 24px;
                                    object-fit: contain;
                                }

                                /* Special small icon */
                                .inline-item img[src*="precisioncut"] {
                                    width: 12px;
                                }

                                /* HOVER */
                                .inline-item:hover {
                                    background: #f5f7fa;
                                }

                                /* ACTIVE */
                                .inline-item:has(input:checked),
                                .inline-item.active {
                                    border-color: #2bb6a8;
                                    background: #e8fbf8;
                                }

                                /* TEXT ACTIVE */
                                .inline-item span {
                                    text-align: center;
                                }

                                .inline-item:has(input:checked) span {
                                    color: #2bb6a8;
                                    font-weight: 500;
                                }

                                /* Tooth button overlay styles */
                                .tooth-button-overlay {
                                    border-radius: 50%;
                                    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                                    border: 2px solid #007bff;
                                    transition: all 0.2s ease;
                                }

                                .tooth-button-overlay:hover {
                                    transform: scale(1.1);
                                    box-shadow: 0 4px 8px rgba(0,0,0,0.3);
                                }

                                /* Make tooth containers positioned for absolute children and add space for buttons */
                                #classIIUpperArcNew, #classIIUpperArcNew-2, #classIIUpperArcNew-3, #classIILowerArc, #classIILowerArc-2, #classIILowerArc-3 {
                                    position: relative !important;
                                }

                                #classIIUpperArcNew, #classIIUpperArcNew-2, #classIIUpperArcNew-3 {
                                    padding-top: 30px !important; /* Space for buttons above upper teeth */
                                }

                                #classIILowerArc, #classIILowerArc-2, #classIILowerArc-3 {
                                    padding-bottom: 35px !important; /* Space for buttons below lower teeth */
                                }
                            </style>
                            <input type="hidden" id="feature_button_outer_ids" value="{{ implode(',', arr($patient->button_outer)) }}" name="feature_button_outer_ids">
                            <input type="hidden" id="feature_button_inner_ids" value="{{ implode(',', arr($patient->button_inner)) }}" name="feature_button_inner_ids">
                            <input type="hidden" id="feature_ihook_outer_ids" value="{{ implode(',', arr($patient->ihook_outer)) }}" name="feature_ihook_outer_ids">
                            <input type="hidden" id="feature_ihook_inner_ids" value="{{ implode(',', arr($patient->ihook_inner)) }}" name="feature_ihook_inner_ids">
                            <input type="hidden" id="feature_precision_cut_outer_ids" value="{{ implode(',', arr($patient->precision_cut_outer)) }}" name="feature_precision_cut_outer_ids">
                            <input type="hidden" id="feature_precision_cut_inner_ids" value="{{ implode(',', arr($patient->precision_cut_inner)) }}" name="feature_precision_cut_inner_ids">
                            <input type="hidden" id="feature_bite_turbos_ids" value="{{ implode(',', arr($patient->power_arm_attachment_outer)) }}" name="feature_bite_turbos_ids">
                            <input type="hidden" id="feature_bite_ramp_ids" value="{{ implode(',', arr($patient->power_arm_attachment_inner)) }}" name="feature_bite_ramp_ids">
                            <input type="hidden" id="feature_power_arm_attachment_outer_ids" value="{{ implode(',', arr($patient->power_ridge_outer)) }}" name="feature_power_arm_attachment_outer_ids">
                            <input type="hidden" id="feature_power_arm_attachment_inner_ids" value="{{ implode(',', arr($patient->power_ridge_inner)) }}" name="feature_power_arm_attachment_inner_ids">
                            <input type="hidden" id="feature_power_ridge_outer_ids" value="{{ implode(',', arr($patient->bite_turbos)) }}" name="feature_power_ridge_outer_ids">
                            <input type="hidden" id="feature_power_ridge_inner_ids" value="{{ implode(',', arr($patient->bite_ramp)) }}" name="feature_power_ridge_inner_ids">
                            <div class="attachment-inline">

                                <label class="inline-item">
                                    <input type="radio" name="class-selector" class="class-selector" value="button-cutout" checked="checked">
                                    <img src="{{ asset('public/assets/tooth/png/buttons.webp') }}">
                                    <span class="form-check-label" >Button Cutout</span>
                                </label>

                                <label class="inline-item">
                                    <input type="radio" name="class-selector" class="class-selector" value="precision-cut">
                                    <img src="{{ asset('public/assets/tooth/png/precisioncut.webp') }}">
                                    <span class="form-check-label">Precision Cut</span>
                                </label>

                                <label class="inline-item">
                                    <input type="radio" name="class-selector" class="class-selector" value="i-hook">
                                    <img src="{{ asset('public/assets/tooth/png/I-hook.webp') }}">
                                    <span class="form-check-label">I-Hook</span>
                                </label>

                                <label class="inline-item">
                                    <input type="radio" name="class-selector" class="class-selector" value="power-ridge">
                                    <img src="{{ asset('public/assets/tooth/png/Power-Ridge.webp') }}">
                                    <span class="form-check-label">Power Ridge</span>
                                </label>

                                <label class="inline-item">
                                    <input type="radio" name="class-selector" class="class-selector" value="power-arm-attachment">
                                    <img src="{{ asset('public/assets/tooth/png/Power-Arm-Attachment.webp') }}">
                                    <span class="form-check-label">Power Arm Attachment</span>
                                </label>

                                <label class="inline-item">
                                    <input type="radio" name="class-selector" class="class-selector" value="bite-ramp">
                                    <img src="{{ asset('public/assets/tooth/png/Bite-Ramp.webp') }}">
                                    <span class="form-check-label">Bite Ramp</span>
                                </label>

                                <label class="inline-item">
                                    <input type="radio" name="class-selector" class="class-selector" value="bite-turbos">
                                    <img src="{{ asset('public/assets/tooth/png/Bite-Turbos.webp') }}">
                                    <span class="form-check-label">Bite Turbos</span>
                                </label>

                            </div>


                            @php
                                $allSelections = [
                                    arr($patient->button_outer),
                                    arr($patient->button_inner),
                                    arr($patient->ihook_outer),
                                    arr($patient->ihook_inner),
                                    arr($patient->precision_cut_outer),
                                    arr($patient->precision_cut_inner),
                                    arr($patient->power_arm_attachment_outer),
                                    arr($patient->power_arm_attachment_inner),
                                    arr($patient->power_ridge_outer),
                                    arr($patient->power_ridge_inner),
                                    arr($patient->bite_turbos),
                                    arr($patient->bite_ramp),
                                ];
                                $upperTeeth = [
                                    1=>'UR-8',2=>'UR-7',3=>'UR-6',4=>'UR-5',
                                    5=>'UR-4',6=>'UR-3',7=>'UR-2',8=>'UR-1',
                                    9=>'UL-1',10=>'UL-2',11=>'UL-3',12=>'UL-4',
                                    13=>'UL-5',14=>'UL-6',15=>'UL-7',16=>'UL-8',
                                ];

                                $upperSize = [
                                    1=>'55px',2=>'60px',3=>'60px',4=>'60px',
                                    5=>'60px',6=>'60px',7=>'60px',8=>'65px',
                                    9=>'65px',10=>'60px',11=>'60px',12=>'60px',
                                    13=>'60px',14=>'60px',15=>'60px',16=>'55px',
                                ];

                                $lowerTeeth = [
                                    17=>'LR-8',18=>'LR-7',19=>'LR-6',20=>'LR-5',
                                    21=>'LR-4',22=>'LR-3',23=>'LR-2',24=>'LR-1',
                                    25=>'LL-1',26=>'LL-2',27=>'LL-3',28=>'LL-4',
                                    29=>'LL-5',30=>'LL-6',31=>'LL-7',32=>'LL-8',
                                ];

                                $lowerSize = [
                                    17=>'55px',18=>'60px',19=>'63px',20=>'60px',
                                    21=>'60px',22=>'59px',23=>'54px',24=>'53px',
                                    25=>'53px',26=>'54px',27=>'59px',28=>'60px',
                                    29=>'60px',30=>'63px',31=>'60px',32=>'55px',
                                ];
                            @endphp

                            <div class="col-xs-12" style="margin-top: 10px;">
                                <div class="teeth-layout-wrapper" style="max-width: 1200px; margin: 0 auto;">
                                    <div class="media img-responsive input-group" style="display:flex; flex-wrap: wrap; justify-content:center; gap:10px; padding:0.5rem 0;" id="classIIUpperArcNew">
                                        @foreach($upperTeeth as $id => $tooth)
                                            @php
                                                $buttonOuter = in_array($id, arr($patient->button_outer));
                                                $buttonInner = in_array($id, arr($patient->button_inner));

                                                $ihookOuter = in_array($id, arr($patient->ihook_outer));
                                                $ihookInner = in_array($id, arr($patient->ihook_inner));

                                                $precision_cut_outer = in_array($id, arr($patient->precision_cut_outer));
                                                $precisionCutInner = in_array($id, arr($patient->precision_cut_inner));

                                                $power_arm_attachment_outer = in_array($id, arr($patient->power_arm_attachment_outer));
                                                $power_arm_attachment_inner = in_array($id, arr($patient->power_arm_attachment_inner));

                                                $power_ridge_outer = in_array($id, arr($patient->power_ridge_outer));
                                                $power_ridge_inner = in_array($id, arr($patient->power_ridge_inner));

                                                $bite_turbos = in_array($id, arr($patient->bite_turbos));
                                                $bite_ramp = in_array($id, arr($patient->bite_ramp));

                                                $selected = isSelected($id, $allSelections);
                                                $img = $selected ? "public/assets/tooth/png/selected/$tooth.webp" : "public/assets/tooth/png/$tooth.webp";

                                                $biteRampUpperIds = [6,7,8,9,10,11];
                                                $biteTurbosUpperIds = [1,2,3,4,5,12,13,14,15,16];

                                                $biteRampLowerIds = [22,23,24,25,26,27];
                                                $biteTurbosLowerIds = [17,18,19,20,21,28,29,30,31,32];

                                            @endphp

                                        @if($selected)
                                            <div class="tooth-wrapper" style="position: relative; display: inline-block;">
                                        @endif
                                        <img id="{{ $id }}" class="choose-tooth" data-id="{{ $id }}"  data-image="{{ $tooth }}.webp" src="{{ asset($img) }}" style="vertical-align: baseline;height: {{ $upperSize[$id] }};width: {{ $upperSize[$id] }}; margin-top: 10px; margin-bottom: 5px;">
                                        @if($selected)
                                            @php
                                                $numberOfelementsOuter = 1;
                                                $numberOfelementsInner = 1;
                                            @endphp

                                            {{-- 3. Power Ridge (upper) --}}
                                            @if($power_ridge_outer)
                                                <img src="{{ asset('public/assets/tooth/png/Power-Ridge.webp') }}" class="power-ridge-overlay" data-side="upper" style="position: absolute; width: 30px; height: 20px; left: 50%; transform: translateX(-50%); z-index: 12; top: {{ $numberOfelementsOuter == 1 ? '-25px' : ($numberOfelementsOuter == 2 ? '-60px' : '-90px') }};">
                                                @php $numberOfelementsOuter++; @endphp
                                            @endif

                                            {{-- 2. Power Arm Attachment (upper) --}}
                                            @if($power_arm_attachment_outer)
                                                <img src="{{ asset('public/assets/tooth/png/Power-Arm-Attachment.webp') }}" class="power-arm-attachment-overlay" data-side="upper" style="position: absolute; width: 15px; height: 25px; left: 50%; transform: translateX(-50%); z-index: 11; top: {{ $numberOfelementsOuter == 1 ? '-25px' : ($numberOfelementsOuter == 2 ? '-60px' : '-90px') }};">
                                                @php $numberOfelementsOuter++; @endphp
                                            @endif

                                            {{-- 1. Show only one of Button Cutout, Precision Cut, I-Hook (upper) --}}
                                            @if($buttonOuter)
                                                <img src="{{ asset('public/assets/tooth/png/buttons.webp') }}" class="button-overlay" data-side="upper" style="position: absolute; width: 20px; height: 20px; left: 50%; transform: translateX(-50%); z-index: 10; top: {{ $numberOfelementsOuter == 1 ? '-25px' : ($numberOfelementsOuter == 2 ? '-60px' : '-90px') }};">
                                                @php $numberOfelementsOuter++; @endphp
                                            @elseif($precision_cut_outer)
                                                @if($id >=1 && $id <= 8)
                                                    <img src="{{ asset('public/assets/tooth/png/precisioncut-UR.webp') }}" class="precision-overlay" data-side="upper" style="position: absolute; width: 20px; height: 20px; left: 50%; transform: translateX(-50%); z-index: 10; top: {{ $numberOfelementsOuter == 1 ? '-25px' : ($numberOfelementsOuter == 2 ? '-60px' : '-90px') }};" alt="precisioncut Outer">
                                                    @php $numberOfelementsOuter++; @endphp
                                                @else
                                                    <img src="{{ asset('public/assets/tooth/png/precisioncut-UL.webp') }}" class="precision-overlay" data-side="upper" style="position: absolute; width: 20px; height: 20px; left: 50%; transform: translateX(-50%); z-index: 10; top: {{ $numberOfelementsOuter == 1 ? '-25px' : ($numberOfelementsOuter == 2 ? '-60px' : '-90px') }};" alt="precisioncut Outer">
                                                    @php $numberOfelementsOuter++; @endphp
                                                @endif
                                            @elseif($ihookOuter)
                                                @if($id >=1 && $id <= 8)
                                                    <img src="{{ asset('public/assets/tooth/png/I-hook-UR.webp') }}" class="i-hook-overlay" data-side="upper" style="position: absolute; width: 20px; height: 20px; left: 50%; transform: translateX(-50%); z-index: 10; top: {{ $numberOfelementsOuter == 1 ? '-25px' : ($numberOfelementsOuter == 2 ? '-60px' : '-90px') }};">
                                                    @php $numberOfelementsOuter++; @endphp
                                                @else
                                                    <img src="{{ asset('public/assets/tooth/png/I-hook-UL.webp') }}" class="i-hook-overlay" data-side="upper" style="position: absolute; width: 20px; height: 20px; left: 50%; transform: translateX(-50%); z-index: 10; top: {{ $numberOfelementsOuter == 1 ? '-25px' : ($numberOfelementsOuter == 2 ? '-60px' : '-90px') }};">
                                                    @php $numberOfelementsOuter++; @endphp
                                                @endif
                                            @endif

                                            {{-- 4. Bite Ramp and Bite Turbos (no change needed) --}}
                                            @if($bite_ramp && in_array($id, $biteRampUpperIds))
                                                <img src="{{ asset('public/assets/tooth/png/Bite-Ramp.webp') }}" class="bite-ramp-overlay" style="position: absolute; width: 20px; height: 20px; left: 50%; top: 50%; transform: translate(-50%, -50%); z-index: 13; pointer-events: none;" alt="Bite Ramp Upper">
                                            @endif
                                            @if($bite_turbos && in_array($id, $biteTurbosUpperIds))
                                                <img src="{{ asset('public/assets/tooth/png/Bite-Turbos.webp') }}" class="bite-turbos-overlay" style="position: absolute; width: 25px; height: 20px; left: 50%; top: 50%; transform: translate(-50%, -50%); z-index: 13; pointer-events: none;" alt="Bite Turbos Upper">
                                                {{-- <img src="{{ asset('public/assets/tooth/png/Bite-Turbos.webp') }}" style="position: absolute; width: 25px; height: 20px; left: 50%; top: 50%; transform: translate(-50%, -50%); z-index: 13; pointer-events: none;" alt="Bite Turbos Upper"> --}}
                                            @endif

                                            {{-- Inner Side Start --}}
                                            @if($power_ridge_inner)
                                                <img src="{{ asset('public/assets/tooth/png/Power-Ridge.webp') }}" class="power-ridge-overlay" data-side="lower" style="position: absolute; width: 30px; height: 20px; left: 50%; transform: translateX(-50%); z-index: 12; bottom: {{ $numberOfelementsInner == 1 ? '-25px' : ($numberOfelementsInner == 2 ? '-60px' : '-90px') }}">
                                                @php $numberOfelementsInner++; @endphp
                                            @endif

                                            @if($power_arm_attachment_outer)
                                                <img src="{{ asset('public/assets/tooth/png/Power-Arm-Attachment-lower.webp') }}" class="power-arm-attachment-overlay" data-side="lower" style="position: absolute; width: 15px; height: 25px; left: 50%; transform: translateX(-50%); z-index: 11; bottom: {{ $numberOfelementsInner == 1 ? '-25px' : ($numberOfelementsInner == 2 ? '-60px' : '-90px') }}">
                                                @php $numberOfelementsInner++; @endphp
                                            @endif

                                            @if($buttonInner)
                                                <img src="{{ asset('public/assets/tooth/png/buttons.webp') }}" class="button-overlay" data-side="lower" style="position: absolute; width: 20px; height: 20px; left: 50%; transform: translateX(-50%); z-index: 10; bottom: {{ $numberOfelementsInner == 1 ? '-25px' : ($numberOfelementsInner == 2 ? '-60px' : '-90px') }}">
                                                @php $numberOfelementsInner++; @endphp
                                            @endif

                                            @if($precisionCutInner)
                                                @if($id >=1 && $id <= 8)
                                                    <img src="{{ asset('public/assets/tooth/png/precisioncut-LR.webp') }}" class="precision-overlay" data-side="lower" style="position: absolute; width: 20px; height: 20px; left: 50%; transform: translateX(-50%); z-index: 10; bottom: {{ $numberOfelementsInner == 1 ? '-25px' : ($numberOfelementsInner == 2 ? '-60px' : '-90px') }}">
                                                    @php $numberOfelementsInner++; @endphp
                                                @else
                                                    <img src="{{ asset('public/assets/tooth/png/precisioncut-LL.webp') }}" class="precision-overlay" data-side="lower" style="position: absolute; width: 20px; height: 20px; left: 50%; transform: translateX(-50%); z-index: 10; bottom: {{ $numberOfelementsInner == 1 ? '-25px' : ($numberOfelementsInner == 2 ? '-60px' : '-90px') }}">
                                                    @php $numberOfelementsInner++; @endphp
                                                @endif
                                            @endif

                                            @if($ihookInner)
                                                @if($id >=1 && $id <= 8)
                                                    <img src="{{ asset('public/assets/tooth/png/I-hook-LR.webp') }}" class="i-hook-overlay" data-side="lower" style="position: absolute; width: 20px; height: 20px; left: 50%; transform: translateX(-50%); z-index: 10; bottom: {{ $numberOfelementsInner == 1 ? '-25px' : ($numberOfelementsInner == 2 ? '-60px' : '-90px') }}">
                                                    @php $numberOfelementsInner++; @endphp
                                                @else
                                                    <img src="{{ asset('public/assets/tooth/png/I-hook-LL.webp') }}" class="i-hook-overlay" data-side="lower" style="position: absolute; width: 20px; height: 20px; left: 50%; transform: translateX(-50%); z-index: 10; bottom: {{ $numberOfelementsInner == 1 ? '-25px' : ($numberOfelementsInner == 2 ? '-60px' : '-90px') }}">
                                                    @php $numberOfelementsInner++; @endphp
                                                @endif
                                            @endif

                                            {{-- Inner Side End --}}
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                    <div class="teeth-divider" style="display:flex; align-items:center; justify-content:center; gap:1rem; margin: 0.75rem 0;">
                                        <span style="font-weight:bold;">R</span>
                                        <span style="flex:1; height:1px; background: rgba(177, 175, 175, 0.70);"></span>
                                        <span style="font-weight:bold;">L</span>
                                    </div>
                                    <div class="media img-responsive input-group" style="display:flex; flex-wrap: wrap; justify-content:center; gap:10px; position:relative; padding:0.5rem 0 25px;" id="classIILowerArc">
                                        @foreach($lowerTeeth as $id => $tooth)

                                            @php
                                                $bite_turbos_lower = in_array($id, arr($patient->bite_turbos));
                                                $bite_ramp_lower = in_array($id, arr($patient->bite_ramp));
                                                $selected = isSelected($id, $allSelections);
                                                $img = $selected
                                                    ? "public/assets/tooth/png/selected/$tooth.webp"
                                                    : "public/assets/tooth/png/$tooth.webp";
                                            @endphp
                                            @if($selected)
                                                <div class="tooth-wrapper" style="position: relative; display: inline-block;">
                                            @endif
                                            <img id="{{ $id }}" class="choose-tooth" data-id="{{ $id }}"  data-image="{{ $tooth }}.webp" src="{{ asset($img) }}" style="vertical-align: baseline;height: {{ $lowerSize[$id] }};width: {{ $lowerSize[$id] }}; margin-top: 10px; margin-bottom: 5px;">
                                            @if($selected)
                                                @php
                                                    $lowerNumberOfelementsOuter = 1;
                                                    $lowerNumberOfelementsInner = 1;
                                                @endphp

                                                {{-- 3. Power Ridge (upper) --}}
                                                @if($power_ridge_outer)
                                                    <img src="{{ asset('public/assets/tooth/png/Power-Ridge.webp') }}" class="power-ridge-overlay" data-side="upper" style="position: absolute; width: 30px; height: 20px; left: 50%; transform: translateX(-50%); z-index: 12; top: {{ $lowerNumberOfelementsOuter == 1 ? '-25px' : ($lowerNumberOfelementsOuter == 2 ? '-60px' : '-90px') }};">
                                                    @php $lowerNumberOfelementsOuter++; @endphp
                                                @endif

                                                {{-- 2. Power Arm Attachment (upper) --}}
                                                @if($power_arm_attachment_outer)
                                                    <img src="{{ asset('public/assets/tooth/png/Power-Arm-Attachment.webp') }}" class="power-arm-attachment-overlay" data-side="upper" style="position: absolute; width: 15px; height: 25px; left: 50%; transform: translateX(-50%); z-index: 11; top: {{ $lowerNumberOfelementsOuter == 1 ? '-25px' : ($lowerNumberOfelementsOuter == 2 ? '-60px' : '-90px') }};">
                                                    @php $lowerNumberOfelementsOuter++; @endphp
                                                @endif

                                                {{-- 1. Show only one of Button Cutout, Precision Cut, I-Hook (upper) --}}
                                                @if($buttonOuter)
                                                    <img src="{{ asset('public/assets/tooth/png/buttons.webp') }}" class="button-overlay" data-side="upper" style="position: absolute; width: 20px; height: 20px; left: 50%; transform: translateX(-50%); z-index: 10; top: {{ $lowerNumberOfelementsOuter == 1 ? '-25px' : ($lowerNumberOfelementsOuter == 2 ? '-60px' : '-90px') }};">
                                                    @php $lowerNumberOfelementsOuter++; @endphp
                                                @elseif($precision_cut_outer)
                                                    @if($id >=17 && $id <= 24)
                                                        <img src="{{ asset('public/assets/tooth/png/precisioncut-UR.webp') }}" class="precision-overlay" data-side="upper" style="position: absolute; width: 20px; height: 20px; left: 50%; transform: translateX(-50%); z-index: 10; top: {{ $lowerNumberOfelementsOuter == 1 ? '-25px' : ($lowerNumberOfelementsOuter == 2 ? '-60px' : '-90px') }};" alt="precisioncut Outer">
                                                        @php $lowerNumberOfelementsOuter++; @endphp
                                                    @else
                                                        <img src="{{ asset('public/assets/tooth/png/precisioncut-UL.webp') }}" class="precision-overlay" data-side="upper" style="position: absolute; width: 20px; height: 20px; left: 50%; transform: translateX(-50%); z-index: 10; top: {{ $lowerNumberOfelementsOuter == 1 ? '-25px' : ($lowerNumberOfelementsOuter == 2 ? '-60px' : '-90px') }};" alt="precisioncut Outer">
                                                        @php $lowerNumberOfelementsOuter++; @endphp
                                                    @endif
                                                @elseif($ihookOuter)
                                                    @if($id >=17 && $id <= 24)
                                                        <img src="{{ asset('public/assets/tooth/png/I-hook-UR.webp') }}" class="i-hook-overlay" data-side="upper" style="position: absolute; width: 20px; height: 20px; left: 50%; transform: translateX(-50%); z-index: 10; top: {{ $lowerNumberOfelementsOuter == 1 ? '-25px' : ($lowerNumberOfelementsOuter == 2 ? '-60px' : '-90px') }};">
                                                        @php $lowerNumberOfelementsOuter++; @endphp
                                                    @else
                                                        <img src="{{ asset('public/assets/tooth/png/I-hook-UL.webp') }}" class="i-hook-overlay" data-side="upper" style="position: absolute; width: 20px; height: 20px; left: 50%; transform: translateX(-50%); z-index: 10; top: {{ $lowerNumberOfelementsOuter == 1 ? '-25px' : ($lowerNumberOfelementsOuter == 2 ? '-60px' : '-90px') }};">
                                                        @php $lowerNumberOfelementsOuter++; @endphp
                                                    @endif
                                                @endif

                                                @if($bite_ramp_lower && in_array($id, $biteRampLowerIds))
                                                    <img src="{{ asset('public/assets/tooth/png/Bite-Ramp-lower.webp') }}" class="bite-ramp-overlay" style="position: absolute; width: 20px; height: 20px; left: 50%; top: 50%; transform: translate(-50%, -50%); z-index: 13; pointer-events: none;">
                                                @endif

                                                @if($bite_turbos_lower && in_array($id, $biteTurbosLowerIds))
                                                    <img src="{{ asset('public/assets/tooth/png/Bite-Turbos.webp' ) }}" class="bite-turbos-overlay" style="position: absolute; width: 25px; height: 20px; left: 50%; top: 50%; transform: translate(-50%, -50%); z-index: 13; pointer-events: none;">
                                                @endif

                                                {{-- Inner Start --}}
                                                @if($power_ridge_inner)
                                                    <img src="{{ asset('public/assets/tooth/png/Power-Ridge.webp') }}" class="power-ridge-overlay" data-side="lower" style="position: absolute; width: 30px; height: 20px; left: 50%; transform: translateX(-50%); z-index: 12; bottom: {{ $lowerNumberOfelementsInner == 1 ? '-25px' : ($lowerNumberOfelementsInner == 2 ? '-60px' : '-90px') }}">
                                                    @php $lowerNumberOfelementsInner++; @endphp
                                                @endif

                                                @if($power_arm_attachment_outer)
                                                    <img src="{{ asset('public/assets/tooth/png/Power-Arm-Attachment-lower.webp') }}" class="power-arm-attachment-overlay" data-side="lower" style="position: absolute; width: 15px; height: 25px; left: 50%; transform: translateX(-50%); z-index: 11; bottom: {{ $lowerNumberOfelementsInner == 1 ? '-25px' : ($lowerNumberOfelementsInner == 2 ? '-60px' : '-90px') }}">
                                                    @php $lowerNumberOfelementsInner++; @endphp
                                                @endif

                                                @if($buttonInner)
                                                    <img src="{{ asset('public/assets/tooth/png/buttons.webp') }}" class="button-overlay" data-side="lower" style="position: absolute; width: 20px; height: 20px; left: 50%; transform: translateX(-50%); z-index: 10; bottom: {{ $lowerNumberOfelementsInner == 1 ? '-25px' : ($lowerNumberOfelementsInner == 2 ? '-60px' : '-90px') }}">
                                                    @php $lowerNumberOfelementsInner++; @endphp
                                                @endif

                                                @if($precisionCutInner)
                                                    @if($id >=17 && $id <= 24)
                                                        <img src="{{ asset('public/assets/tooth/png/precisioncut-LR.webp') }}" class="precision-overlay" data-side="lower" style="position: absolute; width: 20px; height: 20px; left: 50%; transform: translateX(-50%); z-index: 10; bottom: {{ $lowerNumberOfelementsInner == 1 ? '-25px' : ($lowerNumberOfelementsInner == 2 ? '-60px' : '-90px') }}">
                                                        @php $lowerNumberOfelementsInner++; @endphp
                                                    @else
                                                        <img src="{{ asset('public/assets/tooth/png/precisioncut-LL.webp') }}" class="precision-overlay" data-side="lower" style="position: absolute; width: 20px; height: 20px; left: 50%; transform: translateX(-50%); z-index: 10; bottom: {{ $lowerNumberOfelementsInner == 1 ? '-25px' : ($lowerNumberOfelementsInner == 2 ? '-60px' : '-90px') }}">
                                                        @php $lowerNumberOfelementsInner++; @endphp
                                                    @endif
                                                @endif

                                                @if($ihookInner)
                                                    @if($id >=17 && $id <= 24)
                                                        <img src="{{ asset('public/assets/tooth/png/I-hook-LR.webp') }}" class="i-hook-overlay" data-side="lower" style="position: absolute; width: 20px; height: 20px; left: 50%; transform: translateX(-50%); z-index: 10; bottom: {{ $lowerNumberOfelementsInner == 1 ? '-25px' : ($lowerNumberOfelementsInner == 2 ? '-60px' : '-90px') }}">
                                                        @php $lowerNumberOfelementsInner++; @endphp
                                                    @else
                                                        <img src="{{ asset('public/assets/tooth/png/I-hook-LL.webp') }}" class="i-hook-overlay" data-side="lower" style="position: absolute; width: 20px; height: 20px; left: 50%; transform: translateX(-50%); z-index: 10; bottom: {{ $lowerNumberOfelementsInner == 1 ? '-25px' : ($lowerNumberOfelementsInner == 2 ? '-60px' : '-90px') }}">
                                                        @php $lowerNumberOfelementsInner++; @endphp
                                                    @endif
                                                @endif

                                            </div>
                                            @endif

                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>


                    @endif

                    @if ($patient->is_new == '0')
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
                    @endif

                    <div class="mb-3" style="text-align: left">
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
                    <span class="fw-medium font-sans-serif text-900" >Resolve Tooth Size Issues</span>
                    <div class="mb-3">
                        <label>Please select one of the following options.</label>
                        <div class="form-check">
                            <input class="form-check-input" id="size_issues1" type="radio"
                                name="size_issues" value="IPR" @if ($preferredSizeIssues ==
                            'IPR') checked @endif />
                            <label class="form-check-label" for="size_issues1">IPR</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" id="size_issues2" type="radio"
                                name="size_issues" value="Restorative (No IPR)"
                                @if($preferredSizeIssues == 'Restorative (No IPR)')
                            checked @endif />
                            <label class="form-check-label" for="size_issues2">Restorative (No
                                IPR)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" id="size_issues3" type="radio"
                                name="size_issues" value="Accept best fit (No IPR/Restorative)"
                                @if($preferredSizeIssues == 'Accept best fit (No
                            IPR/Restorative)') checked @endif />
                            <label class="form-check-label" for="size_issues3">Accept best fit (No IPR/Restorative)</label>
                        </div>
                    </div>
                    <hr>
                    <div id="presc-location-section" class="{{ $preferredSizeIssues == 'IPR' ? '' : 'd-none'}}">
                    <span class="fw-medium font-sans-serif text-900" >Location</span>
                    <div class="mb-3">
                        <label>Upper</label>
                        <select id="location_upper" name="location_upper" class="form-select">
                            <option value="" selected disabled>Select</option>
                            <option value="3-3" @if ($preferredLocationUpper == '3-3') selected
                                @endif>3-3</option>
                            <option value="4-4" @if ($preferredLocationUpper == '4-4') selected
                                @endif>4-4</option>
                            <option value="6-6" @if ($preferredLocationUpper == '6-6') selected
                                @endif>6-6</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Lower</label>
                        <select id="location_lower" name="location_lower" class="form-select">
                            <option value="" selected disabled>Select</option>
                            <option value="3-3" @if ($preferredLocationLower == '3-3') selected
                                @endif>3-3</option>
                            <option value="4-4" @if ($preferredLocationLower == '4-4') selected
                                @endif>4-4</option>
                            <option value="6-6" @if ($preferredLocationLower == '6-6') selected
                                @endif>6-6</option>
                        </select>
                    </div>
                    <hr>
                    </div>
                    <div id="pres-limits-section"  class="{{ $preferredSizeIssues == 'IPR' ? '' : 'd-none'}}">
                        <span class="fw-medium font-sans-serif text-900" >Limits</span>
                        <div class="mb-3">
                            <label>Maximum Ant. IPR/Contact 0.1-0.6mm</label>
                            <input class="form-control" type="number" name="limits"
                                value="{{ $preferredLimits }}" id="limits" step="0.05" min="0.1"
                                max="0.6">
                        </div>
                        <hr>
                    </div>

                    @if ($patient->is_new == '0')
                    <span class="fw-medium font-sans-serif text-900" >Open space for future Prosthesis</span>
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
                    @endif

                    @if ($patient->is_new == '1')
                        <div class="form-group" style="align-items: center; justify-content: center; display: flex;">
                            <div id="buttons" style="justify-content: center">
                                <div class="attachment-inline">



                                    <label class="inline-item">
                                        <input type="radio" name="class-selector-section-2" class="class-selector-section-2" value="unerupted-teeth" checked="checked">
                                        {{-- <img src="{{ asset('public/assets/tooth/png/precisioncut.webp') }}"> --}}
                                        <span class="form-check-label">Missing or Unerupted teeth</span>
                                    </label>

                                    <label class="inline-item">
                                        <input type="radio" name="class-selector-section-2" class="class-selector-section-2" value="extracted-teeth"  >
                                        <img src="{{ asset('public/assets/tooth/png/extracted.webp') }}">
                                        <span class="form-check-label">To be Extracted</span>
                                    </label>

                                    <label class="inline-item">
                                        <input type="radio" name="class-selector-section-2" class="class-selector-section-2" value="tooth-movement-restrictions">
                                        <img src="{{ asset('public/assets/tooth/png/movement.webp') }}">
                                        <span class="form-check-label">Tooth Movement Restrictions</span>
                                    </label>

                                    <label class="inline-item">
                                        <input type="radio" name="class-selector-section-2" class="class-selector-section-2" value="coil" >
                                        <img src="{{ asset('public/assets/tooth/png/coil.webp') }}" style="width: 36px">
                                        <span class="form-check-label">Open space for future Prosthesis</span>
                                    </label>

                                    <label class="inline-item">
                                        <input type="radio" name="class-selector-section-2" class="class-selector-section-2" value="pontic">
                                        <img src="{{ asset('public/assets/tooth/png/pontic.webp') }}" style="width: 36px;height: 36px;">
                                        <span class="form-check-label">Pontic</span>
                                    </label>

                                    <label class="inline-item">
                                        <input type="radio" name="class-selector-section-2" class="class-selector-section-2" value="bridge">
                                        <img src="{{ asset('public/assets/tooth/png/Bridge.webp') }}" style="width: 48px">
                                        <span class="form-check-label">Bridge</span>
                                    </label>

                                </div>
                                @php
                                    $allSelections2 = [
                                        arr($patient->unerupted_teeth),
                                        arr($patient->extracted_teeth),
                                        arr($patient->tooth_movement_restrictions),
                                        arr($patient->coil),
                                        arr($patient->pontic),
                                        arr($patient->bridge),
                                    ];


                                @endphp
                                <input type="hidden" id="feature_unerupted_teeth_ids" value="{{ implode(',', arr($patient->unerupted_teeth)) }}" name="feature_unerupted_teeth_ids">
                                <input type="hidden" id="feature_extracted_teethids" value="{{ implode(',', arr($patient->extracted_teeth)) }}" name="feature_extracted_teethids">
                                <input type="hidden" id="feature_tooth_movement_restrictions_ids" value="{{ implode(',', arr($patient->tooth_movement_restrictions)) }}" name="feature_tooth_movement_restrictions_ids">
                                <input type="hidden" id="feature_coil_ids" value="{{ implode(',', arr($patient->coil)) }}" name="feature_coil_ids">
                                <input type="hidden" id="feature_pontic_ids" value="{{ implode(',', arr($patient->pontic)) }}" name="feature_pontic_ids">
                                <input type="hidden" id="feature_bridge_ids" value="{{ implode(',', arr($patient->bridge)) }}" name="feature_bridge_ids">

                                <div class="col-xs-12" style="margin-top: 10px;">
                                    <div class="teeth-layout-wrapper" style="max-width: 1200px; margin: 0 auto;">
                                        <div class="media img-responsive input-group" style="display:flex; flex-wrap: wrap; justify-content:center; gap:10px; padding:0.5rem 0;" id="classIIUpperArcNew-2">
                                            @foreach($upperTeeth as $id => $tooth)
                                                @php
                                                    $unerupted_teeth = in_array($id, arr($patient->unerupted_teeth));
                                                    $extracted_teeth = in_array($id, arr($patient->extracted_teeth));
                                                    $tooth_movement_restrictions = in_array($id, arr($patient->tooth_movement_restrictions));
                                                    $coil = in_array($id, arr($patient->coil));
                                                    $pontic = in_array($id, arr($patient->pontic));
                                                    $bridge = in_array($id, arr($patient->bridge));

                                                    $selected2 = isSelected($id, $allSelections2);
                                                    if ($unerupted_teeth && !$pontic) {
                                                        $img2 = "public/assets/tooth/png/$tooth.webp"; // Do not show image
                                                    } elseif ($pontic) {
                                                        $img2 = "public/assets/tooth/coloured/$tooth.webp";
                                                    } else {
                                                        $img2 = $selected2
                                                            ? "public/assets/tooth/png/selected/$tooth.webp"
                                                            : "public/assets/tooth/png/$tooth.webp";
                                                    }
                                                    // $img2 = $selected2 ? "public/assets/tooth/png/selected/$tooth.webp" : "public/assets/tooth/png/$tooth.webp";
                                                @endphp

                                                @if($selected2)
                                                <div class="tooth-wrapper-2" style="position: relative; display: inline-block;">
                                                @endif

                                                <img id="{{ $id }}" class="choose-tooth-section-2" data-id="{{ $id }}"  data-image="{{ $tooth }}.webp" src="{{ asset($img2) }}" style="vertical-align: baseline;height: {{ $upperSize[$id] }};width: {{ $upperSize[$id] }}; margin-top: 10px; margin-bottom: 5px; {{ ($unerupted_teeth && !$pontic)  ? 'opacity:0' : ''}}">

                                                @if($selected2)
                                                    @php
                                                        $numberOfelementsSection2 = 1;
                                                    @endphp

                                                    @if($coil)
                                                        <img class="section2-overlay coil-overlay" src="{{ asset('public/assets/tooth/png/coil.webp') }}" alt="coil" data-side="upper" style="object-fit: contain; position: absolute; left: 50%; width: 50px; height: 24px; transform: translateX(-50%); z-index: 10; pointer-events: none; top: {{ $numberOfelementsSection2 == 1 ? '-16px' : ($numberOfelementsSection2 == 2 ? '-46px' : ($numberOfelementsSection2 == 3 ? '-74px' : '-102px')) }};">
                                                        @php $numberOfelementsSection2++; @endphp
                                                    @endif

                                                    @if($extracted_teeth)
                                                        <img class="section2-overlay extracted-overlay" src="{{ asset('public/assets/tooth/png/extracted.webp ') }}" alt="extracted" data-side="upper" style="object-fit: contain; position: absolute; left: 50%; width: 22px; height: 22px; transform: translateX(-50%); z-index: 10; pointer-events: none; top: {{ $numberOfelementsSection2 == 1 ? '-16px' : ($numberOfelementsSection2 == 2 ? '-46px' : ($numberOfelementsSection2 == 3 ? '-74px' : '-102px')) }};">
                                                        @php $numberOfelementsSection2++; @endphp
                                                    @endif

                                                    @if($tooth_movement_restrictions)
                                                        <img class="section2-overlay movement-overlay" src="{{ asset('public/assets/tooth/png/movement.webp ') }}" alt="movement" data-side="upper" style="object-fit: contain; position: absolute; left: 50%; width: 22px; height: 22px; transform: translateX(-50%); z-index: 10; pointer-events: none; top: {{ $numberOfelementsSection2 == 1 ? '-16px' : ($numberOfelementsSection2 == 2 ? '-46px' : ($numberOfelementsSection2 == 3 ? '-74px' : '-102px')) }};">
                                                        @php $numberOfelementsSection2++; @endphp
                                                    @endif

                                                    @if($bridge)
                                                        <img class="section2-overlay bridge-overlay" src="{{ asset('public/assets/tooth/png/Bridge.webp') }}" alt="bridge" data-side="upper" style="position: absolute; left: 50%; width: 44px; height: 24px; transform: translateX(-50%); z-index: 11; pointer-events: none; object-fit: contain; top: {{ $numberOfelementsSection2 == 1 ? '-16px' : ($numberOfelementsSection2 == 2 ? '-46px' : ($numberOfelementsSection2 == 3 ? '-74px' : '-102px')) }};">
                                                        @php $numberOfelementsSection2++; @endphp
                                                    @endif

                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="teeth-divider" style="display:flex; align-items:center; justify-content:center; gap:1rem; margin: 0.75rem 0;">
                                            <span style="font-weight:bold;">R</span>
                                            <span style="flex:1; height:1px; background: rgba(177, 175, 175, 0.70);"></span>
                                            <span style="font-weight:bold;">L</span>
                                        </div>
                                        <div class="media img-responsive input-group" style="display:flex; flex-wrap: wrap; justify-content:center; gap:10px; position:relative; padding:0.5rem 0 25px;" id="classIILowerArc-2">

                                            @foreach($lowerTeeth as $id => $tooth)
                                                @php

                                                    $unerupted_teeth = in_array($id, arr($patient->unerupted_teeth));
                                                    $extracted_teeth = in_array($id, arr($patient->extracted_teeth));
                                                    $tooth_movement_restrictions = in_array($id, arr($patient->tooth_movement_restrictions));
                                                    $coil = in_array($id, arr($patient->coil));
                                                    $pontic = in_array($id, arr($patient->pontic));
                                                    $bridge = in_array($id, arr($patient->bridge));

                                                    $selected2 = isSelected($id, $allSelections2);
                                                    if ($unerupted_teeth && !$pontic) {
                                                        $img2 = "public/assets/tooth/png/$tooth.webp";
                                                    } elseif ($pontic) {
                                                        $img2 = "public/assets/tooth/coloured/$tooth.webp";
                                                    } else {
                                                        $img2 = $selected2
                                                            ? "public/assets/tooth/png/selected/$tooth.webp"
                                                            : "public/assets/tooth/png/$tooth.webp";
                                                    }
                                                    // $img2 = $selected2 ? "public/assets/tooth/png/selected/$tooth.webp" : "public/assets/tooth/png/$tooth.webp";
                                                @endphp

                                                @if($selected2)
                                                    <div class="tooth-wrapper-2" style="position: relative; display: inline-block;">
                                                @endif
                                                <img id="{{ $id }}" class="choose-tooth-section-2" data-id="{{ $id }}"  data-image="{{ $tooth }}.webp" src="{{ asset($img2) }}" style="vertical-align: baseline;height: {{ $lowerSize[$id] }};width: {{ $lowerSize[$id] }}; margin-bottom: 5px; {{ ($unerupted_teeth && !$pontic)  ? 'opacity:0' : ''}}">
                                                @if($selected2)
                                                    @php
                                                        $numberOfelementsSectionLower2 = 1;
                                                    @endphp

                                                    @if($coil)
                                                        <img class="section2-overlay coil-overlay" src="{{ asset('public/assets/tooth/png/coil.webp') }}" alt="coil" data-side="lower" style="object-fit: contain; position: absolute; left: 50%; width: 50px; height: 24px; transform: translateX(-50%); z-index: 10; pointer-events: none; bottom: {{ $numberOfelementsSectionLower2 == 1 ? '-16px' : ($numberOfelementsSectionLower2 == 2 ? '-46px' : ($numberOfelementsSectionLower2 == 3 ? '-74px' : '-102px')) }} ;">
                                                        @php $numberOfelementsSectionLower2++; @endphp
                                                    @endif

                                                    @if($extracted_teeth)
                                                        <img class="section2-overlay extracted-overlay" src="{{ asset('public/assets/tooth/png/extracted.webp ') }}" alt="extracted" data-side="upper" style="object-fit: contain; position: absolute; left: 50%; width: 22px; height: 22px; transform: translateX(-50%); z-index: 10; pointer-events: none; bottom: {{ $numberOfelementsSectionLower2 == 1 ? '-16px' : ($numberOfelementsSectionLower2 == 2 ? '-46px' : ($numberOfelementsSectionLower2 == 3 ? '-74px' : '-102px')) }} ;">
                                                        @php $numberOfelementsSectionLower2++; @endphp
                                                    @endif

                                                    @if($tooth_movement_restrictions)
                                                        <img class="section2-overlay movement-overlay" src="{{ asset('public/assets/tooth/png/movement.webp ') }}" alt="movement" data-side="upper" style="object-fit: contain; position: absolute; left: 50%; width: 22px; height: 22px; transform: translateX(-50%); z-index: 10; pointer-events: none; bottom: {{ $numberOfelementsSectionLower2 == 1 ? '-16px' : ($numberOfelementsSectionLower2 == 2 ? '-46px' : ($numberOfelementsSectionLower2 == 3 ? '-74px' : '-102px')) }} ;">
                                                        @php $numberOfelementsSectionLower2++; @endphp
                                                    @endif

                                                    @if($bridge)
                                                        <img class="section2-overlay bridge-overlay" src="{{ asset('public/assets/tooth/png/Bridge.webp') }}" alt="bridge" data-side="upper" style="position: absolute; left: 50%; width: 44px; height: 24px; transform: translateX(-50%); z-index: 11; pointer-events: none; object-fit: contain; bottom: {{ $numberOfelementsSectionLower2 == 1 ? '-16px' : ($numberOfelementsSectionLower2 == 2 ? '-46px' : ($numberOfelementsSectionLower2 == 3 ? '-74px' : '-102px')) }} ;">
                                                        @php $numberOfelementsSectionLower2++; @endphp
                                                    @endif

                                                    </div>
                                                @endif
                                             @endforeach
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <hr>
                    @endif

                    <div class="mb-3" style="text-align: left">
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


                    @if($patient->is_new == '0')
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
                    @endif
                    <span class="fw-medium font-sans-serif text-900" >Aesthetic start</span>
                    <div class="mb-3">

                        <div class="form-check form-switch">
                            <input class="form-check-input" id="aesthetic_start2" type="radio"
                                name="aesthetic_start" value="0" @if ($patient->aesthetic_start == '0') checked="checked" @endif />
                            <label class="form-check-label" for="aesthetic_start2">No</label>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" id="aesthetic_start1" type="radio"
                                name="aesthetic_start" value="1" @if ($patient->aesthetic_start == '1') checked="checked" @endif />
                            <label class="form-check-label" for="aesthetic_start1">Yes</label>
                        </div>
                    </div>

                    <span class="fw-medium font-sans-serif text-900" >Primary Esthetic Objective for Anterior Leveling</span>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" id="anterior_leveling1" type="radio"
                                name="anterior_leveling" value="1" @if ($patient->anterior_leveling == '1') checked="checked" @endif />
                            <label class="form-check-label" for="anterior_leveling1">
                                Incisal Edge Harmony
                                <a href="javascript:;" class="text-info" data-bs-toggle="modal" data-bs-target="#text-info-modal" data-info-title="Incisal Edge Harmony" data-info="A consistent smile arc and incisal symmetry (potential gingival discrepancies will be managed post-treatment).">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" id="anterior_leveling2" type="radio"
                                name="anterior_leveling" value="0" @if ($patient->anterior_leveling == '0') checked="checked" @endif />
                            <label class="form-check-label" for="anterior_leveling2">
                                Gingival Margin Symmetry
                                    <a href="javascript:;" class="text-info" data-bs-toggle="modal" data-bs-target="#text-info-modal" data-info-title="Gingival Margin Symmetry" data-info="Prioritize level gingival zeniths (incisal edge discrepancies will be managed via restorative bonding/enameloplasty).">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                            </label>
                        </div>
                    </div>

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



                    <span class="fw-medium font-sans-serif text-900" >Aligner Trim Type</span>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Upper</label>
                            <div class="form-check">
                                <input class="form-check-input trim_type_upper" id="trim_type_upper1" type="radio" name="trim_type_upper" value="Straight" @if ($patient->trim_type_upper == 'Straight') checked @endif />
                                <label class="form-check-label" for="trim_type_upper1">Straight</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input trim_type_upper" id="trim_type_upper2" type="radio" name="trim_type_upper" value="Scalloped" @if($patient->trim_type_upper == 'Scalloped')  checked @endif />
                                <label class="form-check-label" for="trim_type_upper2">Scalloped</label>
                            </div>

                            <div id="trim_type_upper_show" class="{{ $patient->trim_type_upper == 'Straight' ? '' : 'd-none'}}">
                                <div class="mb-3">
                                    <label>Upper</label>
                                    <select id="trim_type_upper_upper" name="trim_type_upper_upper" class="form-select">
                                        <option value="" selected disabled>Select</option>
                                        <option value="0" @if ($patient->trim_type_upper_straight_upper == '0') selected @endif>Standard (1-1.5mm beyond the gingival margins)</option>
                                        <option value="1" @if ($patient->trim_type_upper_straight_upper == '1') selected @endif> High Trim Line (2.5-3mm beyond the gingival margins)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Lower</label>
                            <div class="form-check">
                                <input class="form-check-input trim_type_lower" id="trim_type_lower1" type="radio" name="trim_type_lower" value="Straight" @if ($patient->trim_type_lower == 'Straight') checked @endif />
                                <label class="form-check-label" for="trim_type_lower1">Straight</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input trim_type_lower" id="trim_type_lower2" type="radio" name="trim_type_lower" value="Scalloped" @if($patient->trim_type_lower == 'Scalloped')  checked @endif />
                                <label class="form-check-label" for="trim_type_lower2">Scalloped</label>
                            </div>

                            <div id="trim_type_lower_show" class="{{ $patient->trim_type_lower == 'Straight' ? '' : 'd-none'}}">
                                <div class="mb-3">
                                    <label>Upper</label>
                                    <select id="trim_type_lower_upper trim_type_lower" name="trim_type_lower_upper" class="form-select">
                                        <option value="" selected disabled>Select</option>
                                        <option value="0" @if ($patient->trim_type_lower_straight_lower == '0') selected @endif>Standard (1-1.5mm beyond the gingival margins)</option>
                                        <option value="1" @if ($patient->trim_type_lower_straight_lower == '1') selected @endif> High Trim Line (2.5-3mm beyond the gingival margins)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <span class="fw-medium font-sans-serif text-900" >Please Mark the last tooth you want the aligners to cover</span>
                        @php
                            $tla_ur = [];
                            if ($patient->tla_ur != '' && $patient->tla_ur != null) {
                                $tla_ur = unserialize($patient->tla_ur);
                            }

                            $tla_ul = [];
                            if ($patient->tla_ul != '' && $patient->tla_ul != null) {
                                $tla_ul = unserialize($patient->tla_ul);
                            }
                            $tla_lr = [];
                            if ($patient->tla_lr != '' && $patient->tla_lr != null) {
                                $tla_lr = unserialize($patient->tla_lr);
                            }
                            $tla_ll = [];
                            if ($patient->tla_ll != '' && $patient->tla_ll != null) {
                                $tla_ll = unserialize($patient->tla_ll);
                            }
                            // dd($tla_ur, $tla_ul, $tla_lr, $tla_ll, in_array(1, $tla_ur));
                        @endphp

                        {{-- <input type="text" id="tla_ur" data-id="ur" value="[{{implode(',', unserialize($patient->tla_ur))}}]">
                        <input type="text" id="tla_ul" data-id="ul" value="[{{implode(',', unserialize($patient->tla_ul))}}]">
                        <input type="text" id="tla_lr" data-id="lr" value="[{{implode(',', unserialize($patient->tla_lr))}}]">
                        <input type="text" id="tla_ll" data-id="ll" value="[{{implode(',', unserialize($patient->tla_ll))}}]"> --}}
                        <div class="form-group" style="align-items: center; justify-content: center; display: flex;">
                        <div id="buttons" style="justify-content: center">
                            <div class="col-xs-12">
                                <div class="teeth-layout-wrapper" style="max-width: 1200px; margin: 0 auto;">
                                    <div class="media img-responsive input-group" style="display:flex; flex-wrap: wrap; justify-content:center; gap:10px; padding:0.5rem 0;" id="classIIUpperArcNew-3">
                                        <img id="1" class="choose-tooth-aligners-to-cover" data-id="1"  data-image="UR-8.webp" src="{{ in_array(8, $tla_ur) ?  asset('public/assets/tooth/coloured/UR-8.webp') : asset('public/assets/tooth/png/UR-8.webp') }}" style="vertical-align: baseline;height: 55px;width: 55px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="2" class="choose-tooth-aligners-to-cover" data-id="2"  data-image="UR-7.webp" src="{{ in_array(7, $tla_ur) ?  asset('public/assets/tooth/coloured/UR-7.webp') : asset('public/assets/tooth/png/UR-7.webp') }}" style="vertical-align: baseline;height: 60px;width: 60px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="3" class="choose-tooth-aligners-to-cover" data-id="3"  data-image="UR-6.webp" src="{{ in_array(6, $tla_ur) ?  asset('public/assets/tooth/coloured/UR-6.webp') : asset('public/assets/tooth/png/UR-6.webp') }}" style="vertical-align: baseline;height: 60px;width: 60px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="4" class="choose-tooth-aligners-to-cover" data-id="4"  data-image="UR-5.webp" src="{{ in_array(5, $tla_ur) ?  asset('public/assets/tooth/coloured/UR-5.webp') : asset('public/assets/tooth/png/UR-5.webp') }}" style="vertical-align: baseline;height: 60px;width: 60px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="5" class="choose-tooth-aligners-to-cover" data-id="5"  data-image="UR-4.webp" src="{{ in_array(4, $tla_ur) ?  asset('public/assets/tooth/coloured/UR-4.webp') : asset('public/assets/tooth/png/UR-4.webp') }}" style="vertical-align: baseline;height: 60px;width: 60px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="6" class="choose-tooth-aligners-to-cover" data-id="6"  data-image="UR-3.webp" src="{{ in_array(3, $tla_ur) ?  asset('public/assets/tooth/coloured/UR-3.webp') : asset('public/assets/tooth/png/UR-3.webp') }}" style="vertical-align: baseline;height: 60px;width: 60px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="7" class="choose-tooth-aligners-to-cover" data-id="7"  data-image="UR-2.webp" src="{{ in_array(2, $tla_ur) ?  asset('public/assets/tooth/coloured/UR-2.webp') : asset('public/assets/tooth/png/UR-2.webp') }}" style="vertical-align: baseline;height: 60px;width: 60px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="8" class="choose-tooth-aligners-to-cover" data-id="8"  data-image="UR-1.webp" src="{{ in_array(1, $tla_ur) ?  asset('public/assets/tooth/coloured/UR-1.webp') : asset('public/assets/tooth/png/UR-1.webp') }}" style="vertical-align: baseline;height: 65px;width: 65px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="9" class="choose-tooth-aligners-to-cover" data-id="9"  data-image="UL-1.webp" src="{{ in_array(1, $tla_ul) ?  asset('public/assets/tooth/coloured/UL-1.webp') : asset('public/assets/tooth/png/UL-1.webp') }}" style="vertical-align: baseline;height: 65px;width: 65px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="10" class="choose-tooth-aligners-to-cover" data-id="10"  data-image="UL-2.webp" src="{{ in_array(2, $tla_ul) ?  asset('public/assets/tooth/coloured/UL-2.webp') : asset('public/assets/tooth/png/UL-2.webp') }}" style="vertical-align: baseline;height: 60px;width: 60px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="11" class="choose-tooth-aligners-to-cover" data-id="11"  data-image="UL-3.webp" src="{{ in_array(3, $tla_ul) ?  asset('public/assets/tooth/coloured/UL-3.webp') : asset('public/assets/tooth/png/UL-3.webp') }}" style="vertical-align: baseline;height: 60px;width: 60px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="12" class="choose-tooth-aligners-to-cover" data-id="12"  data-image="UL-4.webp" src="{{ in_array(4, $tla_ul) ?  asset('public/assets/tooth/coloured/UL-4.webp') : asset('public/assets/tooth/png/UR-4.webp') }}" style="vertical-align: baseline;height: 60px;width: 60px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="13" class="choose-tooth-aligners-to-cover" data-id="13"  data-image="UL-5.webp" src="{{ in_array(5, $tla_ul) ?  asset('public/assets/tooth/coloured/UL-5.webp') : asset('public/assets/tooth/png/UR-5.webp') }}" style="vertical-align: baseline;height: 60px;width: 60px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="14" class="choose-tooth-aligners-to-cover" data-id="14"  data-image="UL-6.webp" src="{{ in_array(6, $tla_ul) ?  asset('public/assets/tooth/coloured/UL-6.webp') : asset('public/assets/tooth/png/UR-6.webp') }}" style="vertical-align: baseline;height: 60px;width: 60px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="15" class="choose-tooth-aligners-to-cover" data-id="15"  data-image="UL-7.webp" src="{{ in_array(7, $tla_ul) ?  asset('public/assets/tooth/coloured/UL-7.webp') : asset('public/assets/tooth/png/UR-7.webp') }}" style="vertical-align: baseline;height: 60px;width: 60px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="16" class="choose-tooth-aligners-to-cover" data-id="16"  data-image="UL-8.webp" src="{{ in_array(8, $tla_ul) ?  asset('public/assets/tooth/coloured/UL-8.webp') : asset('public/assets/tooth/png/UR-8.webp') }}" style="vertical-align: baseline;height: 55px;width: 55px; margin-top: 10px; margin-bottom: 5px;">
                                    </div>

                                    <div class="teeth-divider" style="display:flex; align-items:center; justify-content:center; gap:1rem; margin: 0.75rem 0;">
                                        <span style="font-weight:bold;">R</span>
                                        <span style="flex:1; height:1px; background: rgba(177, 175, 175, 0.70);"></span>
                                        <span style="font-weight:bold;">L</span>
                                    </div>

                                    <div class="media img-responsive input-group" style="display:flex; flex-wrap: wrap; justify-content:center; gap:10px; position:relative; padding:0.5rem 0 25px;" id="classIILowerArc-3">
                                        <img id="17" class="choose-tooth-aligners-to-cover" data-id="17"  data-image="LR-8.webp"  src="{{ in_array(8, $tla_lr) ?  asset('public/assets/tooth/coloured/LR-8.webp') :  asset('public/assets/tooth/png/LR-8.webp') }}" style="vertical-align: baseline;height: 55px;width: 55px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="18" class="choose-tooth-aligners-to-cover" data-id="18"  data-image="LR-7.webp"  src="{{ in_array(7, $tla_lr) ?  asset('public/assets/tooth/coloured/LR-7.webp') :  asset('public/assets/tooth/png/LR-7.webp') }}" style="vertical-align: baseline;height: 60px;width: 60px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="19" class="choose-tooth-aligners-to-cover" data-id="19"  data-image="LR-6.webp"  src="{{ in_array(6, $tla_lr) ?  asset('public/assets/tooth/coloured/LR-6.webp') :  asset('public/assets/tooth/png/LR-6.webp') }}" style="vertical-align: baseline;height: 63px;width: 63px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="20" class="choose-tooth-aligners-to-cover" data-id="20"  data-image="LR-5.webp"  src="{{ in_array(5, $tla_lr) ?  asset('public/assets/tooth/coloured/LR-5.webp') :  asset('public/assets/tooth/png/LR-5.webp') }}" style="vertical-align: baseline;height: 60px;width: 60px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="21" class="choose-tooth-aligners-to-cover" data-id="21"  data-image="LR-4.webp"  src="{{ in_array(4, $tla_lr) ?  asset('public/assets/tooth/coloured/LR-4.webp') :  asset('public/assets/tooth/png/LR-4.webp') }}" style="vertical-align: baseline;height: 60px;width: 60px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="22" class="choose-tooth-aligners-to-cover" data-id="22"  data-image="LR-3.webp"  src="{{ in_array(3, $tla_lr) ?  asset('public/assets/tooth/coloured/LR-3.webp') :  asset('public/assets/tooth/png/LR-3.webp') }}" style="vertical-align: baseline;height: 59px;width: 59px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="23" class="choose-tooth-aligners-to-cover" data-id="23"  data-image="LR-2.webp"  src="{{ in_array(2, $tla_lr) ?  asset('public/assets/tooth/coloured/LR-2.webp') :  asset('public/assets/tooth/png/LR-2.webp') }}" style="vertical-align: baseline;height: 54px;width: 54px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="24" class="choose-tooth-aligners-to-cover" data-id="24"  data-image="LR-1.webp"  src="{{ in_array(1, $tla_lr) ?  asset('public/assets/tooth/coloured/LR-1.webp') :  asset('public/assets/tooth/png/LR-1.webp') }}" style="vertical-align: baseline;height: 53px;width: 53px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="25" class="choose-tooth-aligners-to-cover" data-id="25"  data-image="LL-1.webp"  src="{{ in_array(1, $tla_ll) ?  asset('public/assets/tooth/coloured/LL-1.webp') :  asset('public/assets/tooth/png/LL-1.webp') }}" style="vertical-align: baseline;height: 53px;width: 53px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="26" class="choose-tooth-aligners-to-cover" data-id="26"  data-image="LL-2.webp"  src="{{ in_array(2, $tla_ll) ?  asset('public/assets/tooth/coloured/LL-2.webp') :  asset('public/assets/tooth/png/LL-2.webp') }}" style="vertical-align: baseline;height: 54px;width: 54px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="27" class="choose-tooth-aligners-to-cover" data-id="27"  data-image="LL-3.webp"  src="{{ in_array(3, $tla_ll) ?  asset('public/assets/tooth/coloured/LL-3.webp') :  asset('public/assets/tooth/png/LL-3.webp') }}" style="vertical-align: baseline;height: 59px;width: 59px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="28" class="choose-tooth-aligners-to-cover" data-id="28"  data-image="LL-4.webp"  src="{{ in_array(4, $tla_ll) ?  asset('public/assets/tooth/coloured/LL-4.webp') :  asset('public/assets/tooth/png/LL-4.webp') }}" style="vertical-align: baseline;height: 60px;width: 60px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="29" class="choose-tooth-aligners-to-cover" data-id="29"  data-image="LL-5.webp"  src="{{ in_array(5, $tla_ll) ?  asset('public/assets/tooth/coloured/LL-5.webp') :  asset('public/assets/tooth/png/LL-5.webp') }}" style="vertical-align: baseline;height: 60px;width: 60px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="30" class="choose-tooth-aligners-to-cover" data-id="30"  data-image="LL-6.webp"  src="{{ in_array(6, $tla_ll) ?  asset('public/assets/tooth/coloured/LL-6.webp') :  asset('public/assets/tooth/png/LL-6.webp') }}" style="vertical-align: baseline;height: 63px;width: 63px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="31" class="choose-tooth-aligners-to-cover" data-id="31"  data-image="LL-7.webp"  src="{{ in_array(7, $tla_ll) ?  asset('public/assets/tooth/coloured/LL-7.webp') :  asset('public/assets/tooth/png/LL-7.webp') }}" style="vertical-align: baseline;height: 60px;width: 60px; margin-top: 10px; margin-bottom: 5px;">
                                        <img id="32" class="choose-tooth-aligners-to-cover" data-id="32"  data-image="LL-8.webp"  src="{{ in_array(8, $tla_ll) ?  asset('public/assets/tooth/coloured/LL-8.webp') :  asset('public/assets/tooth/png/LL-8.webp') }}" style="vertical-align: baseline;height: 55px;width: 55px; margin-top: 10px; margin-bottom: 5px;">
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                    <input type="hidden" id="aligners_to_cover" value="">

                    {{-- <div class="row justify-content-center">
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
                </div>
            </div>
        </div>
    </div>

    <!-- B/L Side Selection Modal -->
    <div class="modal fade" id="sideSelectionModal" tabindex="-1" role="dialog" aria-labelledby="sideSelectionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sideSelectionModalLabel">Select Tooth Side</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-center mb-4">Please select which side of the tooth to place the cutout:</p>
                    <div class="d-flex gap-3 justify-content-center">
                        <!-- B (Outer) Button -->
                        <button type="button" class="btn btn-outline-primary btn-lg" id="btn-select-outer" style="width: 200px; padding: 30px;">
                            <div style="font-size: 24px; margin-bottom: 10px;">B</div>
                            <strong>Buccal</strong>
                        </button>

                        <!-- L (Inner) Button -->
                        <button type="button" class="btn btn-outline-success btn-lg" id="btn-select-inner" style="width: 200px; padding: 30px;">
                            <div style="font-size: 24px; margin-bottom: 10px;">L</div>
                            <strong>Lingual</strong>
                        </button>
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
