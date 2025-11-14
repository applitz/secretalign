@extends('layouts.app_base_horizontal')

@section('content')

<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Manage Upcoming Events</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('/events/view')}}">Events</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>


    <div class="card mb-3">
        <div class="card-body ">
            <h4 class="card-title mb-3">Edit Event</h4>


            <form class="save-form " method="POST" action="{{ url('/events/update') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="eventId" value="{{$event->id}}">
                <div class="mb-3">
                    <label class="form-label" for="title">Event Name</label>
                    <input class="form-control @error('event_name') is-invalid @enderror" id="event_name" type="text"
                        value="{{ $event->event_name }}" placeholder="Event Name" name="event_name">
                    @error('event_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="title">Event Date</label>
                    <input class="form-control pickr @error('date') is-invalid @enderror"
                    data-options='{"dateFormat":"d/m/y","disableMobile":true}'

                    id="date" type="text"
                        value="{{ $event->date }}" placeholder="d/m/Y" name="date">
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="title">External Link</label>
                    <input class="form-control @error('link') is-invalid @enderror" id="link" type="text"
                        value="{{ $event->external_link }}" placeholder="https://" name="link">
                    @error('link')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description">{{ $event->description }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <input type="submit" name="submit" class="btn btn-primary waves-effect waves-light" value="Save Changes">
                </div>
            </form>
        </div>
    </div>
</div>


@stop


@section('javascript')
<script>
    $(function () {   const fp = flatpickr($(".pickr"), {}); });
</script>
@stop
