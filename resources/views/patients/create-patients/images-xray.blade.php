{{-- Images / Xray Start --}}
<div class="tab-pane fade {{ (isset($activeTab) && $activeTab == 'pill-tab-div3') ? 'show active' : '' }}" id="pill-tab-div3" role="tabpanel">

    <style>
        /* Image-slot preview + hover action menu (Images/X-Rays step only) */
        #pill-tab-div3 ._dropzone.autoseg-img { background-size: cover; background-position: center; background-color: #11161b; }
        #pill-tab-div3 ._dropzone.autoseg-img ._dropzone_added,
        #pill-tab-div3 ._dropzone.autoseg-img ._dropzone_hover,
        #pill-tab-div3 ._dropzone.autoseg-img ._dropzone_remove,
        #pill-tab-div3 ._dropzone.autoseg-img ._dropzone_edit { display: none !important; }
        #pill-tab-div3 ._dropzone .autoseg-actions {
            position: absolute; inset: 0; background: rgba(17, 22, 27, .84);
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            gap: 8px; opacity: 0; pointer-events: none; transition: opacity .12s; z-index: 6; padding: 12px; text-align: center;
        }
        #pill-tab-div3 ._dropzone.autoseg-img:hover .autoseg-actions { opacity: 1; pointer-events: auto; }
        #pill-tab-div3 .autoseg-actions label { color: #cfe3ee; font-size: 11px; margin: 0; }
        #pill-tab-div3 .autoseg-actions .autoseg-type { width: 90%; font-size: 12px; padding: 4px 6px; border-radius: 4px; border: 0; }
        #pill-tab-div3 .autoseg-actions .autoseg-btns { display: flex; flex-wrap: wrap; justify-content: center; gap: 6px; margin-top: 2px; }
        #pill-tab-div3 .autoseg-actions .autoseg-btns button { border: 0; border-radius: 4px; padding: 5px 10px; font-size: 12px; cursor: pointer; color: #fff; }
        #pill-tab-div3 .autoseg-actions .autoseg-edit { background: #2f6f8f; }
        #pill-tab-div3 .autoseg-actions .autoseg-unassign { background: #b7791f; }
        #pill-tab-div3 .autoseg-actions .autoseg-del { background: #c0392b; }
        #pill-tab-div3 #autoseg-review-list .autoseg-suggest { outline: 2px solid #16a34a; }
        /* Delete (×) button on review (unassigned) cards */
        #pill-tab-div3 #autoseg-review-list .autoseg-review-card { position: relative; }
        #pill-tab-div3 #autoseg-review-list .autoseg-review-del {
            position: absolute; top: 6px; right: 6px; width: 22px; height: 22px; border-radius: 50%;
            border: 0; background: rgba(192,57,43,.92); color: #fff; font-size: 15px; line-height: 1;
            padding: 0; cursor: pointer; opacity: 0; transition: opacity .12s; z-index: 7;
            box-shadow: 0 1px 3px rgba(0,0,0,.4); display: flex; align-items: center; justify-content: center;
        }
        #pill-tab-div3 #autoseg-review-list .autoseg-review-card:hover .autoseg-review-del { opacity: 1; }
        /* Drag-over highlight when dropping a review image onto a slot */
        #pill-tab-div3 ._dropzone.autoseg-dragover { outline: 3px dashed #16a34a; outline-offset: -3px; }
    </style>

    {{-- Auto-segregation bulk uploader --}}
    <div class="card border border-primary mb-3" id="autoseg-card"
         data-classify-url="{{ url('/patient/'.(@$patient->patient_id ?: '0').'/images/classify') }}"
         data-img-base="{{ asset('storage/PatientFiles/Patient'.(@$patient->patient_id ?: '0')) }}/">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>
                    <h6 class="mb-1 fw-semibold"><i class="mdi mdi-auto-fix"></i> Auto-upload &amp; sort images</h6>
                    <p class="text-muted mb-0" style="font-size:12px;">
                        Drop a patient's photos &amp; X-rays (or a whole folder). They're sorted into the
                        right slots automatically. Duplicates are skipped. Max <strong>15</strong> images.
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-primary btn-sm px-3" id="autoseg-pick-files">Select images</button>
                    <button type="button" class="btn btn-outline-primary btn-sm px-3" id="autoseg-pick-folder">Select folder</button>
                    <input type="file" id="autoseg-input-files" accept="image/*" multiple class="d-none">
                    <input type="file" id="autoseg-input-folder" webkitdirectory directory multiple class="d-none">
                </div>
            </div>

            <div id="autoseg-dropzone" class="mt-3 py-4 px-3 text-center text-muted"
                 style="border:2px dashed #b9c7d6;border-radius:8px;cursor:pointer;transition:.15s;">
                <i class="mdi mdi-cloud-upload-outline" style="font-size:26px;"></i>
                <div style="font-size:13px;">Drag &amp; drop images or a folder here, or use the buttons above</div>
            </div>

            <div id="autoseg-status" class="mt-2" style="font-size:13px;"></div>
            <div id="autoseg-skipped" class="mt-2 text-muted" style="font-size:12px;"></div>

            {{-- Needs-review: images the AI couldn't place confidently / slot collisions --}}
            <div id="autoseg-review" class="mt-3 d-none">
                <h6 class="fw-semibold mb-2" style="font-size:13px;">
                    Needs your review <span class="text-muted" style="font-weight:400;">— pick the correct slot, then Place</span>
                </h6>
                <div id="autoseg-review-list" class="row g-2"></div>
            </div>
        </div>
    </div>

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

{{-- Auto-segregation uploader logic --}}
<script>
(function () {
    const card = document.getElementById('autoseg-card');
    if (!card) return;

    const CLASSIFY_URL = card.dataset.classifyUrl;
    const MAX = 15;
    const SLOT_TO_KEY = {
        'Front': 3, 'Smile': 4, 'Profile': 5, 'Frontal (Intraoral)': 6,
        'Right Buccal': 7, 'Left Buccal': 8, 'Upper Occlusal': 9, 'Lower Occlusal': 10,
        'Panorex': 11, 'Lateral Ceph': 12, 'General Upload': 13
    };
    const SLOTS = Object.keys(SLOT_TO_KEY);
    const IMG_RE = /\.(jpe?g|png|webp|gif|bmp)$/i; // heic can't be canvas-decoded in Chrome

    const statusEl = document.getElementById('autoseg-status');
    const skippedEl = document.getElementById('autoseg-skipped');
    const reviewWrap = document.getElementById('autoseg-review');
    const reviewList = document.getElementById('autoseg-review-list');
    const dz = document.getElementById('autoseg-dropzone');
    let draggedReview = null; // the review card currently being dragged onto a slot (task 5)

    function csrf() {
        const m = document.querySelector('meta[name="csrf-token"]');
        if (m && m.content) return m.content;
        const i = document.querySelector('input[name="_token"]');
        return i ? i.value : '';
    }
    function setStatus(html, cls) {
        statusEl.innerHTML = html ? '<span class="' + (cls || '') + '">' + html + '</span>' : '';
    }
    function renderSkipped(skipped, dupes) {
        const parts = [];
        if (dupes && dupes.length) parts.push('Skipped ' + dupes.length + ' duplicate' + (dupes.length > 1 ? 's' : ''));
        if (skipped && skipped.length) parts.push('Skipped ' + skipped.length + ' non-image file' + (skipped.length > 1 ? 's' : ''));
        skippedEl.textContent = parts.join('  ·  ');
    }

    // Recurse into dropped folders using the webkit entries API.
    async function filesFromDrop(dt) {
        if (!dt.items || !dt.items.length || !dt.items[0].webkitGetAsEntry) {
            return Array.from(dt.files || []);
        }
        const roots = Array.from(dt.items).map(it => it.webkitGetAsEntry && it.webkitGetAsEntry()).filter(Boolean);
        const out = [];
        async function walk(entry) {
            if (entry.isFile) {
                await new Promise(res => entry.file(f => { out.push(f); res(); }, () => res()));
            } else if (entry.isDirectory) {
                const reader = entry.createReader();
                await new Promise(res => {
                    const read = () => reader.readEntries(async es => {
                        if (!es.length) { res(); return; }
                        for (const e of es) await walk(e);
                        read();
                    }, () => res());
                    read();
                });
            }
        }
        for (const r of roots) await walk(r);
        return out;
    }

    async function sha256(file) {
        const buf = await file.arrayBuffer();
        const h = await crypto.subtle.digest('SHA-256', buf);
        return Array.from(new Uint8Array(h)).map(b => b.toString(16).padStart(2, '0')).join('');
    }

    // Resize to <=768px longest edge, JPEG q80, honoring EXIF orientation.
    async function resizeToDataUri(file, max) {
        max = max || 768;
        let bmp;
        try {
            bmp = await createImageBitmap(file, { imageOrientation: 'from-image' });
        } catch (e) {
            bmp = await new Promise((res, rej) => {
                const im = new Image();
                im.onload = () => res(im);
                im.onerror = rej;
                im.src = URL.createObjectURL(file);
            });
        }
        const w = bmp.width, h = bmp.height;
        const scale = Math.min(1, max / Math.max(w, h));
        const nw = Math.max(1, Math.round(w * scale));
        const nh = Math.max(1, Math.round(h * scale));
        const c = document.createElement('canvas');
        c.width = nw; c.height = nh;
        c.getContext('2d').drawImage(bmp, 0, 0, nw, nh);
        if (bmp.close) bmp.close();
        return c.toDataURL('image/jpeg', 0.8);
    }

    function slotFilled(key) {
        const el = document.getElementById('key' + key);
        const f = el ? (el.getAttribute('file') || '') : '';
        return f && f !== 'null' && f.trim() !== '';
    }

    async function handleFiles(fileList) {
        reviewWrap.classList.add('d-none');
        reviewList.innerHTML = '';
        const all = Array.from(fileList || []);
        if (!all.length) return;

        const imageFiles = [], skipped = [];
        for (const f of all) {
            if ((f.type && f.type.indexOf('image/') === 0) || IMG_RE.test(f.name)) imageFiles.push(f);
            else skipped.push(f.name);
        }

        // Duplicate detection by content hash.
        setStatus('<span class="spinner-border spinner-border-sm"></span> Reading ' + imageFiles.length + ' file(s)…');
        const seen = new Set(), uniq = [], dupes = [];
        for (const f of imageFiles) {
            let h;
            try { h = await sha256(f); } catch (e) { h = f.name + ':' + f.size; }
            if (seen.has(h)) dupes.push(f.name);
            else { seen.add(h); uniq.push(f); }
        }
        renderSkipped(skipped, dupes);

        if (uniq.length === 0) { setStatus('No images found to classify.', 'text-warning'); return; }
        if (uniq.length > MAX) {
            setStatus('Too many images: ' + uniq.length + ' (max ' + MAX + '). Please select ' + MAX + ' or fewer.', 'text-danger fw-semibold');
            return;
        }

        setStatus('<span class="spinner-border spinner-border-sm"></span> Preparing ' + uniq.length + ' image(s)…');
        const payload = [], files = [];
        for (let i = 0; i < uniq.length; i++) {
            let uri = null;
            try { uri = await resizeToDataUri(uniq[i]); } catch (e) { uri = null; }
            if (!uri) { skipped.push(uniq[i].name); renderSkipped(skipped, dupes); continue; }
            files[i] = uniq[i];
            payload.push({ index: i, data_uri: uri });
        }
        if (!payload.length) { setStatus('Could not read any of the selected images.', 'text-danger'); return; }

        setStatus('<span class="spinner-border spinner-border-sm"></span> Classifying ' + payload.length + ' image(s)…');
        let data;
        try {
            const res = await fetch(CLASSIFY_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf() },
                body: JSON.stringify({ images: payload })
            });
            data = await res.json();
            if (!res.ok || data.status !== 'success') {
                setStatus((data && data.message) || ('Classification failed (' + res.status + ').'), 'text-danger fw-semibold');
                return;
            }
        } catch (e) {
            setStatus('Classification request failed: ' + e.message, 'text-danger fw-semibold');
            return;
        }
        await placeResults(data.results || [], (typeof data.min_confidence === 'number' ? data.min_confidence : 0.6), files);
    }

    const IMG_BASE = card.dataset.imgBase || '';
    // The 10 "standard" photo slots (Front..Lateral Ceph); General Upload (13) is extra.
    const STANDARD_KEYS = [3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
    const ALL_IMAGE_KEYS = STANDARD_KEYS.concat([13]);

    function slotName(key) { for (const s in SLOT_TO_KEY) if (SLOT_TO_KEY[s] === key) return s; return ''; }
    function slotDom(key) { return document.querySelector('#pill-tab-div3 ._dropzone[key="' + key + '"]'); }
    function fileNameOf(key) {
        const el = document.getElementById('key' + key);
        const f = el ? (el.getAttribute('file') || '') : '';
        return (f && f !== 'null' && f.trim() !== '') ? f.trim() : '';
    }

    // Fetch the image currently in a slot as a File (for moving between slots).
    async function grabSlotFile(key) {
        const fn = fileNameOf(key);
        if (!fn) return null;
        try {
            const url = fn.indexOf('blob:') === 0 ? fn : (IMG_BASE + encodeURIComponent(fn));
            const blob = await (await fetch(url)).blob();
            return new File([blob], 'image.jpg', { type: blob.type || 'image/jpeg' });
        } catch (e) { return null; }
    }

    // Build the hover action menu (Change type / Edit / Delete) for an image slot, once.
    function ensureOverlay(key) {
        const dzEl = slotDom(key);
        if (!dzEl || dzEl.querySelector('.autoseg-actions')) return;
        const ov = document.createElement('div');
        ov.className = 'autoseg-actions';
        ov.addEventListener('click', e => e.stopPropagation()); // don't trigger the file picker
        const lbl = document.createElement('label'); lbl.textContent = 'Change type';
        const sel = document.createElement('select'); sel.className = 'autoseg-type';
        SLOTS.forEach(s => { const o = document.createElement('option'); o.value = s; o.textContent = s; sel.appendChild(o); });
        sel.value = slotName(key);
        sel.addEventListener('change', function () {
            const toSlot = sel.value;
            sel.value = slotName(key);
            changeSlotType(key, toSlot);
        });
        const btns = document.createElement('div'); btns.className = 'autoseg-btns';
        const edit = document.createElement('button'); edit.type = 'button'; edit.className = 'autoseg-edit'; edit.textContent = 'Edit';
        edit.addEventListener('click', function () { const t = dzEl.querySelector('._dropzone_edit'); if (t) t.click(); });
        // Unassign: pull the image out of this slot and send it back to the review row
        // (keeps the image; unlike Delete, which removes it for good).
        const unassign = document.createElement('button'); unassign.type = 'button'; unassign.className = 'autoseg-unassign'; unassign.textContent = 'Unassign';
        unassign.addEventListener('click', async function () {
            unassign.disabled = true;
            const slot = slotName(key);
            const file = await grabSlotFile(key);
            if (!file) { unassign.disabled = false; return; }
            if (typeof window.dropzone_destroy_state === 'function') window.dropzone_destroy_state(key);
            addReviewItem(file, slot, false);
            unassign.disabled = false;
        });
        const del = document.createElement('button'); del.type = 'button'; del.className = 'autoseg-del'; del.textContent = 'Delete';
        del.addEventListener('click', function () { if (typeof window.dropzone_destroy_state === 'function') window.dropzone_destroy_state(key); });
        btns.append(edit, unassign, del);
        ov.append(lbl, sel, btns);
        dzEl.appendChild(ov);
    }

    // Show the actual photo on a slot (or restore its placeholder when empty).
    function refreshSlot(key) {
        const dzEl = slotDom(key);
        if (!dzEl) return;
        if (dzEl.dataset.placeholderBg === undefined) dzEl.dataset.placeholderBg = dzEl.style.backgroundImage || '';
        const fn = fileNameOf(key);
        if (fn) {
            ensureOverlay(key);
            const sel = dzEl.querySelector('.autoseg-type'); if (sel) sel.value = slotName(key);
            dzEl.classList.add('autoseg-img');
            const url = fn.indexOf('blob:') === 0 ? fn : (IMG_BASE + encodeURIComponent(fn));
            dzEl.style.backgroundImage = "url('" + url + "')";
        } else {
            dzEl.classList.remove('autoseg-img');
            dzEl.style.backgroundImage = dzEl.dataset.placeholderBg || '';
        }
    }
    function refreshAllSlots() { ALL_IMAGE_KEYS.forEach(refreshSlot); }

    async function uploadToSlot(key, file) {
        await window.dropzone_upload(key, file);
        refreshSlot(key);
    }

    // Move the image in `fromKey` to `toSlot`. If the target is occupied, its current
    // image is bumped to the review row (minimal clicks); if empty, it moves directly.
    async function changeSlotType(fromKey, toSlot) {
        const toKey = SLOT_TO_KEY[toSlot];
        if (!toKey || toKey === fromKey) return;
        const movingFile = await grabSlotFile(fromKey);
        if (!movingFile) { return; }
        let occupant = null, occupantSlot = '';
        if (slotFilled(toKey)) { occupantSlot = slotName(toKey); occupant = await grabSlotFile(toKey); }
        await uploadToSlot(toKey, movingFile);                 // overwrites target's DB reference
        if (typeof window.dropzone_destroy_state === 'function') window.dropzone_destroy_state(fromKey);
        if (occupant) addReviewItem(occupant, occupantSlot, false);
        updateReviewStatus();
    }

    function addReviewItem(file, defaultSlot, suggest) {
        reviewWrap.classList.remove('d-none');
        const col = document.createElement('div');
        col.className = 'col-6 col-md-3 col-lg-2';
        const box = document.createElement('div');
        box.className = 'border rounded p-2 h-100 autoseg-review-card' + (suggest ? ' autoseg-suggest' : '');
        const objUrl = URL.createObjectURL(file);
        // Free the object URL and drop the card once it's placed or discarded.
        function removeCard() { URL.revokeObjectURL(objUrl); col.remove(); updateReviewStatus(); }
        const img = document.createElement('img');
        img.style.cssText = 'width:100%;height:80px;object-fit:cover;border-radius:4px;cursor:grab;';
        img.src = objUrl;
        // Task 5: drag this thumbnail onto any slot box to place it there.
        img.draggable = true;
        img.addEventListener('dragstart', function (e) {
            draggedReview = { file: file, remove: removeCard };
            try { e.dataTransfer.setData('text/plain', 'autoseg-review'); } catch (_) {}
            if (e.dataTransfer) e.dataTransfer.effectAllowed = 'move';
        });
        img.addEventListener('dragend', function () { draggedReview = null; });
        // Delete (×): discard this unassigned image without placing it anywhere.
        const del = document.createElement('button');
        del.type = 'button'; del.className = 'autoseg-review-del'; del.title = 'Discard this image';
        del.innerHTML = '&times;';
        del.addEventListener('click', function (e) { e.stopPropagation(); removeCard(); });
        const sel = document.createElement('select');
        sel.className = 'form-select form-select-sm mt-2';
        SLOTS.forEach(s => { const o = document.createElement('option'); o.value = s; o.textContent = s; if (s === defaultSlot) o.selected = true; sel.appendChild(o); });
        const btn = document.createElement('button');
        btn.type = 'button'; btn.className = 'btn btn-sm btn-primary w-100 mt-2'; btn.textContent = 'Place';
        btn.onclick = async function () {
            const slot = sel.value, key = SLOT_TO_KEY[slot];
            if (!key) return;
            btn.disabled = true;
            let occupant = null, occupantSlot = '';
            if (slotFilled(key)) { occupantSlot = slotName(key); occupant = await grabSlotFile(key); }
            try { await uploadToSlot(key, file); } catch (e) {}
            if (occupant) addReviewItem(occupant, occupantSlot, false);
            removeCard();
        };
        box.append(del, img, sel, btn);
        col.appendChild(box);
        reviewList.appendChild(col);
    }

    // Clear the status line once nothing is left needing review.
    function updateReviewStatus() {
        if (!reviewList.children.length) { reviewWrap.classList.add('d-none'); setStatus(''); }
        else reviewWrap.classList.remove('d-none');
    }

    async function placeResults(results, minConf, files) {
        if (typeof window.dropzone_upload !== 'function') {
            setStatus('Uploader is not ready yet — please try again in a moment.', 'text-danger');
            return;
        }
        const claimed = new Set();
        const review = [];   // {file, slot}
        const toPlace = [];
        // Highest confidence claims its slot first, so collisions send the weaker one to review.
        const ordered = results.slice().sort((a, b) => (b.confidence || 0) - (a.confidence || 0));
        for (const r of ordered) {
            const file = files[r.index];
            if (!file) continue;
            const key = SLOT_TO_KEY[r.slot];
            if (key && (r.confidence || 0) >= minConf && !slotFilled(key) && !claimed.has(key)) {
                claimed.add(key);
                toPlace.push({ key: key, file: file });
            } else {
                review.push({ file: file, slot: r.slot });
            }
        }

        // Upload one at a time (reliable everywhere; clear progress).
        for (let i = 0; i < toPlace.length; i++) {
            setStatus('<span class="spinner-border spinner-border-sm"></span> Uploading ' + (i + 1) + ' of ' + toPlace.length + '…');
            try { await uploadToSlot(toPlace[i].key, toPlace[i].file); } catch (e) {}
        }

        // Leftover inference: exactly one image left over AND exactly one standard slot
        // empty -> it almost certainly belongs there, so pre-select that slot.
        const totalImages = toPlace.length + review.length;
        let suggestKey = null;
        if (review.length === 1 && totalImages === 10) {
            const empty = STANDARD_KEYS.filter(k => !slotFilled(k));
            if (empty.length === 1) { review[0].slot = slotName(empty[0]); suggestKey = empty[0]; }
        }

        reviewList.innerHTML = '';
        review.forEach(it => addReviewItem(it.file, it.slot, suggestKey !== null && it === review[0]));
        setStatus('');
        updateReviewStatus();
    }

    // --- wire up controls ---
    document.getElementById('autoseg-pick-files').addEventListener('click', () => document.getElementById('autoseg-input-files').click());
    document.getElementById('autoseg-pick-folder').addEventListener('click', () => document.getElementById('autoseg-input-folder').click());
    document.getElementById('autoseg-input-files').addEventListener('change', function (e) { handleFiles(e.target.files); e.target.value = ''; });
    document.getElementById('autoseg-input-folder').addEventListener('change', function (e) { handleFiles(e.target.files); e.target.value = ''; });
    dz.addEventListener('click', () => document.getElementById('autoseg-input-files').click());
    ['dragenter', 'dragover'].forEach(ev => dz.addEventListener(ev, e => { e.preventDefault(); e.stopPropagation(); dz.style.borderColor = '#2f6f8f'; dz.style.background = '#eef6ff'; }));
    ['dragleave', 'drop'].forEach(ev => dz.addEventListener(ev, e => { e.preventDefault(); e.stopPropagation(); dz.style.borderColor = '#b9c7d6'; dz.style.background = ''; }));
    dz.addEventListener('drop', async function (e) {
        setStatus('<span class="spinner-border spinner-border-sm"></span> Reading dropped items…');
        const files = await filesFromDrop(e.dataTransfer);
        handleFiles(files);
    });

    // Keep each image slot's preview in sync with its file attribute — covers
    // auto-segregation, manual per-slot uploads, and files already present on load.
    function watchSlots() {
        ALL_IMAGE_KEYS.forEach(function (key) {
            const el = document.getElementById('key' + key);
            if (!el || el.__autosegWatched) return;
            el.__autosegWatched = true;
            new MutationObserver(function () { refreshSlot(key); }).observe(el, { attributes: true, attributeFilter: ['file'] });
        });
    }

    // Task 5: let a review (unassigned) thumbnail be dropped onto any slot box.
    // Only our internal review drags are intercepted (draggedReview set) so that
    // dropping real files/folders onto a slot keeps working as before.
    function setupSlotDropTargets() {
        ALL_IMAGE_KEYS.forEach(function (key) {
            const el = slotDom(key);
            if (!el || el.__autosegDrop) return;
            el.__autosegDrop = true;
            el.addEventListener('dragover', function (e) {
                if (!draggedReview) return;
                e.preventDefault();
                if (e.dataTransfer) e.dataTransfer.dropEffect = 'move';
                el.classList.add('autoseg-dragover');
            });
            el.addEventListener('dragleave', function () { el.classList.remove('autoseg-dragover'); });
            el.addEventListener('drop', async function (e) {
                if (!draggedReview) return;           // let native file-drop handling run
                e.preventDefault();
                e.stopPropagation();                  // don't fall through to the file-drop handler
                el.classList.remove('autoseg-dragover');
                const d = draggedReview; draggedReview = null;
                let occupant = null, occupantSlot = '';
                if (slotFilled(key)) { occupantSlot = slotName(key); occupant = await grabSlotFile(key); }
                try { await uploadToSlot(key, d.file); } catch (err) {}
                if (occupant) addReviewItem(occupant, occupantSlot, false);
                if (typeof d.remove === 'function') d.remove();
            });
        });
    }

    watchSlots();
    setupSlotDropTargets();
    refreshAllSlots();
    window.addEventListener('load', function () { watchSlots(); setupSlotDropTargets(); refreshAllSlots(); });
})();
</script>
{{-- Images / Xray End --}}
