{{-- scan Data Start --}}

<div class="tab-pane fade {{ $baseUrl !== null && $code !== null ? 'show active' : '' }} " id="pill-tab-div2" role="tabpanel">
    <div class="alert alert-warning border-2 d-flex align-items-center" role="alert">
        <div class="bg-warning me-3 icon-item"><span
                class="fas fa-exclamation-circle text-white fs-3"></span></div>
        <p class="mb-0 flex-1">
            @if ($patient->phase <= 1)
                You must upload the scan data!
            @elseif ($patient->phase > 1)

                @if (in_array($patient->dm_order_status, [
                    'OrderStatusChangedToWaitingForNewFilesStageFileIncorrect',
                    'OrderStatusChangedToWaitingForNewFilesStageFileUnusable',
                    'OrderStatusChangedToWaitingForNewFilesStageFileCorrupted'
                ]))
                    @switch($patient->dm_order_status)
                        @case('OrderStatusChangedToWaitingForNewFilesStageFileIncorrect')
                            The stage file you uploaded is incorrect. Please re-upload the correct stage file.
                            @break

                        @case('OrderStatusChangedToWaitingForNewFilesStageFileUnusable')
                            The stage file you uploaded is unusable. Please re-upload a valid stage STL file.
                            @break

                        @case('OrderStatusChangedToWaitingForNewFilesStageFileCorrupted')
                            The stage file you uploaded is corrupted. Please re-upload the stage file.
                            @break
                    @endswitch

                @elseif (in_array($patient->dm_order_status, [
                    'OrderStatusChangedToWaitingForNewFilesIOSIncorrect',
                    'OrderStatusChangedToWaitingForNewFilesIOSCorrupted',
                    'OrderStatusChangedToWaitingForNewFilesIOSUnusable',
                    'OrderStatusChangedToOrderRejectedAnatomicalChanges',
                    'OrderStatusChangedToOrderRejectedAdditionalTeeth'
                ]))
                    {{-- IOS or Rejection Issues --}}
                    @switch($patient->dm_order_status)
                        @case('OrderStatusChangedToWaitingForNewFilesIOSIncorrect')
                            The IOS file you uploaded is incorrect. Please re-upload the correct IOS file.
                            @break

                        @case('OrderStatusChangedToWaitingForNewFilesIOSUnusable')
                            The IOS file you uploaded is unusable. Please re-upload a valid IOS STL file.
                            @break

                        @case('OrderStatusChangedToWaitingForNewFilesIOSCorrupted')
                            The IOS file you uploaded is corrupted. Please re-upload the IOS file.
                            @break

                        @case('OrderStatusChangedToOrderRejectedAnatomicalChanges')
                            Your order was rejected due to anatomical changes. Please re-upload updated IOS and stage files.
                            @break

                        @case('OrderStatusChangedToOrderRejectedAdditionalTeeth')
                            Your order was rejected due to additional teeth detected. Please re-upload updated IOS and stage files.
                            @break
                    @endswitch

                @elseif (in_array($patient->dm_order_status, [
                            'OrderStatusChangedToWaitingForNewFilesAlignerNumberIncorrect'
                        ]))
                            {{-- Aligner Number Issues --}}
                        The stage file you uploaded has an incorrect aligner number. Please re-upload the correct stage file.
                @elseif ($patient->dm_order_status == 'OrderStatusChangedToOrderCompleted')
                        <strong>🎉 Congratulations!</strong> Your order has been successfully completed.
                        Your treatment plan is now ready and you can proceed with the next steps.
                @else
                    {{-- Default Message --}}
                    Your order is under processing in Dental Monitoring.
                    If you want to update scan data manually, you need to cancel the order first.
                @endif
            @endif
        </p>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="row mb-3">

        <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="1">
            <input class="d-none" name="file1" id="key1" file="{{ @$patient->fl_upper_arch }}" data-field="1" type="file">
            <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" id="upper-jaw-box" key="1" style="background-image: url('{{asset('public/assets/vector/upper-jaw.webp')}}')">
                <div class="_dropzone_added _dropzone_added_hidden d-flex flex-column align-items-center justify-content-center">
                    <span class="text-white fw-semibold" data-text></span>
                    <img src="{{asset('public/assets')}}/check-mark.webp" style="width: 50px;height: 50px;">
                </div>
                <div class="_dropzone_hover _dropzone_hover_hidden d-flex flex-column align-items-center justify-content-center">
                    <span class="text-white fw-semibold" data-text>Drag & drop file</span>
                    <img src="{{asset('public/assets')}}/download-circular-button.webp" style="width: 50px;height: 50px;">
                </div>
                <div class="_dropzone_loading _dropzone_loading_hidden d-flex flex-column align-items-center justify-content-center">
                    <span class="text-white fw-semibold" data-text>Uploading...</span>
                    <img src="{{asset('public/assets')}}/circle-loading.webp" class="_dropzone_loading_animation" style="width: 50px;height: 50px;">
                </div>
                <div class="_dropzone_remove _dropzone_remove_hidden d-flex flex-column align-items-center justify-content-center">
                    <span class="text-white fw-semibold" data-text>Delete file</span>
                    <img src="{{asset('public/assets')}}/x-mark.webp" style="width: 50px; height: 50px;">
                </div>

            </div>
            <label class="form-label mb-3" for="fl_upper_arch">Upper Arch</label>
            <div class="mb-3" style="width: 60%;">
                <div class="progress animated-progress">
                    <div class="progress-bar bg-primary" id="upper-arch-progress-bar" role="progressbar" style="width: 0%;" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>
            </div>
            <div class="mb-3" id="stl-upper-arch-preview">

            </div>
        </div>


        <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="2">
            <input class="d-none" name="file2" id="key2" file="{{ @$patient->fl_lower_arch }}" data-field="2" type="file">
            <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" id="lower-jaw-box" key="2" style="background-image: url('{{asset('public/assets/vector/down-jaw.webp')}}')">
                <div class="_dropzone_added _dropzone_added_hidden d-flex flex-column align-items-center justify-content-center">
                    <span class="text-white fw-semibold" data-text></span>
                    <img src="{{asset('public/assets')}}/check-mark.webp" style="width: 50px;height: 50px;">
                </div>
                <div class="_dropzone_hover _dropzone_hover_hidden d-flex flex-column align-items-center justify-content-center">
                    <span class="text-white fw-semibold" data-text>Drag & drop file</span>
                    <img src="{{asset('public/assets')}}/download-circular-button.webp" style="width: 50px;height: 50px;">
                </div>
                <div class="_dropzone_loading _dropzone_loading_hidden d-flex flex-column align-items-center justify-content-center">
                    <span class="text-white fw-semibold" data-text>Uploading...</span>
                    <img src="{{asset('public/assets')}}/circle-loading.webp" class="_dropzone_loading_animation" style="width: 50px;height: 50px;">
                </div>
                <div class="_dropzone_remove _dropzone_remove_hidden d-flex flex-column align-items-center justify-content-center">
                    <span class="text-white fw-semibold" data-text>Delete file</span>
                    <img src="{{asset('public/assets')}}/x-mark.webp" style="width: 50px; height: 50px;">
                </div>

            </div>
            <label class="form-label mb-3" for="fl_lower_arch">Lower Arch</label>
            <div class="mb-3" style="width: 60%;">
                <div class="progress animated-progress">
                    <div class="progress-bar bg-primary" id="lower-arch-progress-bar" role="progressbar" style="width: 0%;" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>
            </div>
                <div class="mb-3 " id="stl-lower-arch-preview">

                </div>
        </div>
    </div>


    <div class="mb-3 ">

        @if(Auth::user()->three_shape_access_token != null)
            <button type="button" class="btn btn-primary order-from-button" id="select-from-3shape">
        @else
            <a class="btn btn-primary order-from-button" href="{{ url('/integration-3shape/obtain-authorization-code') }}">
        @endif

            <div class="d-flex align-items-center justify-content-center">
                <span>Import From</span>
                <img src="{{ asset('public/assets/communicate-logo-white.png') }}"
                    width="92px"
                    style="padding-left: 10px">
            </div>

        @if(Auth::user()->three_shape_access_token != null)
            </button>
        @else
            </a>
        @endif

        {{-- <a
        class="btn btn-primary order-from-button"
        @if(Auth::user()->three_shape_access_token != null)
        href="javascript:void(0);"
        id="select-from-3shape"
        @else
        href="{{url('/integration-3shape/obtain-authorization-code')}}"
        @endif
        >
            <div class="d-flex align-items-center justify-content-center">
            <span>Import From</span>
            <img class="" src="{{asset('public/assets/communicate-logo-white.png')}}" width="92px">
            </div>
        </a> --}}


        <a class="btn btn-primary order-from-button"
                @if(Auth::user()->medit_link_access_token != null)
                        href="javascript:void(0);" id="select-from-medit-link"
                @else
                    href="{{url('/integration-medit-link/obtain-authorization-code')}}"
                @endif
        >
            <div class="d-flex align-items-center justify-content-center">
            <span style="padding-left: 10px">Import From </span>
            <img class="ms-2" style="    padding-top: 8px; padding-right: 5px;
            padding-bottom: 7px;" src="{{asset('public/assets/medit-link-logo.svg')}}" width="52px">
            </div>
        </a>


        @if(Auth::user()->shining3d_org_name == null )
            <a class="btn btn-primary order-from-button" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#shining3d-org-name-modal" >
                <div class="d-flex align-items-center justify-content-center">
                    <span>Import From</span>&nbsp;&nbsp;<span style="color:#004fec; font-weight: bold;">SHINING 3D </span>
                </div>
            </a>
        @else
            @php

            @endphp
            <a class="btn btn-primary order-from-button"   href="javascript:void(0);" data-mode="{{ $mode }}"  data-hash-code="{{ $hashCode ? trim($hashCode, '"') : '' }}"  id="select-from-shining3d-link" data-shining3d-user-id="{{ Auth::user()->shining3d_user_id }}" data-shining3d-access-token="{{ Auth::user()->shining3d_access_token }}" >
                <div class="d-flex align-items-center justify-content-center">
                    <span>Import From</span>&nbsp;&nbsp;<span style="color:#004fec; font-weight: bold;">SHINING 3D</span>
                </div>
            </a>
        @endif


    </div>

    @if($patient->phase > 1)
        @if ($patient->dm_order_details == null || $patient->dm_order_details == '')
            <div class="mb-3 order-from">
                <button  class="btn btn-primary order-from-dental-monitoring-btn" data-bs-toggle="modal" data-bs-target="#order-from-dental-monitoring-modal" data-patient-treatment-plans-id="{{ $patient->id }}" data-patient-id="{{ $patient->patient_id }}">
                    <div class="d-flex align-items-center justify-content-center">
                        <span>Order From</span>
                        <img class="ms-2" style="padding-top: 8px; padding-bottom: 7px;" src="{{asset('public/assets/dm-logo.png')}}" width="100px">
                    </div>
                </button>
            </div>
        @else
            <div class="mb-3 order-from" >
                @php
                $reuploadStatuses = [
                    'OrderStatusChangedToWaitingForNewFilesStageFileIncorrect',
                    'OrderStatusChangedToWaitingForNewFilesStageFileUnusable',
                    'OrderStatusChangedToWaitingForNewFilesStageFileCorrupted',
                    'OrderStatusChangedToWaitingForNewFilesIOSUnusable',
                    'OrderStatusChangedToWaitingForNewFilesIOSIncorrect',
                    'OrderStatusChangedToWaitingForNewFilesIOSCorrupted',
                    'OrderStatusChangedToOrderRejectedAnatomicalChanges',
                    'OrderStatusChangedToOrderRejectedAdditionalTeeth',
                ];
            @endphp

            @if (in_array($patient->dm_order_status, $reuploadStatuses))
                <button class="btn btn-warning reupload-files-from-dental-monitoring-btn" data-bs-toggle="modal" data-bs-target="#reupload-from-dental-monitoring-modal"
                    data-patient-treatment-plans-id="{{ $patient->id }}" data-patient-id="{{ $patient->patient_id }}">
                    <div class="d-flex align-items-center justify-content-center">
                        <span>Update Order From</span>
                        <img class="ms-2" style="padding-top: 8px; padding-bottom: 7px;"
                            src="{{ asset('public/assets/dm-logo.png') }}" width="100px" alt="DM Logo">
                    </div>
                </button>
            @endif
            @if ($patient->dm_order_status != 'OrderStatusChangedToOrderCompleted')
                <button  class="btn btn-danger cancel-order-from-dental-monitoring-btn" data-bs-toggle="modal" data-bs-target="#cancel-order-from-dental-monitoring-modal" data-patient-treatment-plans-id="{{ $patient->id }}" data-patient-id="{{ $patient->patient_id }}">
                    <div class="d-flex align-items-center justify-content-center">
                        <span>Cancel Order </span>
                        <img class="ms-2" style="padding-top: 8px; padding-bottom: 7px;" src="{{asset('public/assets/dm-logo.png')}}" width="100px">
                    </div>
                </button>
            @endif
            </div>

        @endif
    @endif
    @if((Auth::user()->email == 'parthkhunt12@gmail.com'))
        @include('patients.create-patients.additional-scan')
    @endif
    <div class="mb-3 text-end">
        <button class="btn btn-primary btn-sm waves-effect waves-light px-3 previous-tab" data-target="#pill-tab-li-treatment-type">Previous</button>
        <button class="btn btn-primary btn-sm waves-effect waves-light px-3" id="submit-scan-data" @if (@$patient->fl_upper_arch
            && @$patient->fl_lower_arch) fn="1"
            @else
            fn="0" @endif>Next</button>
    </div>
</div>
{{-- scan Data End --}}
