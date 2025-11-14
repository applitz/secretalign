@extends('layouts.app_base_horizontal')

@section('css')
<link href="{{asset('public')}}/dashboard/vendors/plyr/plyr.css" rel="stylesheet" />
<style>
    .plyr__control--overlaid {
        background: #1C8484 !important;
    }
    .plyr--full-ui input[type=range] {
        color: #1C8484 !important;
    }
    .plyr--video .plyr__control.plyr__tab-focus, .plyr--video .plyr__control:hover, .plyr--video .plyr__control[aria-expanded=true] {
        background: #1C8484 !important;
    }
</style>
@stop

@section('content')
<div class="page-content">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Manage Tutorials</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="https://secretalign-user.com/tutorials/view">Tutorials</a>
                        </li>
                        <li class="breadcrumb-item active">{{ $blog->blog_name }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    @php
    function getFileType($file_path) {
        $allowed_image_types = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
        $allowed_video_types = ['mp4', 'avi', 'mkv', 'mov', 'wmv'];

        $file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

        if (in_array($file_extension, $allowed_image_types)) {
            return 'image';
        } elseif (in_array($file_extension, $allowed_video_types)) {
            return 'video';
        } else {
            return 'unknown';
        }
    }
    @endphp


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                     @php
                                    $file_type = null;
                                    if($blog->media != null) {
                                        $file_type = getFileType(asset('storage/app/public/BlogMedia/'.$blog->media));
                                    }
                                    @endphp
                    @if($file_type == 'image')
                    <img src="{{asset('storage/app/public/BlogMedia/'.$blog->media)}}" class="w-100 h-100 object-fit-cover">
                    @elseif($file_type == 'video')
                    <video class="player" playsinline controls>
                        <source src="{{asset('storage/app/public/BlogMedia/'.$blog->media)}}" type="video/{{explode(".", $blog->media)[1]}}" />
                    </video>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

@stop

@section('javascript')
@include('layouts.page_scripts')
<script src="{{asset('public')}}/dashboard/vendors/plyr/plyr.polyfilled.min.js"></script>
<script>
$(".player").each(function () {
    new Plyr($(this));
});
</script>
@stop
