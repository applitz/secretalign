@extends('layouts.app_base_horizontal')

@section('content')

<div class="page-content">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Manage Integrations</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">3Shape Communicate</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-nowrap table-centered mb-0">
                            <tbody>
                                <tr>
                                    <td style="width: 60px;">
                                        <div class="form-check form-switch ">
                                            <input class="form-check-input" {{ Auth::user()->three_shape_access_token != null ? 'checked' : '' }} style="height: 1.1em;" name="toggle_three_shape" value="1" id="flexSwitchCheckChecked"
                                                type="checkbox"  />
                                            <label class="form-check-label" for="flexSwitchCheckChecked">

                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <h5 class="text-truncate font-size-14 m-0"><a href="#"
                                                class="text-reset">3Shape Communicate API</a></h5>
                                    </td>
                                    <td>
                                        <img src="{{asset('public/assets/communicate-logo.png')}}" width="100">
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            @if(Auth::user()->three_shape_access_token != null)
                                            <span
                                                class="badge rounded-pill bg-success-subtle text-success  font-size-11">Connected</span>
                                                @else
                                                <span
                                                class="badge rounded-pill bg-secondary-subtle text-secondary  font-size-11">Waiting</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
$(document).ready(function () {
    $(document).on('change', 'input[name=toggle_three_shape]', function () {
        if($(this).is(":checked")) {
            window.location.href = '{{url('/integration-3shape/obtain-authorization-code')}}';
        } else {
            window.location.href = '{{url('/integrations/3shape-disable')}}';
        }
    });
});
</script>
@stop
