@extends('layouts.app_base_horizontal')

@section('content')

<div class="page-content">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Manage Lab Requests</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Lab Requests</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="mt-2" method="GET" action="{{url('/reports/lab-requests')}}">
                        <div class="row">
                          <div class="col-md-3 mb-3">
                            <div class="row align-items-center g-3">
                              <div class="col-12">
                                <h6 class="text-700 mb-0">Date: </h6>
                              </div>
                              <div class="col-12 position-relative">
                                <input class="form-control form-control-sm pickr ps-4" name="date" id="CRMDateRange"
                                  value="{{@$_GET['date']}}" placeholder="Y-m-d to Y-m-d" type="text"
                                  data-options="{&quot;mode&quot;:&quot;range&quot;,&quot;dateFormat&quot;:&quot;M d&quot;,&quot;disableMobile&quot;:true , &quot;defaultDate&quot;: [&quot;Aug 15&quot;, &quot;Aug 22&quot;] }" /><span
                                  class="fas fa-calendar-alt text-primary position-absolute top-50 translate-middle-y ms-2"> </span>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3 mb-3">
                            <div class="row align-items-center g-3">
                              <div class="col-12">
                                <h6 class="text-700 mb-0">Lab: </h6>
                              </div>
                              <div class="col-12 position-relative">
                                <select class="form-select form-select-sm mySelect2" id="organizerSingle" size="1" name="lab"
                                  data-options='{"removeItemButton":true,"placeholder":true}'>
                                  <option value="">Select lab...</option>
                                  @foreach ($labs as $lab)
                                  <option value="{{$lab->id}}" @if ($lab->id == @$_GET['lab'])
                                    selected
                                    @endif>{{$lab->first_name . ' ' . $lab->last_name}}</option>
                                  @endforeach
                                </select>
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
                                      <th scope="col">Lab Technician</th>
                                      <th scope="col">Status</th>
                                      <th scope="col">Patient</th>
                                      <th scope="col">Doctor</th>
                                      <th scope="col">Treatment Plan</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @if(count($requests))
                                    @foreach ($requests as $request)
                                    <tr class="align-middle">
                                      <td class="text-nowrap">{{$request->l_first_name . ' ' . $request->l_last_name}}</td>
                                      <td class="text-nowrap">
                                        @if ($request->is_canceled == 1)
                                        <span class="badge rounded-pill badge-soft-danger">Canceled</span>
                                        @else
                                        @if ($request->is_treatment_submitted == 1)
                                        <span class="badge rounded-pill badge-soft-success">Completed</span>
                                        @else
                                        <span class="badge rounded-pill badge-soft-primary">Pending</span>
                                        @endif
                                        @endif
                                      </td>
                                      <td class="text-nowrap">{{$request->p_first_name . ' ' . $request->p_last_name}}</td>
                                      <td class="text-nowrap">{{$request->d_first_name . ' ' . $request->d_last_name}}</td>
                                      <td class="text-nowrap">
                                        <span class="badge rounded-pill badge-soft-primary">Phase {{$request->phase}}</span>
                                      </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <td class="text-center" colspan="5">
                                      No Data To Show
                                    </td>
                                    @endif
                                  </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                {{ $requests->links('pagination::bootstrap-5') }}
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

<script>
  const fp = flatpickr($(".pickr"), {
        "mode":"range"
    });

</script>
@stop
