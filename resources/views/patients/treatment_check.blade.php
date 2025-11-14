@extends('layouts.app_base_horizontal')
@section('content')
<div class="page-content">
    @if (@$_GET['i'] != 'true')
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex flex-column mt-3">
                    <h4 class="page-title mb-0 font-size-18">Treatment Preview</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/patients') }}">Patients</a></li>
                            <li class="breadcrumb-item active">Checklist Preview</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="mt-4">
        <div class="card shadow rounded-4 border-0">
            <div class="card-header bg-teal text-white d-flex justify-content-between align-items-center rounded-top-4">
                <h5 class="mb-0">KONTROLLBLATT</h5>
                <div>
                    <a href="{{ route('treatment.export', $hashids->encode($treatment->id)) }}" 
                       class="btn btn-danger btn-sm me-2 text-white shadow-sm">
                        <i class="bi bi-file-earmark-arrow-down me-1"></i> Export PDF
                    </a>
                    <button onclick="window.print()" class="btn btn-warning btn-sm">
                        <i class="bi bi-printer"></i> Print
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Coworker Name:</strong> {{ $treatment->coworker_name }}
                </div>
                <h6 class="fw-bold mb-2 text-uppercase text-teal">VOR DRUCK</h6>
                <div class="list-group mb-3">
                    @foreach ([
                        'attachments_model' => '1. Attachements am Modell?',
                        'bars_model' => '2. Bars am Modell? (Mitte)',
                        'name_patient' => '3. Name am Modell = Patient?',
                        'model_dashboard' => '4. Modell passt zu SetUp am Dashboard?',
                        'cutouts_hooks' => '5. CutOuts/precision Cuts & I-Hooks & Wings vorhanden?',
                        'schnittlinie' => '6. Schnittlinie passt?'
                    ] as $field => $label)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $label }}</span>
                            <span class="badge {{ $treatment->$field ? 'bg-success' : 'bg-secondary' }}">
                                {{ $treatment->$field ? 'Yes' : 'No' }}
                            </span>
                        </div>
                    @endforeach
                </div>
                <h6 class="fw-bold mb-2 text-uppercase text-teal">TIEFZIEHEN & SCHNEIDEN</h6>
                <div class="list-group mb-3">
                    @foreach ([
                        'zahlen_vergleichen' => '1. Zahlen vergleichen',
                        'cutouts_schiene' => '2. Cut Outs auf der Schiene?'
                    ] as $field => $label)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $label }}</span>
                            <span class="badge {{ $treatment->$field ? 'bg-success' : 'bg-secondary' }}">
                                {{ $treatment->$field ? 'Yes' : 'No' }}
                            </span>
                        </div>
                    @endforeach
                </div>
                <h6 class="fw-bold mb-2 text-uppercase text-teal">VOR DEM EINPACKEN</h6>
                <div class="list-group">
                    @foreach ([
                        'folie_runtergenommen' => '1. Folie runtergenommen?',
                        'richtig_einpacken' => '2. Richtig einpacken - Zahlen!',
                        'richtiger_asr' => '3. Richtiger ASR Zettel!'
                    ] as $field => $label)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $label }}</span>
                            <span class="badge {{ $treatment->$field ? 'bg-success' : 'bg-secondary' }}">
                                {{ $treatment->$field ? 'Yes' : 'No' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-teal {
        color: #008080 !important;
    }
    @media print {
        .btn, .page-title-box, .breadcrumb, .card-header {
            display: none !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
    }
    .btn-danger:hover {
        background-color: #d62828 !important;
        transform: translateY(-2px);
        transition: all 0.2s ease-in-out;
    }
</style>
@endsection