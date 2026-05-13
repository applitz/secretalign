
<!-- Confirmation Modal -->
<div class="modal fade" id="optional-3shape-section-Modal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">3Shape communicate Scan data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p class="card-title-desc">Search with case id or by patient. Click on case to download stl files.</p>

            @csrf
            <input type="hidden" name="additional_patient_id" value="{{ $patient->patient_id }}">
            <input type="hidden" name="additional_case_id" value="{{ $patient->id }}">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="row align-items-center g-3">
                        <div class="col-12">
                        <h6 class="text-700 mb-0">Case ID: </h6>
                        </div>
                        <div class="col-12 position-relative">
                        <input type="text" class="form-control" id="additional_three_shape_case_id" name="additional_three_shape_case_id">
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="row align-items-center g-3">
                        <div class="col-12">
                        <h6 class="text-700 mb-0">Search for case: </h6>
                        </div>
                        <div class="col-12 position-relative">
                        <input type="text" class="form-control" id="additional_three_shape_search_for_case" name="additional_three_shape_search_for_case">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                <div class="btn-group">
                    <button class="btn btn-primary waves-effect waves-light" type="button" id="additional-3shape-search">Search</button>
                    <button type="button" class="btn btn-warning waves-effect waves-light" id="optional-cancel-3shape-select">
                        Cancel
                    </button>
                    {{-- <a class="btn btn-warning waves-effect waves-light" href="javascript:void(0);" id="optional-cancel-3shape-select">Cancel</a> --}}
                </div>
                    @if(Auth::user()->three_shape_access_token != null)
                        <a class="btn btn-danger float-end" href="{{url('/integrations/3shape-disable')}}">
                            <div class="d-flex align-items-center justify-content-center ">
                            <span>Logout From</span>
                            <img class="ms- 1" src="{{asset('public/assets/communicate-logo-white.png')}}" width="75px">
                            </div>
                        </a>
                    @endif
                </div>
            </div>


        <div class="table-rep-plugin">
            <div class="table-responsive mb-0">
                <table id="3shape-search-result-additional" class="table table-striped">

                </table>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>


<!-- Toggle Button -->
<div class="mb-3">
    <button type="button" class="btn btn-outline-primary" id="toggleAdditionalScans">
        <i class="fas fa-plus"></i> Add Additional Scans
    </button>
</div>



<div id="additional-scans-optional" class="d-none">
    <div class="mb-3">
        Add additional Scans (Optional)
    </div>

    <div class="row mb-3">
        {{-- Posterior Bite Turbos --}}
        <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="18">
            <input class="d-none" name="file18" id="key18" file="{{ @$patient->optional_fl_upper_arch }}" data-field="18" type="file">
            <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" id="posterior-bite-turbos-box" key="18" style="background-image: url('{{asset('public/assets/vector/upper-jaw.webp')}}')">
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
            <label class="form-label mb-3" for="optional_fl_upper_arch">Upper Arch</label>
            <div class="mb-3" style="width: 60%;">
                <div class="progress animated-progress">
                    <div class="progress-bar bg-primary" id="optional-upper-arch-progress-bar" role="progressbar" style="width: 0%;" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>
            </div>
            <div class="mb-3 " id="optional-stl-upper-arch-preview">

            </div>
        </div>

        {{-- Anterior Bite Turbos --}}
        <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="19">
            <input class="d-none" name="file19" id="key19" file="{{ @$patient->optional_fl_lower_arch }}" data-field="19" type="file">
            <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" id="anterior-bite-turbos-box" key="19" style="background-image: url('{{asset('public/assets/vector/down-jaw.webp')}}')">
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
            <label class="form-label mb-3" for="optional_fl_lower_arch">Lower Arch</label>
            <div class="mb-3" style="width: 60%;">
                <div class="progress animated-progress">
                    <div class="progress-bar bg-primary" id="optional-lower-arch-progress-bar" role="progressbar" style="width: 0%;" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>
            </div>
            <div class="mb-3 " id="optional-stl-lower-arch-preview">

            </div>
        </div>
    </div>

    <div class="mb-3 ">

        @if(Auth::user()->three_shape_access_token != null)
            <button type="button" class="btn btn-primary order-from-button" id="optional-select-from-3shape">
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


        <a class="btn btn-primary order-from-button"
                @if(Auth::user()->medit_link_access_token != null)
                        href="javascript:void(0);" id="select-from-medit-link"
                @else
                    href="{{url('/integration-medit-link/obtain-authorization-code')}}"
                @endif
        >
            <div class="d-flex align-items-center justify-content-center">
                <span style="padding-left: 10px">Import From </span>
                <img class="ms-2" style="    padding-top: 8px; padding-right: 5px; padding-bottom: 7px;" src="{{asset('public/assets/medit-link-logo.svg')}}" width="52px">
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
            <a class="btn btn-primary order-from-button"   href="javascript:void(0);" data-mode="{{ $mode }}"  data-hash-code="{{ $hashCode ? trim($hashCode, '"') : '' }}"  id="select-from-shining3d-link-additional" data-shining3d-user-id="{{ Auth::user()->shining3d_user_id }}" data-shining3d-access-token="{{ Auth::user()->shining3d_access_token }}" >
                <div class="d-flex align-items-center justify-content-center">
                    <span>Import From</span>&nbsp;&nbsp;<span style="color:#004fec; font-weight: bold;">SHINING 3D</span>
                </div>
            </a>
        @endif


    </div>
</div>
