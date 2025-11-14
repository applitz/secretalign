@extends('layouts.app_base_horizontal')


@section('css')
<link rel="stylesheet" href="{{asset('public/assets/cropperjs/cropper.css')}}">
@stop

@section('content')
    <div class="row gx-0 kanban-header rounded-2 px-card py-2 mt-2 mb-3">
        <div class="col d-flex align-items-center">
            <h5 class="mb-0">Edit Image</h5>
            <div class="vertical-line vertical-line-400 position-relative h-100 mx-3"></div>
        </div>
        <div class="col-auto d-flex align-items-center">

            <button type="button" class="btn btn-sm btn-falcon-default me-2 d-none d-md-block" data-toggle="cropper" data-method="setDragMode" data-option="move" title="Set drag mode to move">
                <i class="fa fa-arrows-alt"></i>
            </button>
            <button type="button" class="btn btn-sm btn-falcon-default me-2 d-none d-md-block" data-toggle="cropper" data-method="setDragMode" data-option="crop" title="Set drag mode to crop">
                <i class="fa fa-crop"></i>
            </button>

            <button type="button" class="btn btn-sm btn-falcon-default me-2 d-none d-md-block" data-toggle="cropper" data-method="zoom" data-option="0.1" title="Zoom In">
                <i class="fa fa-search-plus"></i>
            </button>
            <button type="button" class="btn btn-sm btn-falcon-default me-2 d-none d-md-block" data-toggle="cropper" data-method="zoom" data-option="-0.1" title="Zoom Out">
                <i class="fa fa-search-minus"></i>
            </button>
            <button type="button" class="btn btn-sm btn-falcon-default me-2 d-none d-md-block" data-toggle="cropper" data-method="rotate" data-option="-45" title="Rotate Left">
                <i class="fa fa-undo-alt"></i>
            </button>
            <button type="button" class="btn btn-sm btn-falcon-default me-2 d-none d-md-block" data-toggle="cropper" data-method="rotate" data-option="45" title="Rotate Right">
                <i class="fa fa-redo-alt"></i>
            </button>


            <button type="button" class="btn btn-sm btn-falcon-default me-2 d-none d-md-block" data-toggle="cropper" data-method="scaleX" data-option="-1" title="Flip Horizontal">
                <i class="fa fa-arrows-alt-h"></i>
            </button>
            <button type="button" class="btn btn-sm btn-falcon-default me-2 d-none d-md-block" data-toggle="cropper" data-method="scaleY" data-option="-1" title="Flip Vertical">
                <i class="fa fa-arrows-alt-v"></i>
            </button>



            <button type="button" class="btn btn-sm btn-falcon-default me-2 d-none d-md-block" data-toggle="cropper" data-method="setAspectRatio" data-option="1.7777777777777777" title="Set Aspect Ratio">
                16:9
            </button>
            <button type="button" class="btn btn-sm btn-falcon-default me-2 d-none d-md-block" data-toggle="cropper" data-method="setAspectRatio" data-option="1.3333333333333333" title="Set Aspect Ratio">
                4:3
            </button>
            <button type="button" class="btn btn-sm btn-falcon-default me-2 d-none d-md-block" data-toggle="cropper" data-method="setAspectRatio" data-option="1" title="Set Aspect Ratio">
                1:1
            </button>
            <button type="button" class="btn btn-sm btn-falcon-default me-2 d-none d-md-block" data-toggle="cropper" data-method="setAspectRatio" data-option="0.6666666666666666" title="Set Aspect Ratio">
                2:3
            </button>

            <button type="button" class="btn btn-sm btn-falcon-default me-2 d-none d-md-block" data-toggle="cropper" data-method="setAspectRatio" data-option="NaN" title="Set Aspect Ratio">
                Free
            </button>

            <button type="button" class="btn btn-sm btn-falcon-default me-2 d-none d-md-block" data-toggle="cropper" data-method="clear" title="Clear">
                <i class="fa fa-times"></i>
            </button>
            <button type="button" class="btn btn-sm btn-falcon-default me-2 d-none d-md-block" data-toggle="cropper" data-method="crop" title="Crop">
                <i class="fa fa-check"></i>
            </button>

            <button type="button" class="btn btn-sm btn-falcon-default me-2 d-none d-md-block" id="save-changes" title="Clear">
                Save Changes
            </button>

            <a href="{{ url()->previous() }}" class="btn btn-sm btn-falcon-default me-2 d-none d-md-block"><span
                    class="fas fa-level-down-alt me-2"></span>Back</a>

        </div>
    </div>

    <div class="card mb-3">

        <div class="card-body bg-light">


