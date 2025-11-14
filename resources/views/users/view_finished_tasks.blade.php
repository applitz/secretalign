@extends('layouts.app_base_horizontal')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Manage Tasks</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Finished Tasks</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>


    @if(Auth::user()->role == 'doctor' || Auth::user()->role == 'staff' || Auth::user()->role == 'lab')

    <div class="row">
        <div class="col">
            <div class="card h-lg-100 overflow-hidden">
                <div class="card-body ">
                    <h4 class="card-title">Finished</h4>
                    <p class="card-title-desc">Your completed tasks</p>
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="tech-companies-1" class="table ">
                            <thead class="bg-light">
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Patient</th>
                                    <th>Task</th>
                                    <th>From</th>
                                    <th>Task Date</th>
                                    <th>Treatment Plan</th>
                                    <th class="text-end" style="width: 8rem"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($tasks) == 0)
                                <tr>
                                    <td colspan="6" class="text-center"> No Tasks To Show </td>
                                </tr>
                                @else
                                @foreach ($tasks as $task)
                                <tr>
                                    <td class="text-nowrap">{{$task->first_name}}</td>
                                    <td class="text-nowrap">{{$task->last_name}}</td>
                                    <td class="text-nowrap">{{ $task->p_first_name . ' ' . $task->p_last_name }}
                                    </td>
                                    <td class="text-nowrap">
                                        <div class="font-sans-serif btn-reveal-trigger">
                                            <a class="btn btn-link badge-soft-primary text-600 btn-sm btn-reveal-sm transition-none"
                                                href="{{url('/patient/case-overview/' . $hashids->encode($task->treatment_plan_id))}}"
                                                data-boundary="viewport" aria-haspopup="true"
                                                aria-expanded="false">{{$task->task}}</a>
                                        </div>
                                    </td>

                                    <td class="text-nowrap">
                                        @if($task->previous_case_holder)
                                        {{ucfirst($task->previous_case_holder)}}
                                        @endif
                                    </td>
                                    <td class="text-nowrap">{{date("d/m/Y", strtotime($task->created_at))}}</td>
                                    <td class="text-nowrap"><span
                                            class="badge fw-semi-bold rounded-pill status badge-soft-primary">{{"Phase" .
                                            $task->phase}}</span></td>
                                    <td class="text-end text-nowrap">
                                        <div class="font-sans-serif btn-reveal-trigger">
                                            <a class="btn btn-link text-600 btn-sm btn-reveal-sm transition-none"
                                                href="{{url('/patient/case-overview/' . $hashids->encode($task->treatment_plan_id))}}"
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
                        <div class="col-12">
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
