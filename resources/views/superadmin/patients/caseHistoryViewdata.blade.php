<p class="text-muted mt-2 mb-0">
    <strong>Patient Name:</strong> {{ $getCaseHistory->first_name }} {{ $getCaseHistory->last_name }}
</p>

<p class="text-muted mt-2 mb-0">
    <strong>Event:</strong> {{ $getCaseHistory->event }}
</p>

@php
    $data = json_decode($getCaseHistory->data);
    $data2 = json_decode($getCaseHistory->data, true);
@endphp

@if(!empty($data->dob))
<p class="text-muted mt-2 mb-0">
    <strong>DOB:</strong> {{ date('d-m-Y', strtotime($data->dob)) }}
</p>
@endif

@if(!empty($data->treatment_type))
<p class="text-muted mt-2 mb-0">
    <strong>Treatment Type:</strong> {{ $data->treatment_type }}
</p>
@endif
@if(!empty($data->scan_type))
<p class="text-muted mt-2 mb-0">
    <strong>Original bite registration STL File</strong>
</p>
@endif

@if(!empty($data->scan_type))
<table class="table table-bordered mt-2 mb-0 w-100" >
    <thead>
        <tr>
            <th>Scan Type</th>
            <th>Case ID</th>
            <th>Upper File</th>
            <th>Lower File</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $data->scan_type }}</td>
            <td>{{ $data->case_id }}</td>
            <td>
                <a href="{{ asset('/storage/PatientFiles/Patient' . $getCaseHistory->patient_id . '/' . $data->upper_file) }}" target="_blank" class="cursor-pointer">
                        Download Upper File
                </a>
            </td>
            <td>
                <a href="{{ asset('/storage/PatientFiles/Patient' . $getCaseHistory->patient_id . '/' . $data->lower_file) }}" target="_blank" class="cursor-pointer">
                    Download Lower File
                </a>
            </td>
        </tr>
    </tbody>
</table>
@endif
@if(!empty($data->optional_scan_type))
    <p class="text-muted mt-2 mb-0">
        <strong>Mandibular Repositioning STL Files (Optional) </strong>
    </p>
@endif
@if(!empty($data->optional_scan_type))
<table class="table table-bordered mt-2 mb-0 w-100" >
    <thead>
        <tr>
            <th>Scan Type</th>
            <th>Case ID</th>
            <th>Upper File</th>
            <th>Lower File</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $data->optional_scan_type }}</td>
            <td>{{ $data->optional_case_id }}</td>
            <td>
                <a href="{{ asset('/storage/PatientFiles/Patient' . $getCaseHistory->patient_id . '/' . $data->optional_upper_file) }}" target="_blank" class="cursor-pointer">
                    Download Upper File
                </a>
            </td>
            <td>
                <a href="{{ asset('/storage/PatientFiles/Patient' . $getCaseHistory->patient_id . '/' . $data->optional_lower_file) }}" target="_blank" class="cursor-pointer">
                    Download Lower File
                </a>
            </td>
        </tr>
    </tbody>
</table>
@endif
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
