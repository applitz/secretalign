<thead>
    <tr>
        <th>Date Updated</th>
        <th>Date Created</th>
        <th>Case Name</th>
        <th>Patient Name</th>
        <th>Status</th>
    </tr>
</thead>

<tbody>
    @if(count($results) > 0)
    @foreach ($results as $result)
    <tr class="download-medit-link-stl-files" style="cursor: pointer" data-uuid="{{$result->uuid}}" data-name="{{$result->patient->name}}">
        <td>{{$result->dateUpdated}}</td>
        <td>{{$result->dateCreated}}</td>
        <td>{{$result->name}}</td>
        <td>{{@$result->patient->name}}</td>
        <td>
            <span
                class="badge rounded-pill bg-primary-subtle text-primary  font-size-11">{{$result->status}}</span>
        </td>
    </tr>
    @endforeach
    @else
    <tr>
        <td colspan="5" class="text-center">No data to show</td>
    </tr>
    @endif
</tbody>
