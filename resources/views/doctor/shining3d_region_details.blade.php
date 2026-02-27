@extends('layouts.app_base_horizontal')

@section('content')
<div class="page-content">

    @include('layouts.breadcrumb')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18" >Shining3d Region Details</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('/home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Shining3d Region Details</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="accordion" id="regionAccordion">

                        @foreach($regions as $key => $region)
                            <div class="accordion-item mb-2">
                                <h2 class="accordion-header " id="heading{{ $key }}">
                                    <button class="accordion-button fw-bold bg-primary text-white {{ $key != 0 ? 'collapsed' : '' }}"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $key }}"
                                            aria-expanded="{{ $key == 0 ? 'true' : 'false' }}"
                                            aria-controls="collapse{{ $key }}">

                                        {{ $region->name }}
                                    </button>
                                </h2>

                                <div id="collapse{{ $key }}"
                                    class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}"
                                    aria-labelledby="heading{{ $key }}"
                                    data-bs-parent="#regionAccordion">

                                    <div class="accordion-body">

                                        @if($region->countries->count() > 0)

                                            <div class="row">
                                                @foreach($region->countries as $country)
                                                    <div class="col-lg-2 col-md-4 col-12 mb-3">
                                                        <div class="card border shadow-sm h-100">
                                                            <div class="card-body p-2">

                                                                <h6 class="mb-1 fw-bold">
                                                                    {{ $country->country_name }}
                                                                </h6>

                                                                <small class="text-muted">
                                                                    {{ $country->code ?? '(' . $country->country_code . ')' }}
                                                                </small>

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                        @else
                                            <p class="text-muted mb-0">No countries available in this region.</p>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection


