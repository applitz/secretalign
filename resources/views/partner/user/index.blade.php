@extends('layouts.app_base_horizontal')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Manage Patients</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('/home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Manage Patients</li>
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
                                    <h6 class="text-700 mb-0">Search: </h6>
                                </div>
                                <div class="col-12 position-relative">
                                    <input class="form-control form-control-sm" id="ft_search" style="border: 1px solid #aaa;" name="ft_search" placeholder="Search"
                                        value="{{ @$_GET['search'] }}" />
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
                            <table id="users-list" class="table table-striped w-100">

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
<script src="{{ asset('public/assets/customjs/partner/users.js') }}"></script>
<script>
    $(document).ready(function() {
        Users.init();
    });
</script>
@endsection
