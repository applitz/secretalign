@extends('layouts.app_base_horizontal')

@section('content')
<div class="page-content">

    @include('layouts.breadcrumb')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18" >Dashboard</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Welcome to Secret Clear Aligner System.</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="filter-form">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <div class="row align-items-center g-3">
                                <div class="col-12">
                                    <h6 class="text-700 mb-0">Date: </h6>
                                </div>
                                <div class="col-12 position-relative">
                                    <input class="form-control form-control-sm pickr ps-4" name="date" id="CRMDateRange"
                                        value="{{ @$_GET['date'] }}" placeholder="Y-m-d to Y-m-d" type="text"
                                        data-options="{&quot;mode&quot;:&quot;range&quot;,&quot;dateFormat&quot;:&quot;M d&quot;,&quot;disableMobile&quot;:true , &quot;defaultDate&quot;: [&quot;Aug 15&quot;, &quot;Aug 22&quot;] }" style="border: 1px solid #aaa;"/><span
                                        class="fas fa-calendar-alt text-primary position-absolute top-50 translate-middle-y ms-2" >
                                    </span>
                                </div>
                                </div>
                            </div>

                            <div class="col-md-2 mb-3">
                                <div class="row align-items-center g-3">
                                    <div class="col-12">
                                        <h6 class="text-700 mb-0">Doctor: </h6>
                                    </div>
                                    <div class="col-12 position-relative">
                                        <select class="form-select form-select-sm mySelect2" id="statuDoctor" data-options='{"removeItemButton":true,"placeholder":true}'
                                            name="ft_doctor" style="border: 1px solid #aaa;">
                                            <option value="">Any</option>
                                            @foreach($doctors as $doctor)
                                                <option value="{{ $doctor->id }}" {{ request('ft_doctor') == $doctor->id ? 'selected' : '' }}>
                                                {{ ucfirst($doctor->user_full_name) }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-2 mb-3">
                                <div class="row align-items-center g-3">
                                <div class="col-12">
                                    <h6 class="text-700 mb-0">Task: </h6>
                                </div>
                                <div class="col-12 position-relative">
                                    <select class="form-select form-select-sm mySelect2" id="statuChooser"
                                        name="ft_status" data-options='{"removeItemButton":true,"placeholder":true}' style="border: 1px solid #aaa;">
                                        <option value="">Any</option>
                                        @foreach($tasks as $task)
                                            <option value="{{ $task }}" {{ request('ft_status') == $task ? 'selected' : '' }}>{{ ucfirst($task) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                </div>
                            </div>

                            <div class="col-md-2 mb-3">
                                <div class="row align-items-center g-3">
                                <div class="col-12">
                                    <h6 class="text-700 mb-0">Search: </h6>
                                </div>
                                <div class="col-12 position-relative">
                                    <input class="form-control form-control-sm" id="ft_search" name="ft_search" placeholder="Search"
                                        value="{{ @$_GET['search'] }}" style="border: 1px solid #aaa;"/>
                                </div>
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <div class="row align-items-center g-3">
                                    <div class="col-12">
                                        <h6 class="text-700 mb-0">&nbsp;</h6>
                                    </div>
                                    <div class="col-12 position-relative">
                                        <div class="btn-group">
                                            <button class="btn btn-primary waves-effect waves-light btn-sm submit-filter-form" type="submit"><i
                                                class="fas fa-search me-2"></i> Filter</button>
                                            <a class="btn btn-warning waves-effect waves-light btn-sm" id="clear-filters" href="javascript:;"><i
                                                class="fas fa-trash-alt me-2"></i> Clean Filters</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="tasks-list" class="table table-striped" >

                            </table>
                        </div>
                    </div>
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
</div>
@endsection

@section('javascript')
    <script src="{{ asset('public/assets/plugins/dataTables/1.11.5/js/jquery.dataTables.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('public/assets/plugins/dataTables/1.11.5/js/dataTables.bootstrap5.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('public/assets/plugins/dataTables/responsive/2.2.9/js/dataTables.responsive.min.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('public/assets/customjs/home-staff.js') }}?v={{ time() }}"></script>
    <script>
        $(document).ready(function() {
            Home.init();
        });
    </script>
@endsection
