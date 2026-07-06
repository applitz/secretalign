@extends('layouts.app_base_horizontal')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Manage Patients</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('/home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Manage Patients</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="filter-form">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <div class="row align-items-center g-3">
                                <div class="col-12">
                                    <h6 class="text-700 mb-0">Date: </h6>
                                </div>
                                <div class="col-12 position-relative">
                                    <input class="form-control form-control-sm pickr ps-4" name="date" id="CRMDateRange" style="border: 1px solid #aaa;"
                                        value="{{ @$_GET['date'] }}" placeholder="Y-m-d to Y-m-d" type="text"
                                        data-options="{&quot;mode&quot;:&quot;range&quot;,&quot;dateFormat&quot;:&quot;M d&quot;,&quot;disableMobile&quot;:true , &quot;defaultDate&quot;: [&quot;Aug 15&quot;, &quot;Aug 22&quot;] }" /><span
                                        class="fas fa-calendar-alt text-primary position-absolute top-50 translate-middle-y ms-2">
                                    </span>
                                </div>
                                </div>
                            </div>

                            <div class="col-md-2 mb-3">
                                <div class="row align-items-center g-3">
                                <div class="col-12">
                                    <h6 class="text-700 mb-0">Doctor: </h6>
                                </div>
                                <div class="col-12 position-relative">
                                    <select class="form-select form-select-sm mySelect2" id="ft_doctor" style="border: 1px solid #aaa;"
                                        name="ft_doctor" data-options='{"removeItemButton":true,"placeholder":true}'>
                                        <option value="">Any</option>
                                        @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" {{ request('doctor') == $doctor->id ? 'selected' : '' }}>
                                            {{ $doctor->user_full_name }}
                                        @endforeach
                                    </select>
                                </div>
                                </div>
                            </div>

                            <div class="col-md-2 mb-3">
                                <div class="row align-items-center g-3">
                                <div class="col-12">
                                    <h6 class="text-700 mb-0">Status: </h6>
                                </div>
                                <div class="col-12 position-relative">
                                    <select class="form-select form-select-sm mySelect2" id="statuChooser" style="border: 1px solid #aaa;"
                                        name="ft_status" data-options='{"removeItemButton":true,"placeholder":true}'>
                                        <option value="">Any</option>
                                        @foreach($statusOptions as $status)
                                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                </div>
                            </div>


                            <div class="col-md-2 mb-3">
                                <div class="row align-items-center g-3">
                                <div class="col-12">
                                    <h6 class="text-700 mb-0">Case Holder: </h6>
                                </div>
                                <div class="col-12 position-relative">
                                    <select class="form-select form-select-sm mySelect2" id="ft_case_holder" style="border: 1px solid #aaa;"
                                        name="ft_case_holder" data-options='{"removeItemButton":true,"placeholder":true}'>
                                        <option value="">Any</option>
                                        @foreach($caseHolderOptions as $caseHolder)
                                        <option value="{{ $caseHolder }}" {{ request('case_holder') == $caseHolder ? 'selected' : '' }}>{{ ucfirst($caseHolder) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                </div>
                            </div>

                            <div class="col-md-2 mb-3">
                                <div class="row align-items-center g-3">
                                <div class="col-12">
                                    <h6 class="text-700 mb-0">Search: </h6>
                                </div>
                                <div class="col-12 position-relative">
                                    <input class="form-control form-control-sm" id="ft_search" name="ft_search" placeholder="Search" style="border: 1px solid #aaa;"
                                        value="{{ @$_GET['search'] }}" />
                                </div>
                                </div>
                            </div>

                            <div class="col-md-2 mb-3">
                                <div class="row align-items-center g-3">
                                    <div class="col-12">
                                        <h6 class="text-700 mb-0">&nbsp;</h6>
                                    </div>
                                    <div class="col-12 position-relative">
                                        <div class="btn-group">
                                            <button class="btn btn-primary waves-effect waves-light btn-sm submit-filter-form" type="submit"><i
                                                class="fas fa-search me-2"></i> Filter</button>
                                            <a class="btn btn-warning waves-effect waves-light btn-sm" id="clear-filters" href="javascript:;"><i
                                                class="fas fa-trash-alt me-2"></i> Clean Filters</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="patients-list" class="table table-striped">

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script src="{{ asset('public/assets/plugins/dataTables/1.11.5/js/jquery.dataTables.min.js') }}?v={{ time() }}"></script>
<script src="{{ asset('public/assets/plugins/dataTables/1.11.5/js/dataTables.bootstrap5.min.js') }}?v={{ time() }}"></script>
<script src="{{ asset('public/assets/plugins/dataTables/responsive/2.2.9/js/dataTables.responsive.min.js') }}?v={{ time() }}"></script>
<script src="{{ asset('public/assets/customjs/superadmin/patients.js') }}?v={{ time() }}"></script>


<script>
    $(document).ready(function() {
        Patients.init();
    });
</script>

<script>
    document.addEventListener('click', function (e) {
        if (e.target.closest('.change-expiry-date')) {
            const btn = e.target.closest('.change-expiry-date');

            document.getElementById('modal_patient_id').value = btn.dataset.patientId;
            document.getElementById('modal_expiry_date_patient_name').innerText = btn.dataset.patientName;
            const rawDate = btn.dataset.currentExpiry; // e.g. 2025-12-23

            if (rawDate) {
                const [year, month, day] = rawDate.split('-');
                const formattedDate = `${day}.${month}.${year}`;

                document.getElementById(
                    'modal_expiry_date_current_expiry_date'
                ).innerText = formattedDate;
            }

            // document.getElementById('modal_expiry_date_current_expiry_date').innerText = btn.dataset.currentExpiry;
            document.getElementById('modal_expiry_date').value = btn.dataset.currentExpiry;

            // ✅ Password input clear
            const passwordInput = document.getElementById('modal_change_expiry_date_password');
            passwordInput.value = '';
            passwordInput.classList.remove('is-invalid');

            // ✅ Password error text clear
            document.querySelector('.password_error').innerText = '';
        }
    });

    document.addEventListener('click', function (e) {
        if (e.target.closest('.change-case-holder')) {
            const btn = e.target.closest('.change-case-holder');

            document.getElementById('modal_patient_id').value = btn.dataset.patientId;
            document.getElementById('modal_change_case_holder_patient_name').innerText = btn.dataset.patientName;
            document.getElementById('modal_change_current_case_holder').innerText = btn.dataset.currentCaseHolder;
            // ✅ Password input clear
            const passwordInput = document.getElementById('modal_change_case_holder_password');
            passwordInput.value = '';
            passwordInput.classList.remove('is-invalid');

            // ✅ Password error text clear
            document.querySelector('.change_case_holder_password_error').innerText = '';
        }
    });

    function getPatientTreatmentPlanStatus(status) {
        const statusMap = {
            'In Progress': 'badge-soft-primary',
            'Production': 'badge-soft-success',
            'Waiting Staff Review': 'badge-soft-warning',
            'Waiting Lab Review': 'badge-soft-warning',
            "Waiting Dr's Review": 'badge-soft-warning',
            "Waiting for Review from Advisor": 'badge-soft-warning',
            'Treatment Plan Completed': 'badge-soft-info',
            'Shipped': 'badge-soft-info',
            'Cancelled By Lab': 'badge-soft-warning',
            'Cancelled': 'badge-soft-danger',
            'Pending': 'badge-soft-secondary',
        };
        return statusMap[status] ?? 'badge-soft-secondary';
    }

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.change-status');
        if (!btn) return;

        document.getElementById('modal_change_status_patient_id').value = btn.dataset.patientId;
        document.getElementById('modal_change_status_patient_name').innerText = btn.dataset.patientName;

        const statusText = btn.dataset.currentStatus;
        const statusEl = document.getElementById('modal_change_status_current_status');

        statusEl.innerText = statusText;
        statusEl.className = 'badge ' + getPatientTreatmentPlanStatus(statusText);

        // ✅ Password input clear
        const passwordInput = document.getElementById('modal_change_status_password');
        passwordInput.value = '';
        passwordInput.classList.remove('is-invalid');

        // ✅ Password error text clear
        document.querySelector('.password_error').innerText = '';
    });


</script>
@endsection
