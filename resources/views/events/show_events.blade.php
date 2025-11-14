@extends('layouts.app_base_horizontal')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Upcoming Events</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Events</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>




    <div class="row">
        @foreach($events as $event)
        <div class="col-md-4 col-sm-6 col-12">
            <div
            @if($event->external_link)
            style="cursor:pointer;"
            onclick="window.location.href='{{$event->external_link}}'"
            @endif
            class="card border border-2 border-primary shadow">
                <div class="card-body p-3" >
                    <h3 class="mt-0 mb-1 fw-bolder text-primary" style="text-transform: uppercase">{{$event->event_name}}</h3>
                    <h4 class=" fw-bolder mb-1 mt-0">{{date("M d", strtotime($event->date))}}</h4>
                    <div style="max-height: 95px;overflow: hidden">
                        <p class="card-title-desc mb-1 fs-9">{{$event->description}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{$events->links('pagination::bootstrap-5')}}
</div>
@stop
