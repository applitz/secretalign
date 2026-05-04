{{-- Images / Xray Start --}}
<div class="tab-pane fade" id="pill-tab-div3" role="tabpanel">
    <div class="row mb-3">

    {{-- Front Start --}}
    <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="3">
        <input class="d-none" name="file3" id="key3" file="{{ @$patient->fl_front }}" data-field="3" type="file">
        <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" key="3" style="background-image: url('{{asset('public/assets/vector/head-sad.webp')}}')">
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
            <div class=" d-flex flex-column _dropzone_edit _dropzone_remove_hidden justify-content-center" style=" top: 149px; z-index: 1000000; position: absolute; width: 225px; left: 0px; text-align: center;">
                <span class="text-white fw-semibold" data-text="">Edit File</span>
                <img src="{{asset('public/assets')}}/edit.webp" style="width: 50px;height: 50px;margin: 0 auto;">
            </div>
        </div>
        <label class="form-label mb-3" for="filepond">Front</label>
    </div>
    {{-- Front End --}}

    {{-- Smile Start --}}
    <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="4">
        <input class="d-none" name="file4" id="key4" file="{{ @$patient->fl_smile }}" data-field="4" type="file">
        <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" key="4" style="background-image: url('{{asset('public/assets/vector/head-front.webp')}}')">
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
                <div class=" d-flex flex-column _dropzone_edit _dropzone_remove_hidden justify-content-center" style="top: 149px; z-index: 1000000; position: absolute; width: 225px; left: 0px; text-align: center;">
                <span class="text-white fw-semibold" data-text="">Edit File</span>
                <img src="{{asset('public/assets')}}/edit.webp" style="width: 50px;height: 50px;margin: 0 auto;">
            </div>
        </div>
        <label class="form-label mb-3" for="filepond">Smile</label>
    </div>
    {{-- Smile End --}}

    {{-- Profile Start --}}
    <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="5">
        <input class="d-none" name="file5" id="key5" file="{{ @$patient->fl_profile }}" data-field="5" type="file">
        <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" key="5" style="background-image: url('{{asset('public/assets/vector/head-side.webp')}}') ">
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
            <div class=" d-flex flex-column _dropzone_edit _dropzone_remove_hidden justify-content-center" style="top: 149px; z-index: 1000000; position: absolute; width: 225px; left: 0px; text-align: center;">
                <span class="text-white fw-semibold" data-text="">Edit File</span>
                <img src="{{asset('public/assets')}}/edit.webp" style="width: 50px;height: 50px;margin: 0 auto;">
            </div>
        </div>
        <label class="form-label mb-1" for="filepond">Profile</label>
    </div>
    {{-- Profile End --}}

    {{-- Frontal (Intraoral) Start  --}}
    <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="6">

        <input class="d-none" name="file6" id="key6" file="{{ @$patient->fl_frontal }}" data-field="6"
        type="file">
        <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" key="6" style="background-image: url('{{asset('public/assets/vector/jaw.webp')}}') ">
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
            <div class=" d-flex flex-column _dropzone_edit _dropzone_remove_hidden justify-content-center" style="top: 149px; z-index: 1000000; position: absolute; width: 225px; left: 0px; text-align: center;">
                <span class="text-white fw-semibold" data-text="">Edit File</span>
                <img src="{{asset('public/assets')}}/edit.webp" style="width: 50px;height: 50px;margin: 0 auto;">
            </div>
        </div>
        <label class="form-label mb-3" for="filepond">Frontal (Intraoral)</label>
    </div>
    {{-- Frontal (Intraoral) End --}}

    {{-- Right Buccal Start--}}
    <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="7">
        <input class="d-none" name="file7" id="key7" file="{{ @$patient->fl_right_buccal }}" data-field="7" type="file">
        <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" key="7" style="background-image: url('{{asset('public/assets/vector/jaw-side-left-angle.webp')}}')">
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
            <div class=" d-flex flex-column _dropzone_edit _dropzone_remove_hidden justify-content-center" style="top: 149px; z-index: 1000000; position: absolute; width: 225px; left: 0px; text-align: center;">
                <span class="text-white fw-semibold" data-text="">Edit File</span>
                <img src="{{asset('public/assets')}}/edit.webp" style="width: 50px;height: 50px;margin: 0 auto;">
            </div>
        </div>
        <label class="form-label mb-3" for="filepond">Right Buccal</label>
    </div>
    {{-- Right Buccal End--}}

    {{-- Left Buccal Start --}}
    <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="8">
        <input class="d-none" name="file8" id="key8" file="{{ @$patient->fl_left_buccal }}" data-field="8" type="file">
        <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" key="8" style="background-image: url('{{asset('public/assets/vector/jaw-side-right-angle.webp')}}') ">
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
            <div class=" d-flex flex-column _dropzone_edit _dropzone_remove_hidden justify-content-center" style="top: 149px; z-index: 1000000; position: absolute; width: 225px; left: 0px; text-align: center;">
                <span class="text-white fw-semibold" data-text="">Edit File</span>
                <img src="{{asset('public/assets')}}/edit.webp" style="width: 50px;height: 50px;margin: 0 auto;">
            </div>
        </div>
        <label class="form-label mb-3" for="filepond">Left Buccal</label>
    </div>
    {{-- Left Buccal End --}}

    {{-- Upper Occlusal Start --}}
    <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="9">

        <input class="d-none" name="file9" id="key9" file="{{ @$patient->fl_upper_occlusal }}" data-field="9" type="file">
        <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" key="9" style="background-image: url('{{asset('public/assets/vector/upper-jaw.webp')}}')">
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
            <div class=" d-flex flex-column _dropzone_edit _dropzone_remove_hidden justify-content-center" style="top: 149px; z-index: 1000000; position: absolute; width: 225px; left: 0px; text-align: center;">
                <span class="text-white fw-semibold" data-text="">Edit File</span>
                <img src="{{asset('public/assets')}}/edit.webp" style="width: 50px;height: 50px;margin: 0 auto;">
            </div>
        </div>
        <label class="form-label mb-3" for="filepond">Upper Occlusal</label>
    </div>
    {{-- Upper Occlusal End --}}

    {{-- Lower Occlusal Start --}}
    <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="10">
        <input class="d-none" name="file10" id="key10" file="{{ @$patient->fl_lower_occlusal }}" data-field="10" type="file">
        <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" key="10" style="background-image: url('{{asset('public/assets/vector/down-jaw.webp')}}')">
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
            <div class=" d-flex flex-column _dropzone_edit _dropzone_remove_hidden justify-content-center" style="top: 149px; z-index: 1000000; position: absolute; width: 225px; left: 0px; text-align: center;">
                <span class="text-white fw-semibold" data-text="">Edit File</span>
                <img src="{{asset('public/assets')}}/edit.webp" style="width: 50px;height: 50px;margin: 0 auto;">
            </div>
        </div>
        <label class="form-label mb-3" for="filepond">Lower Occlusal</label>
    </div>
        {{-- Lower Occlusal End --}}

    {{-- Panorex Start --}}
    <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="11">
        <input class="d-none" name="file11" id="key11" file="{{ @$patient->fl_panorex }}" data-field="11" type="file">
            <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" key="11" style="background-image: url('{{asset('public/assets/vector/x-ray-jaw-front.webp')}}')">
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
                <div class=" d-flex flex-column _dropzone_edit _dropzone_remove_hidden justify-content-center" style="top: 149px; z-index: 1000000; position: absolute; width: 225px; left: 0px; text-align: center;">
                    <span class="text-white fw-semibold" data-text="">Edit File</span>
                    <img src="{{asset('public/assets')}}/edit.webp" style="width: 50px;height: 50px;margin: 0 auto;">
                </div>
            </div>
            <label class="form-label mb-3" for="filepond">Panorex</label>
    </div>
    {{-- Panorex End --}}

    {{-- Lateral Ceph Start --}}
    <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="12">
        <input class="d-none" name="file12" id="key12" file="{{ @$patient->fl_lateral_ceph }}" data-field="12" type="file">
        <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" key="12" style="background-image: url('{{asset('public/assets/vector/x-ray-jaw-side.webp')}}')">
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
            <div class=" d-flex flex-column _dropzone_edit _dropzone_remove_hidden justify-content-center" style="top: 149px; z-index: 1000000; position: absolute; width: 225px; left: 0px; text-align: center;">
                <span class="text-white fw-semibold" data-text="">Edit File</span>
                <img src="{{asset('public/assets')}}/edit.webp" style="width: 50px;height: 50px;margin: 0 auto;">
            </div>
        </div>
        <label class="form-label mb-3" for="filepond">Lateral Ceph</label>
    </div>
    {{-- Lateral Ceph End --}}

    {{-- General Upload Start --}}
    <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="13">
        <input class="d-none" name="file13" id="key13" file="{{ @$patient->fl_general_upload }}" data-field="13" type="file">
        <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" key="13" style="background-image: url('{{asset('public/assets/no-image.webp')}}')">
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
            <div class=" d-flex flex-column _dropzone_edit _dropzone_remove_hidden justify-content-center" style="top: 149px; z-index: 1000000; position: absolute; width: 225px; left: 0px; text-align: center;">
                <span class="text-white fw-semibold" data-text="">Edit File</span>
                <img src="{{asset('public/assets')}}/edit.webp" style="width: 50px;height: 50px;margin: 0 auto;">
            </div>
        </div>
        <label class="form-label mb-3" for="filepond">General Upload</label>
    </div>
    {{-- General Upload End --}}

    {{-- General Upload Drive Start --}}
    <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        <label class="form-label" for="general_upload_hyperlink">General Upload (Drive
            Link)</label>
        <input class="form-control hyperlink" placeholder="https://"
            value="{{ @$patient->fl_general_upload_drive_link }}"
            name="general_upload_hyperlink" id="general_upload_hyperlink">
    </div>
    {{-- General Upload Drive end --}}
    </div>

    <div class="mb-3 text-end">
        <button class="btn btn-primary btn-sm waves-effect waves-light px-3 previous-tab" data-target="#pill-tab-li2">Previous</button>
        <button class="btn btn-primary btn-sm waves-effect waves-light px-3" id="submit-images" @if ( @$patient->fl_front &&
            @$patient->fl_smile &&
            @$patient->fl_profile &&
            @$patient->fl_frontal &&
            @$patient->fl_right_buccal &&
            @$patient->fl_left_buccal &&
            @$patient->fl_upper_occlusal &&
            @$patient->fl_lower_occlusal &&
            @$patient->fl_panorex &&
            @$patient->fl_lateral_ceph) fn="1"
            @else
            fn="0" @endif>Next</button>
    </div>
</div>
{{-- Images / Xray End --}}