<div class="row">


    <div class="col-md-12">
        <div class="row items-push">
            <div class="col-xl-8">
                <div>
                    @if($type == 'history')
                    <img id="js-img-cropper" class="img-fluid" src="{{asset('/storage/PatientFiles/Patient' . $treatment_plan->patient_id . '/Documentation/' . $file)}}?v={{rand(0,1000)}}" alt="photo">
                    @else
                    <img id="js-img-cropper" class="img-fluid" src="{{asset('/storage/PatientFiles/Patient' . $treatment_plan->patient_id . '/' . $file)}}?v={{rand(0,1000)}}" alt="photo">
                    @endif
                </div>
            </div>
            <div class="col-xl-4">
                <div class="overflow-hidden mb-2">
                    <div class="js-img-cropper-preview overflow-hidden" style="height: 200px;"></div>
                </div>
                <div class="overflow-hidden mb-2">
                    <div class="js-img-cropper-preview overflow-hidden" style="height: 180px;"></div>
                </div>
                <div class="overflow-hidden mb-2">
                    <div class="js-img-cropper-preview overflow-hidden" style="height: 150px;"></div>
                </div>
                <div class="overflow-hidden mb-2">
                    <div class="js-img-cropper-preview overflow-hidden" style="height: 100px;"></div>
                </div>
            </div>
        </div>
    </div>


</div>


        </div>
    </div>
@stop


@section('javascript')
@include('layouts.page_scripts')
<script src="{{asset('public/assets/cropperjs/cropper.min.js')}}"></script>
<script>
class ImageCropper {
    static initImageCropper() {
        const cropperElement = document.getElementById("js-img-cropper");
        Cropper.setDefaults({ aspectRatio: 4 / 3, preview: ".js-img-cropper-preview" });
        const cropper = new Cropper(cropperElement, { crop: function (e) {} });
        $('[data-toggle="cropper"]').on("click", function (e) {
            const target = jQuery(e.currentTarget);
            const method = target.data("method") || false;
            const option = target.data("option") || false;
            const actions = {
                zoom: function () {
                    cropper.zoom(option);
                },
                setDragMode: function () {
                    cropper.setDragMode(option);
                },
                rotate: function () {
                    cropper.rotate(option);
                },
                scaleX: function () {
                    cropper.scaleX(option);
                    target.data("option", -option);
                },
                scaleY: function () {
                    cropper.scaleY(option);
                    target.data("option", -option);
                },
                setAspectRatio: function () {
                    cropper.setAspectRatio(option);
                },
                crop: function () {
                    cropper.crop();
                },
                clear: function () {
                    cropper.clear();
                },
            };
            if (actions[method]) {
                actions[method]();
            }
        });

$("#save-changes").on('click', function () {
    cropper.getCroppedCanvas();

cropper.getCroppedCanvas({
  width: 160,
  height: 90,
});

cropper.getCroppedCanvas({
  minWidth: 256,
  minHeight: 256,
  maxWidth: 4096,
  maxHeight: 4096,
});

cropper.getCroppedCanvas({
  fillColor: '#fff',
  imageSmoothingEnabled: false,
  imageSmoothingQuality: 'high',
});

// Upload cropped image to server if the browser supports `HTMLCanvasElement.toBlob`.
// The default value for the second parameter of `toBlob` is 'image/png', change it if necessary.
cropper.getCroppedCanvas().toBlob((blob) => {
  const formData = new FormData();
formData.append("_token", "{{ csrf_token() }}");
formData.append("file_name", "{{ $file }}");
// Pass the image file name as the third parameter if necessary.
  formData.append('croppedImage', blob/*, 'example.png' */);
formData.append('type', "{{$type}}");
  // Use `jQuery.ajax` method for example
  $.ajax({
    type: 'POST',
    url: '{{url("/patient/images/update/".$treatment_plan->id)}}',
    data: formData,
    processData: false,
    contentType: false,
    success(response) {
      if(response == 1) {
        toastSuccess("Photo saved!");
      } else {
        toastError("Enable to save photo!");
      }
    },
    error(error) {
      console.log(error);
      toastError("Enable to save photo!");
    },
  });
}, 'image/{{$ext}}');
});





    }

    static init() {
        this.initImageCropper();
    }
}

$(function () {
    ImageCropper.init();
});


</script>
@stop
