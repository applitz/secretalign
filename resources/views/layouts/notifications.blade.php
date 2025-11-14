@if (@$notifications)
@foreach ($notifications as $notify)
<a @if ($notify->task_id != null)
    href="{{url('/view-tasks?task=' . $notify->task_id . '&notify=' . $notify->id)}}"
    @elseif($notify->treatment_plan_id != null)
    href="{{url('/patient/case-overview/' . $hashids->encode($notify->treatment_plan_id) . '?notify=' . $notify->id)}}"
@else
href="{{url('view-notifications')}}?read={{$notify->id}}"
    @endif class="text-reset notification-item">
    <div class="d-flex align-items-start">
        <div class="avatar-xs me-3">
            <span class="avatar-title bg-primary rounded-circle font-size-16">
                <i class="bx bx-bell"></i>
            </span>
        </div>
        <div class="flex-1">
            <h6 class="mt-0 mb-1">{{ $notify->title == null ? 'Task Alert' : $notify->title }}</h6>
            <div class="font-size-12 text-muted">
                <p class="mb-1">{{$notify->body}}</p>
                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> {{date("Y-m-d H:i:s",
                    strtotime($notify->created_at))}}</p>
            </div>
        </div>
    </div>
</a>
{{-- <a class="notification notification-flush notification-unread" @if ($notify->task_id != null)
    href="{{url('/view-tasks?task=' . $notify->task_id . '&notify=' . $notify->id)}}"
    @elseif($notify->treatment_plan_id != null)
    href="{{url('/patient/case-overview/' . $notify->treatment_plan_id . '?notify=' . $notify->id)}}"
@else
href="{{url('view-notifications')}}?read={{$notify->id}}"
    @endif>
    <div class="notification-body">
        <p class="mb-1"><strong>{{ $notify->title == null ? 'Task Alert' : $notify->title }}</strong> {{$notify->body}}</p>
        <span class="notification-time"><span class="me-2" role="img" aria-label="Emoji">📢</span>{{date("Y-m-d H:i:s",
            strtotime($notify->created_at))}}</span>

    </div>
</a> --}}
@endforeach
<input type="hidden" id="unread-notifications" name="unread-notifications" value="{{$count}}">
@else
<input type="hidden" id="unread-notifications" name="unread-notifications" value="0">
@endif
