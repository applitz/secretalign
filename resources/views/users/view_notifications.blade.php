@extends('layouts.app_base_horizontal')

@section('content')
<div class="page-content">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Manage Notifications</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Notifications</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card overflow-hidden mb-3">
                <div class="row m-4">
                    <div class="col-md-12 d-flex justify-content-end">
                        <a href="{{ route('notifications.read_all') }}" class="btn btn-primary waves-effect waves-light btn-sm"> Mark all as read </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="tech-companies-1" class="table ">
                                <thead>
                                    <tr>
                                        <tr>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Datetime</th>
                                        </tr>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notifications as $notify)
                                    <tr
                                    @if ($notify->read_at == null)
                        class="table-info"
style="cursor:pointer;"
                        data-bs-toggle="tooltip"
                        data-bs-placement="top" title="" data-bs-original-title="Click to Read"
                        aria-label="Click to Read"


                    @endif

                                    @if ($notify->task_id != null)
                                        onclick="window.location.href='{{url('/view-tasks?task=' . $notify->task_id . '&notify=' . $notify->id)}}';"
                                        @elseif($notify->treatment_plan_id != null)
                                        onclick="window.location.href='{{url('/patient/case-overview/' . $hashids->encode($notify->treatment_plan_id) . '?notify=' . $notify->id)}}'"

                                        @endif>
                                        <td>Task Alert</td>
                                        <td>{{$notify->body}}</td>
                                        <td>{{date("Y-m-d
                                            H:i:s",
                                            strtotime($notify->created_at))}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                {{ $notifications->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>


                    {{-- @foreach ($notifications as $notify)
                    <a class="border-bottom-0 notification @if ($notify->read_at == null)
                        notification-unread
                    @endif rounded-0 border-x-0 border-300" @if ($notify->task_id != null)
                        href="{{url('/view-tasks?task=' . $notify->task_id . '&notify=' . $notify->id)}}"
                        @elseif($notify->treatment_plan_id != null)
                        href="{{url('/patient/case-overview/' . $notify->treatment_plan_id . '?notify=' . $notify->id)}}"
                        @else
                        href="javascript:void(0);"
                        @endif>
                        <div class="notification-body">
                            <p class="mb-1"><strong>Task Alert</strong> {{$notify->body}}</p>
                            <span class="notification-time"><span class="me-2" role="img" aria-label="Emoji">📢</span>{{date("Y-m-d
                                H:i:s",
                                strtotime($notify->created_at))}}</span>

                        </div>
                    </a>

                    @endforeach --}}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
