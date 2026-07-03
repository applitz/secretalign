<p class="text-muted mt-2 mb-0">
    <strong>Patient Name:</strong> {{ $getCaseHistory->first_name }} {{ $getCaseHistory->last_name }}
</p>

<p class="text-muted mt-2 mb-0">
    <strong>Event:</strong> {{ $getCaseHistory->event }}
</p>

<p class="text-muted mt-2 mb-0">
    <strong>From:</strong>
    @if($getCaseHistory->from == 'D')
        <span class="badge rounded-pill badge-soft-info">Doctor</span>
    @elseif($getCaseHistory->from == 'S')
        <span class="badge rounded-pill badge-soft-danger">Staff</span>
    @elseif($getCaseHistory->from == 'L')
        <span class="badge rounded-pill badge-soft-primary">Lab</span>
    @endif
</p>


<p class="text-muted mt-2 mb-0">
    <strong>To:</strong>
    @if($getCaseHistory->to == 'D')
        <span class="badge rounded-pill badge-soft-info">Doctor</span>
    @elseif($getCaseHistory->to == 'S')
        <span class="badge rounded-pill badge-soft-danger">Staff</span>
    @elseif($getCaseHistory->to == 'L')
        <span class="badge rounded-pill badge-soft-primary">Lab</span>
    @endif
</p>

<p class="text-muted mt-2 mb-0">
    <strong>Date:</strong> {{ $getCaseHistory->created_at->format('d-m-Y h:i:s A') }}
</p>

@php
    $data = json_decode($getCaseHistory->data);
    $data2 = json_decode($getCaseHistory->data, true);
@endphp

<p class="text-muted mt-2 mb-0">
     @if(!empty($data->comment))
        <strong>Comment:</strong> {!! $data->comment !!}
    @endif
</p>
@if(isset($data->treatment_link) && $data->treatment_link != null)
    <div class="mt-2 mb-2">
        <strong>Treatment Link:</strong>
        <a href="{{ $data->treatment_link }}" target="_blank" class="cursor-pointer">
            {{ $data->treatment_link }}
        </a>
    </div>
@endif

@if(isset($data->iframe_link) && $data->iframe_link != null)
    <div class="mt-2 mb-2">
        <strong>Doctor's Link:</strong>
        <a href="{{ $data->iframe_link }}" target="_blank" class="cursor-pointer">
            {{ $data->iframe_link }}
        </a>
    </div>
@endif

@if(isset($data->iframe_link_optional) && $data->iframe_link_optional != null)
    <div class="mt-2 mb-2">
        <strong>Doctor's Link 2(Optional):</strong>
        <a href="{{ $data->iframe_link_optional }}" target="_blank" class="cursor-pointer">
            {{ $data->iframe_link_optional }}
        </a>
    </div>
@endif

@if(isset($data->patient_link) && $data->patient_link != null)
    <div class="mt-2 mb-2">
        <strong>Patient's Link:</strong>
        <a href="{{ $data->patient_link }}" target="_blank" class="cursor-pointer">
            {{ $data->patient_link }}
        </a>
    </div>
@endif
@if(isset($data->tracking_id) && $data->tracking_id != null)
    <div class="mt-2 mb-2">
        <strong>Tracking Nr.:</strong>
        <a href="{{ $data->tracking_id }}" target="_blank" class="cursor-pointer">
            {{ $data->tracking_id }}
        </a>
    </div>
@endif

@if(isset($data->steps) && $data->steps != null)
    <div class="mt-2 mb-2">
        <strong>No Of Steps:</strong>{{ $data->steps }}
    </div>
@endif

@if(!empty($data2['attachments']))
    <div class="mt-2 mb-2">
        <strong>Attachments:</strong>
    </div>
    @foreach($data2['attachments'] as $attachment)
        <a href="{{ asset('file/' . $attachment) }}" target="_blank" class="btn btn-outline-primary btn-sm ms-1 cursor-pointer">
            View File
        </a>
    @endforeach
@endif
