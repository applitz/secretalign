
{{-- <input type="text" name="patient_id_additional" value="{{ @$patient->patient_id }}">
<input type="text" name="treatment_plan_id_additional" value="{{ @$patient->id }}"> --}}
<thead>
    <tr>
        <th>Case ID</th>
        <th>Patient Name</th>
        <th>Created</th>
        <th>Scan Upper Arch</th>
        <th>Scan Lower Arch</th>
    </tr>
</thead>
<tbody>
   @if(count($results) > 0)
    @foreach($results as $patient)
    @php
        $scan_upper_arch = null;
        $scan_lower_arch = null;
        if(@$patient->Scans) {
            foreach($patient->Scans as $scan) {
                if(@$scan->JawType == 'upper' && @$scan->FileType == 'stl') {
                    $scan_upper_arch = @$scan->Hash;
                }
                if(@$scan->JawType == 'lower' && @$scan->FileType == 'stl') {
                    $scan_lower_arch = @$scan->Hash;
                }
            }
        }
    @endphp
    <tr class="download-3shape-stl-files-additional" style="cursor: pointer" hash-upper="{{$scan_upper_arch}}" hash-lower="{{$scan_lower_arch}}" case-id="{{$patient->Id}}" data-bs-toggle="tooltip"
    data-bs-placement="top" title="" data-bs-original-title="Click to Download Files" aria-label="View">
        <td>{{$patient->Id}}</td>
        <td>{{@$patient->PatientName}}</td>
        <td>{{@$patient->Created}}</td>
        <td>
            <div class="text-center">
                @if($scan_upper_arch)
                <span
                class="badge rounded-pill bg-success-subtle text-success  font-size-11">Available</span>
                @else
                <span
                class="badge rounded-pill bg-secondary-subtle text-secondary  font-size-11">Not Available</span>
                @endif

            </div>
        </td>
        <td>
            <div class="text-center">
                @if($scan_upper_arch)
                <span
                class="badge rounded-pill bg-success-subtle text-success  font-size-11">Available</span>
                @else
                <span
                class="badge rounded-pill bg-secondary-subtle text-secondary  font-size-11">Not Available</span>
                @endif

            </div>
        </td>
    </tr>
    @endforeach
   @else
<tr>
    <td colspan="5" class="text-center">No data to show</td>
</tr>
   @endif
</tbody>
