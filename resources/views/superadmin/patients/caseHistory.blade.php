@extends('layouts.app_base_horizontal')

@section('content')
<style>
    .timeline-count .row:first-child .timeline-box:first-child .timeline-line, .timeline-count .row:last-child .timeline-box:last-child .timeline-line {
        border-top: 3px solid #1C8484  !important;
    }
    .timeline-box .timeline-line {
        border-top: 3px solid #1C8484 !important;
    }

    .timeline-count .row:nth-child(odd) .timeline-box:last-child:before {
        border-right: 3px solid #1C8484 !important;
    }
    .timeline-count .row:nth-child(even) .timeline-box:last-child:before {
        border-left: 3px solid #1C8484 !important;
    }

    .timeline-box .vertical-line .wrapper-line {
        height: 25px !important;
    }

    .timeline-box .timeline-spacing {
        margin-bottom: 50px !important;
    }
</style>
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Manage Patients</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('/home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/superadmin/patients')}}">Manage Patients</a></li>
                        <li class="breadcrumb-item active">Case History</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="timeline-count p-4">


                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Events</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($getCaseHistory as $caseHistory)
                                        <tr>
                                            <th>{{ $loop->index + 1 }}</th>
                                            <td>{{ $caseHistory->event }}</td>
                                            <td>
                                                @if($caseHistory->from == 'D')
                                                    <span class="badge rounded-pill badge-soft-info">Doctor</span>
                                                @elseif($caseHistory->from == 'S')
                                                    <span class="badge rounded-pill badge-soft-danger">Staff</span>
                                                @elseif($caseHistory->from == 'L')
                                                    <span class="badge rounded-pill badge-soft-primary">Lab</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if($caseHistory->to == 'D')
                                                    <span class="badge rounded-pill badge-soft-info">Doctor</span>
                                                @elseif($caseHistory->to == 'S')
                                                    <span class="badge rounded-pill badge-soft-danger">Staff</span>
                                                @elseif($caseHistory->to == 'L')
                                                    <span class="badge rounded-pill badge-soft-primary">Lab</span>
                                                @endif
                                            </td>
                                            <td>{{ $caseHistory->created_at->format('d-m-Y h:i:s A') }}</td>
                                            <td>
                                                <a class="btn p-0 ms-2 viewCaseHistory" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#viewCaseHistoryModal">
                                                    <i class="fa fa-eye text-primary" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Timeline row Start -->
                        {{-- <div class="row">
                            @foreach($getCaseHistory as $caseHistory)

                            @php
                                $data = json_decode($caseHistory->data);
                                $data2 = json_decode($caseHistory->data, true);
                            @endphp
                            <!-- Timeline 1 -->
                                <div class="timeline-box col-lg-4">
                                    <div class="timeline-spacing">
                                        <div class="item-lable bg-primary rounded" style="width: fit-content; padding: 2px 10px;">
                                            <p class="text-center text-white mb-0 fs-3">
                                                {{ $loop->index + 1 }}
                                            </p>
                                        </div>

                                        <div class="timeline-line active">
                                            <div class="dot bg-primary"></div>
                                        </div>
                                        <div class="vertical-line">
                                            <div class="wrapper-line bg-light"></div>
                                        </div>
                                        <div class="bg-light p-4 rounded mx-3">
                                            <h5>{{ $caseHistory->event }}</h5>

                                                <p class="card-text">
                                                    <strong>From:</strong>
                                                    @if($caseHistory->from == 'D')
                                                        <span class="badge rounded-pill badge-soft-info">Doctor</span>
                                                    @elseif($caseHistory->from == 'S')
                                                        <span class="badge rounded-pill badge-soft-danger">Staff</span>
                                                    @elseif($caseHistory->from == 'L')
                                                        <span class="badge rounded-pill badge-soft-primary">Lab</span>
                                                    @endif
                                                </p>

                                            <p class="card-text">
                                                    <strong>To:</strong>
                                                    @if($caseHistory->to == 'D')
                                                        <span class="badge rounded-pill badge-soft-info">Doctor</span>
                                                    @elseif($caseHistory->to == 'S')
                                                        <span class="badge rounded-pill badge-soft-danger">Staff</span>
                                                    @elseif($caseHistory->to == 'L')
                                                        <span class="badge rounded-pill badge-soft-primary">Lab</span>
                                                    @endif
                                                </p>
                                            </p>
                                            @if(!empty($data->comment))
                                                <p class="text-muted mb-0">
                                                    <strong>Comment:</strong> {!! $data->comment !!}
                                                </p>
                                            @endif

                                            @if(!empty($data2['attachments']))
                                                <div class="mt-2 mb-2">
                                                    <strong>Attachments:</strong>
                                                </div>
                                                @foreach((array) $data2['attachments'] as $attachment)
                                                    @if(is_string($attachment))
                                                        <a href="{{ asset('storage/' . $attachment) }}"
                                                        target="_blank"
                                                        class="btn btn-outline-primary btn-sm ms-1">
                                                            View File
                                                        </a>
                                                    @endif
                                                @endforeach
                                            @endif

                                            <footer class="mb-0 mt-2 text-end fs-6">
                                                {{ $caseHistory->created_at->format('d-m-Y h:i:s A') }}
                                            </footer>
                                        </div>
                                    </div>
                                </div>
                                <!-- Timeline 1 -->
                                @php
                                    $data = [];
                                    $data2 = [];
                                @endphp
                            @endforeach

                        </div> --}}
                    </div>
                    {{-- <div class="timeline-count p-4 mt-4">

                        @foreach($getCaseHistory as $caseHistory)
                            @php
                                $data = json_decode($caseHistory->data);
                                $data2 = json_decode($caseHistory->data, true);
                                $groupNumber = floor($loop->index / 3);
                                $cardClass = ($groupNumber % 2 == 0)
                                    ? '1'
                                    : '2';
                            @endphp

                            @if($loop->index % 3 == 0)
                                <div class="row">
                            @endif

                            <div class="timeline-box col-lg-4">
                                <div class="timeline-spacing">
                                    <div class="item-lable bg-primary rounded" style="width: fit-content; padding: 0 10px;">
                                        <p class="text-center text-white mb-0">
                                            {{ $caseHistory->created_at->format('d-m-Y h:i:s A') }}
                                        </p>
                                    </div>

                                    <div class="timeline-line active">
                                        <div class="dot bg-primary"></div>
                                    </div>

                                    <div class="vertical-line">
                                        <div class="wrapper-line bg-light"></div>
                                    </div>

                                    <div class="bg-light  text-start p-4 rounded mx-3">
                                        <h5>{{ $caseHistory->event }}</h5>
                                        @if($cardClass == '1')
                                            <p class="d-flex justify-content-between mb-0">
                                                <span>
                                                    <strong>From:</strong>
                                                    @if($caseHistory->from == 'D')
                                                        <span class="badge rounded-pill badge-soft-info">Doctor</span>
                                                    @elseif($caseHistory->from == 'S')
                                                        <span class="badge rounded-pill badge-soft-danger">Staff</span>
                                                    @elseif($caseHistory->from == 'L')
                                                        <span class="badge rounded-pill badge-soft-primary">Lab</span>
                                                    @endif
                                                </span>

                                                <span>
                                                    <strong>To:</strong>
                                                    @if($caseHistory->to == 'D')
                                                        <span class="badge rounded-pill badge-soft-info">Doctor</span>
                                                    @elseif($caseHistory->to == 'S')
                                                        <span class="badge rounded-pill badge-soft-danger">Staff</span>
                                                    @elseif($caseHistory->to == 'L')
                                                        <span class="badge rounded-pill badge-soft-primary">Lab</span>
                                                    @endif
                                                </span>
                                            </p>
                                            @if(!empty($data->comment))
                                                <p class="text-muted mb-0">
                                                    <strong>Comment:</strong> {!! $data->comment !!}
                                                </p>
                                            @endif

                                            @if(!empty($data2['attachments']))
                                                <div class="mt-2 mb-2">
                                                    <strong>Attachments:</strong>
                                                </div>
                                                @foreach($data2['attachments'] as $attachment)

                                                    <a href="{{ asset('storage/' . $attachment) }}"
                                                    target="_blank"
                                                    class="btn btn-outline-primary btn-sm ms-1 cursor-pointer">
                                                        View File
                                                    </a>
                                                @endforeach
                                            @endif
                                        @else
                                            <p class="d-flex justify-content-between mb-0">
                                                 <span>
                                                    @if($caseHistory->to == 'D')
                                                        <span class="badge rounded-pill badge-soft-info">Doctor</span>
                                                    @elseif($caseHistory->to == 'S')
                                                        <span class="badge rounded-pill badge-soft-danger">Staff</span>
                                                    @elseif($caseHistory->to == 'L')
                                                        <span class="badge rounded-pill badge-soft-primary">Lab</span>
                                                    @endif
                                                    <strong>: To</strong>
                                                </span>
                                                <span>
                                                    @if($caseHistory->from == 'D')
                                                        <span class="badge rounded-pill badge-soft-info">Doctor</span>
                                                    @elseif($caseHistory->from == 'S')
                                                        <span class="badge rounded-pill badge-soft-danger">Staff</span>
                                                    @elseif($caseHistory->from == 'L')
                                                        <span class="badge rounded-pill badge-soft-primary">Lab</span>
                                                    @endif
                                                    <strong>: From</strong>
                                                </span>
                                            </p>

                                            @if(!empty($data->comment))
                                                <p class="text-muted mb-0">
                                                    <strong>: Comment</strong> {!! $data->comment !!}
                                                </p>
                                            @endif
                                            @if(!empty($data2['attachments']))

                                                @foreach((array) $data2['attachments'] as $attachment)
                                                    <a
                                                    target="_blank"
                                                    class="btn btn-outline-primary btn-sm ms-1 cursor-pointer">
                                                        View File
                                                    </a>
                                                @endforeach
                                            @endif
                                        @endif


                                    </div>
                                </div>
                            </div>

                            @if(($loop->iteration % 3 == 0) || $loop->last)
                                </div>
                            @endif

                        @endforeach

                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script src="{{ asset('public/assets/customjs/superadmin/patientsCaseHistory.js') }}"></script>


<script>
    $(document).ready(function() {
        PatientsCaseHistory.init();
    });
</script>

@endsection
