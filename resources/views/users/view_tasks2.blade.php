@extends('layouts.app_base_horizontal')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Manage Tasks</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Tasks</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>


    @if (Auth::user()->role == 'doctor' || Auth::user()->role == 'staff' || Auth::user()->role == 'lab')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Tasks</h4>
                    <p class="card-title-desc">Unfinished Tasks</p>

                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="tech-companies-1" class="table table-striped">
                                <thead>
                                    <tr>
                                        @if (Auth::user()->role != 'doctor' && Auth::user()->role != 'lab')
                                        <th>Last Name</th>
                                        <th>First Name</th>
                                        @endif
                                        @if(Auth::user()->role == 'doctor' || Auth::user()->role == 'staff')
                                        <th>Patient</th>
                                        @endif
                                        <th>Task</th>
                                        @if(Auth::user()->role == 'staff')
                                        <th>From</th>
                                        @endif
                                        <th>Date</th>
                                        @if (Auth::user()->role == 'doctor')
                                        <th>Due Date</th>
                                        @endif
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($tasks) == 0)
                                    <tr>
                                        <td colspan="6" class="text-center"> No Tasks To Show </td>
                                    </tr>
                                    @else
                                    @foreach ($tasks as $task)
                                    <tr>
                                        @if (Auth::user()->role != 'doctor' && Auth::user()->role != 'lab')
                                        <td class="text-nowrap">{{ $task->last_name }}</td>
                                        <td class="text-nowrap">{{ $task->first_name }}</td>
                                        @endif
                                        @if(Auth::user()->role == 'doctor' || Auth::user()->role == 'staff')
                                        <td class="text-nowrap">{{ $task->p_first_name . ' ' . $task->p_last_name }}
                                        </td>
                                        @endif
                                        <td class="text-nowrap">
                                            <div class="font-sans-serif btn-reveal-trigger">
                                                <a class="btn btn-link badge-soft-primary text-600 btn-sm btn-reveal-sm transition-none"
                                                    href="{{ url('/patient/case-overview/' . $hashids->encode($task->treatment_plan_id)) }}"
                                                    data-boundary="viewport" aria-haspopup="true" aria-expanded="false">{{
                                                    $task->task }}</a>
                                            </div>
                                        </td>
                                        @if(Auth::user()->role == 'staff')
                                        <td class="text-nowrap">
                                        @if($task->previous_case_holder)
                                            {{ucfirst($task->previous_case_holder)}}
                                        @endif
                                        </td>
                                        @endif
                                        <td class="text-nowrap">{{ date('d/m/Y', strtotime($task->created_at)) }}
                                        </td>
                                        @if(Auth::user()->role == 'doctor')
                                        <td class="text-nowrap">
                                            @if(@$task->cancellation_date)
                                            {{date("Y-m-d", strtotime("-1 day", strtotime(date("Y-m-d",
                                            strtotime($task->cancellation_date)))))}}
                                            @endif
                                        </td>
                                        @endif
                                        {{-- <td class="text-nowrap"><span
                                                class="badge fw-semi-bold rounded-pill status badge-soft-primary">{{ 'Phase' .
                                                $task->phase }}</span>
                                        </td> --}}
                                        <td class="text-end text-nowrap">
                                            <div class="font-sans-serif btn-reveal-trigger">
                                                <a class="btn btn-link text-600 btn-sm btn-reveal-sm transition-none"
                                                    href="{{ url('/patient/case-overview/' . $hashids->encode($task->treatment_plan_id)) }}"
                                                    data-boundary="viewport" aria-haspopup="true" aria-expanded="false">Case
                                                    Overview</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif

                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12 ">
                                {{ $tasks->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endif


</div>






@endsection
