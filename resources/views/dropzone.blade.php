@extends('layouts.app_base_horizontal')

@section('css')
<link rel="stylesheet" href="{{asset('public/css/cropper.css')}}">
<style>
    ._dropzone {
        width: 225px;
        min-height: 225px;
        background-position: center;
        position: relative;
        background-size: contain;
        background-repeat: no-repeat;
        cursor: pointer;
    }
    ._dropzone_added, ._dropzone_hover, ._dropzone_loading, ._dropzone_remove {
        position: absolute;
        left: 0;
        top: 0;
        background: rgba(77,77,77,0.35);
        width: 225px;
        height: 225px;
    }
    ._dropzone_added_hidden, ._dropzone_hover_hidden, ._dropzone_loading_hidden, ._dropzone_remove_hidden {
        visibility: hidden;
    }

    ._dropzone_loading_animation {
        animation: rotation 6s infinite linear;
    }

    @keyframes rotation {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
  </style>
@stop

@section('content')
<div class="mt-5 pt-5"></div>
<div class="row">
    <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="3">

        <input class="d-none" name="file3" id="key3" file="" data-field="3"
        type="file">
        <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" key="3" style="background-image: url('{{asset('public/assets/vector/head-sad.png')}}')
        ">
        <div class="_dropzone_added _dropzone_added_hidden d-flex flex-column align-items-center justify-content-center">
            <span class="text-white fw-semibold" data-text></span>
            <img src="{{asset('public/assets')}}/check-mark.png" style="width: 50px;height: 50px;">
        </div>
        <div class="_dropzone_hover _dropzone_hover_hidden d-flex flex-column align-items-center justify-content-center">
            <span class="text-white fw-semibold" data-text>Drag & drop file</span>
            <img src="{{asset('public/assets')}}/download-circular-button.png" style="width: 50px;height: 50px;">
        </div>
        <div class="_dropzone_loading _dropzone_loading_hidden d-flex flex-column align-items-center justify-content-center">
            <span class="text-white fw-semibold" data-text>Uploading...</span>
            <img src="{{asset('public/assets')}}/circle-loading.png" class="_dropzone_loading_animation" style="width: 50px;height: 50px;">
        </div>
        <div class="_dropzone_remove _dropzone_remove_hidden d-flex flex-column align-items-center justify-content-center">
            <span class="text-white fw-semibold" data-text>Delete file</span>
            <img src="{{asset('public/assets')}}/x-mark.png" style="width: 50px; height: 50px;">
        </div>
    </div>
</div>

@stop

@section('javascript')
<script src="{{asset('public/js/cropper.js')}}"></script>
<script>
$(function () {
    let
    dropzone_state = {
        "key1" : 'inactive',
        "key2" : 'inactive',
        "key3" : 'inactive',
        "key4" : 'inactive',
        "key5" : 'inactive',
        "key6" : 'inactive',
        "key7" : 'inactive',
        "key8" : 'inactive',
        "key9" : 'inactive',
        "key10" : 'inactive',
        "key11" : 'inactive',
        "key12" : 'inactive',
        "key13" : 'inactive',
    }
    let dropzone_reset_state = (key, message = "") => {
        dropzone_state["key"+key] = 'inactive'
        $(`._dropzone[key='${key}']`).find("._dropzone_hover").addClass('_dropzone_hover_hidden')
        $(`._dropzone[key='${key}']`).find("._dropzone_added").addClass('_dropzone_added_hidden')
        $(`._dropzone[key='${key}']`).find("._dropzone_loading").addClass('_dropzone_loading_hidden')
        $(`._dropzone[key='${key}']`).find("._dropzone_remove").addClass('_dropzone_remove_hidden')
        $("._dropzone_template #key"+key).val('')
        if(message != "") {
            toastError(message);
        }
    }

    let dropzone_active_state = (key, fileName, message = "") => {
        dropzone_state["key"+key] = 'active'
        $(`._dropzone[key='${key}']`).find("._dropzone_hover").addClass('_dropzone_hover_hidden')
        $(`._dropzone[key='${key}']`).find("._dropzone_added").removeClass('_dropzone_added_hidden')
        $(`._dropzone[key='${key}']`).find("._dropzone_loading").addClass('_dropzone_loading_hidden')
        $(`._dropzone[key='${key}']`).find("._dropzone_remove").addClass('_dropzone_remove_hidden')
        $(`._dropzone[key='${key}']`).find("._dropzone_added [data-text]").html(fileName)
        if(message != "") {
            toastError(message);
        }
    }

    let dropzone_uploading_state = (key, message = "") => {
        dropzone_state["key"+key] = 'uploading'
        $(`._dropzone[key='${key}']`).find("._dropzone_hover").addClass('_dropzone_hover_hidden')
        $(`._dropzone[key='${key}']`).find("._dropzone_added").addClass('_dropzone_added_hidden')
        $(`._dropzone[key='${key}']`).find("._dropzone_loading").removeClass('_dropzone_loading_hidden')
        $(`._dropzone[key='${key}']`).find("._dropzone_remove").addClass('_dropzone_remove_hidden')
        if(message != "") {
            toastError(message);
        }
    }

    let dropzone_destroy_state = (key, message = "") => {
        $.ajax({
            type: "POST",
            url: "{{url('/handle-dropzone-files/delete')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                "key" : key,
            }
        }).done(function (response) {
            if(response.status == 'success') {
                dropzone_reset_state(key)
                toastSuccess("File successfully removed")
            } else {
                toastError("Enable to remove file")
            }
        })
    }

    let dropzone_upload = (key, file) => {
        let formData = new FormData();
        formData.append('file'+key, file)
        $.ajax({
            url: '{{url('/handle-dropzone-files')}}?key='+key,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                dropzone_uploading_state(key)
            },
            success: function(response){
                if(response.status == 'success') {
                    dropzone_active_state(key, response.fileName)
                } else {
                    dropzone_reset_state(key, "Unable to upload file")
                }
            },
            error: function(xhr, status, error){
                dropzone_reset_state(key, "Unable to upload file")
            }
        })
    }

    let openImageEditor = (file, callback) => {
        var editor = document.createElement('div');
        editor.style.position = 'fixed';
        editor.style.left = 0;
        editor.style.right = 0;
        editor.style.top = 0;
        editor.style.bottom = 0;
        editor.style.zIndex = 9999;
        editor.style.backgroundColor = '#000';
        document.body.appendChild(editor);

        var buttonConfirm = document.createElement('button');
        buttonConfirm.style.position = 'absolute';
        buttonConfirm.style.left = '10px';
        buttonConfirm.style.top = '10px';
        buttonConfirm.style.zIndex = 9999;
        buttonConfirm.textContent = 'Confirm';
        editor.appendChild(buttonConfirm);

        buttonConfirm.addEventListener('click', function() {
            document.body.removeChild(editor);
            var croppedImageData = cropper.getCroppedCanvas().toDataURL(file.type);
            var blob = dataURItoBlob(croppedImageData);
            var croppedFile = new File([blob], file.name, { type: file.type });
            callback(croppedFile);
        });

        var image = new Image();
        image.src = URL.createObjectURL(file);
        editor.appendChild(image);

        var cropper = new Cropper(image, { aspectRatio: 1 });
    }

    let dataURItoBlob = (dataURI) => {
        var byteString = atob(dataURI.split(',')[1]);
        var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
        var ab = new ArrayBuffer(byteString.length);
        var ia = new Uint8Array(ab);
        for (var i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }
        var blob = new Blob([ab], { type: mimeString });
        return blob;
    }

    $(document).on('dragover', function(e) {
        e.preventDefault();
    });

    $(document).on('drop', function(e) {
        e.preventDefault();
    });

    $(document).on("mouseenter", "._dropzone", function () {
        const key = $(this).attr('key')
        if(dropzone_state["key"+key] == 'inactive') {
            $(this).find("._dropzone_hover").removeClass('_dropzone_hover_hidden')
        }
        if(dropzone_state["key"+key] == 'active') {
            $(this).find('._dropzone_added').addClass('_dropzone_added_hidden')
            $(this).find('._dropzone_remove').removeClass('_dropzone_remove_hidden')
        }
    })

    $(document).on('mouseleave', "._dropzone", function () {
        const key = $(this).attr('key')
        if(dropzone_state["key"+key] == 'inactive') {
            $(this).find("._dropzone_hover").addClass('_dropzone_hover_hidden')
        }
        if(dropzone_state["key"+key] == 'active') {
            $(this).find('._dropzone_added').removeClass('_dropzone_added_hidden')
            $(this).find('._dropzone_remove').addClass('_dropzone_remove_hidden')
        }
    })

    $(document).on('drop', '._dropzone_template', function (e) {
        e.preventDefault();
        const key = $(this).attr('template-key')
        if(dropzone_state["key"+key] == 'inactive') {
            var file = e.originalEvent.dataTransfer.files[0];
            if (file) {
                var fileSize = file.size / 1024 / 1024; // in MB
                var fileType = file.type.split('/').shift(); // get file type

                if (fileType !== 'image') {
                    dropzone_reset_state(key, "Please drop an image file.")
                    return false;
                }

                if (fileSize > 20) {
                    dropzone_reset_state(key, "Image size must be less than 20MB.")
                    return false;
                }
                openImageEditor(file, function(croppedFile) {
                    dropzone_upload(key, croppedFile)
                });
            }
        }
    })

    $(document).on('click', '._dropzone', function (e) {
        const key = $(this).attr('key')
        if(dropzone_state["key"+key] == 'inactive') {
            $("._dropzone_template #key"+key).trigger('click')
        }
        if(dropzone_state["key"+key] == 'active') {
            dropzone_destroy_state(key)
        }
    })

    $(document).on('change', '._dropzone_template input[data-field]', function () {
        const key = $(this).attr('data-field')
        var file = this.files[0];
        if (file) {
            var fileSize = file.size / 1024 / 1024; // in MB
            var fileType = file.type.split('/').shift(); // get file type

            if (fileType !== 'image') {
                dropzone_reset_state(key, "Please upload an image file")
                return false;
            }

            if (fileSize > 20) {
                dropzone_reset_state(key, "Image size must be less then 20mb.")
                return false;
            }

           dropzone_upload(key, file)
        }
    })
})
</script>

@stop
