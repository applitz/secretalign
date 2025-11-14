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
                <h4 class="page-title mb-0 font-size-18">Manage Upcoming Events</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Events</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="mt-2" method="GET" action="{{url()->current()}}">
                        <div class="row">

                            <div class="col-md-3 mb-3">
                                <div class="row align-items-center g-3">
                                    <div class="col-12">
                                        <h6 class="text-700 mb-0">Search: </h6>
                                    </div>
                                    <div class="col-12 position-relative">
                                        <input class="form-control form-control-sm" id="search" name="search" placeholder="Search"
                                            value="{{@$_GET['search']}}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="btn-group">
                                    <button class="btn btn-primary waves-effect waves-light btn-sm submit-filter-form" type="submit"><i
                                            class="fas fa-search me-2"></i> Filter</button>
                                    <a class="btn btn-warning waves-effect waves-light btn-sm" href="{{ url()->current() }}"><i
                                            class="fas fa-trash-alt me-2"></i> Clean Filters</a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="tech-companies-1" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Event Name</th>
                                        <th scope="col">External Link</th>
                                        <th scope="col">Description</th>
                                        <th class="text-end" scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($events))
                                    @foreach ($events as $blog)
                                    <tr class="align-middle">
                                        <td class="text-nowrap">
                                            {{date("d/m/Y", strtotime($blog->date))}}
                                        </td>
                                        <td class="text-nowrap">
                                            {{$blog->event_name}}
                                        </td>
                                        <td class="text-nowrap">
                                            @if($blog->external_link)
                                            <a href="{{$blog->external_link}}" target="_blank">{{$blog->external_link}}</a>
                                            @endif
                                        </td>
                                        <td class="text-nowrap">
                                            {{$blog->description}}
                                        </td>
                                        <td class="text-end">
                                            <div>
                                                <a class="btn p-0" href="{{url('/events/edit/'.$blog->id)}}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="" data-bs-original-title="Edit"
                                                    aria-label="Edit"><i
                                                    class="fas fa-edit"></i></a>
                                                    <a class="btn p-0 ms-2 delete" data-id="{{$blog->id}}" data-name="{{$blog->event_name}}"
                                                        href="javascript:;" data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                        data-bs-original-title="Delete" aria-label="Delete"><i
                                                        class="fas fa-trash-alt"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <td class="text-center"
                                        colspan="5">
                                        No Data To Show
                                    </td>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                {{ $events->links('pagination::bootstrap-5') }}
                            </div>
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
<script>
    $(document).ready(function () {
        $(document).on('click', '.delete', function () {
            var id = $(this).attr('data-id');
            var name = $(this).attr('data-name');
            var c = confirm("Are you really want to delete "+name);
            if(c){
                $.ajax({
    type: "POST",
    url: "{{url('/events/delete')}}",
    data: {
        "_token" : "{{ csrf_token() }}",
        "eventId" : id
    }
}).done(function (response) {
 window.location.reload();
});
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
