@extends('layouts.app_base_horizontal')

@section('content')
<div class="page-content">

    @include('layouts.breadcrumb')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18" >Shining3d Region Details</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('/home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Shining3d Region Details</li>
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
                        <div class="col-md-3 mb-3">
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



                        <div class="col-md-3 mb-3">
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

</div>
@endsection

@section('javascript')
    <script src="{{ asset('public/assets/plugins/dataTables/1.11.5/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/dataTables/1.11.5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/dataTables/responsive/2.2.9/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('public/assets/customjs/shining3d_region_details.js') }}"></script>
    <script>
        $(document).ready(function() {
            Shining3d_region_details.init();
        });
    </script>
@endsection
