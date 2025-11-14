@extends('layouts.app_base_horizontal')

@section('content')
<div class="row gx-0 kanban-header rounded-2 px-card py-2 mt-2 mb-3">
    <div class="col d-flex align-items-center">
        <h5 class="mb-0">Phase Period Settings</h5>
        <div class="vertical-line vertical-line-400 position-relative h-100 mx-3"></div>
    </div>
    <div class="col-auto d-flex align-items-center">
        <a href="{{ url()->previous() }}" class="btn btn-sm btn-falcon-default me-2 d-none d-md-block"><span
                class="fas fa-level-down-alt me-2"></span>Back</a>

    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <div class="row flex-between-end">
            <div class="col-auto align-self-center">
                <h5 class="mb-0">Edit Settings</h5>
            </div>
        </div>
    </div>
    <div class="card-body bg-light">
        <form class="save-form" method="POST" action="{{ url('/treatment-plan-phase-period-settings') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="period_duration">Period Duration (Weeks)</label>
                <input class="form-control @error('period_duration') is-invalid @enderror" id="period_duration"
                    type="text" value="{{ @$settings->payload }}" placeholder="Period Duration" name="period_duration">
                @error('period_duration')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <input type="submit" name="submit" class="btn btn-falcon-default" value="Save Changes">
            </div>
        </form>
    </div>
</div>
@stop


@section('javascript')

@stop