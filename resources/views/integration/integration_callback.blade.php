@extends('layouts.app_base_horizontal')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18" >Manage Integrations</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Medit Link</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body" style="min-height: 70vh">
                    <div class="text-center py-3 border border-2 mb-3">
                        <img src="{{asset('public/assets/medit-link-logo.svg')}}" style="width: 200px">
                    </div>
                    <h1 class=" text-center fw-bolder  {{@Session::get('success') ? 'text-primary' : 'text-danger'}}">{{@Session::get('success') ? 'SUCCESS' : 'ERROR'}}</h1>
                    <p class="fs-3 text-center">{{ @Session::get('success') ? @Session::get('success') : @Session::get('error')}}</p>

                    <div class="text-center">
                        <button class="btn  btn-primary" onclick="window.location.href='{{url('/patient/create')}}'">Continue to Create Patient</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

@endsection


@section('javascript')

  <script src="{{ asset('public') }}/qovex/assets/libs/moment/min/moment.min.js"></script>
  <script src="{{ asset('public') }}/qovex/assets/libs/jquery-ui-dist/jquery-ui.min.js"></script>
  <script src="{{ asset('public') }}/qovex/assets/libs/fullcalendar/index.global.min.js"></script>

@stop
