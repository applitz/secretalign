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
                <h4 class="page-title mb-0 font-size-18">Tutorials</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Tutorials</li>
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


                    <div class="row">
                        @foreach($blogs as $blog)
                        @php
                        $file_type = null;
                        if($blog->media != null) {
                            $file_type = getFileType(asset('storage/app/public/BlogMedia/'.$blog->media));
                        }
                        @endphp
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card">
                                <div style="width: 100%;height: 200px;" class="mb-3">
                                    @if($file_type == 'image')
                                    <img src="{{asset('storage/app/public/BlogMedia/'.$blog->media)}}" class=" w-100 h-100 object-fit-cover" style="cursor:pointer" onclick="window.location.href='{{url('/tutorial/'.$blog->id)}}'">
                                    @elseif($file_type == 'video')
                                  
                                    <img src="{{asset('public/play-demo.png')}}" class="w-100 h1-00 object-fit-cover" style="cursor:pointer" onclick="window.location.href='{{url('/tutorial/'.$blog->id)}}'">
                                   <!-- <video class="player w-100 h-100" playsinline controls>
                                        <source src="{{asset('storage/app/public/BlogMedia/'.$blog->media)}}" type="video/{{explode(".", $blog->media)[1]}}" />

                                      </video> -->
                                    @endif</div>
                                <div class="card-body">
                                    <h4 class="card-title mt-0">{{$blog->blog_name}}</h4>
                                    <p class="card-text">{{substr($blog->description, 0, 100)}}...</p>
                                    <a href="{{url('/tutorial/'.$blog->id)}}">See More</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>



                    {{-- <div class="timeline-count p-4">
                        <!-- Timeline row Start -->
                        <div class="row">

                           @foreach($blogs as $blog)
                           @php
                           $file_type = null;
                           if($blog->media != null) {
                               $file_type = getFileType(asset('storage/app/public/BlogMedia/'.$blog->media));
                           }
                           @endphp





 <!-- Timeline 1 -->
 <div class="timeline-box col-lg-4">
    <div class="timeline-spacing">
        <div class="item-lable bg-primary rounded">
            <p class="text-center text-white">{{date("M, d", strtotime($blog->created_at))}}</p>
        </div>
        <div class="timeline-line active">
            <div class="dot bg-primary"></div>
        </div>
        <div class="vertical-line">
            <div class="wrapper-line bg-light"></div>
        </div>
        <div class="bg-light p-4 rounded mx-3">
            <div style="width: 100%;height: 200px" class="mb-2">
                @if($file_type == 'image')
                <img src="{{asset('storage/app/public/BlogMedia/'.$blog->media)}}" class=" w-100 h-100 object-fit-cover">
                @elseif($file_type == 'video')
                <video class="player w-100 h-100" playsinline controls>
                    <source src="{{asset('storage/app/public/BlogMedia/'.$blog->media)}}" type="video/{{explode(".", $blog->media)[1]}}" />

                  </video>
                @endif</div>
            <h5>{{$blog->blog_name}}</h5>
            <p class="text-muted mt-1 mb-0">{{substr($blog->description, 0, 100)}}</p>
            <a href="{{url('/tutorial/'.$blog->id)}}">See More</a>
        </div>
    </div>
</div>
<!-- Timeline 1 -->










                           @endforeach


                        </div>
                        <!-- Timeline row Over -->

                        <div class="row">
                            <div class="col-12">
                                {{ $blogs->links('pagination::bootstrap-5') }}
                            </div>
                        </div>


                </div> --}}
            </div>
        </div>
    </div>

</div>

@stop

@section('javascript')
@include('layouts.page_scripts')
<script>
    $(document).ready(function () {
        $(document).on('click', '.delete', function () {
            var id = $(this).attr('data-id');
            var name = $(this).attr('data-name');
            var c = confirm("Are you really want to delete "+name);
            if(c){
                var url = "{{url('')}}/tutorial/delete/"+id;
            window.location.href  = url;
            }
        })
    })
</script>
<script src="{{asset('public')}}/dashboard/vendors/plyr/plyr.polyfilled.min.js"></script>
<script>
$(".player").each(function () {
    new Plyr($(this));
});
</script>
@stop
