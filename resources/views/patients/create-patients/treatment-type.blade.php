<style>
    /* Auto adjust treatment type height without vertical scrollbar */
    #pill-tab-li-treatment-type-div {
        transition: all 0.2s ease;
    }

    .treatment-plan-col {
        /* Fluid responsive height based on viewport */
        height: clamp(260px, calc(100dvh - 390px), 580px);
        min-height: 250px;
        transition: height 0.15s ease-out;
    }

    .treatment-plan-col .plan-box {
        padding: clamp(10px, 1.8vh, 20px) !important;
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        height: 100%;
    }

    .treatment-info-overlay {
        border-radius: 10px;
        background-color: #80C6C7;
        padding: clamp(8px, 1.3vh, 15px);
        min-height: clamp(115px, 16vh, 160px);
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: justify;
    }

    .treatment-info-overlay .plan-title {
        font-size: clamp(1rem, 1.35vh, 1.25rem) !important;
        font-weight: 600;
        margin-bottom: clamp(4px, 0.6vh, 8px) !important;
        line-height: 1.2;
    }

    .treatment-info-overlay .treatment-desc-title {
        font-size: clamp(0.8rem, 1.15vh, 1.05rem) !important;
        line-height: 1.25;
        color: #209194 !important;
        text-align: center !important;
        margin-bottom: 0 !important;
    }

    .treatment-info-overlay .pricing-btn-container {
        margin-top: clamp(6px, 1vh, 12px) !important;
    }

    .treatment-buttons-bar {
        margin-top: clamp(8px, 1.2vh, 16px) !important;
        margin-bottom: 0 !important;
    }

    @media (max-width: 767.98px) {
        .treatment-plan-col {
            height: clamp(190px, 30vh, 260px);
            min-height: 180px;
            margin-bottom: 12px;
        }
    }

    @media (max-height: 700px) and (min-width: 768px) {
        .treatment-plan-col {
            height: clamp(240px, calc(100dvh - 340px), 360px);
        }
    }
</style>

{{-- Patient  treatment type Start --}}
<div class="tab-pane fade {{ (isset($activeTab) && $activeTab == 'pill-tab-li-treatment-type-div') ? 'show active' : '' }}" id="pill-tab-li-treatment-type-div" role="tabpanel">
    <div class="container py-2">
        <div class="row g-4">
            <div class="col-12 col-md-6 treatment-plan-col">
                <div class="plan-box d-flex flex-column justify-content-end" data-plan-type="treatment" style="background-image: url('{{ asset('public') }}/assets/Treatment-Plan-Service-light.webp'); background-size: cover; background-position: center; " onclick="selectPlan(this)">

                    <div class="treatment-info-overlay">
                        <div class="plan-title text-center text-white">Treatment Planning Service</div>
                        <h4 class="page-title treatment-desc-title">
                            Precise Staging: From Patient's Scans to Print-Ready STL Files
                        </h4>

                        <!-- Centered Button -->
                        <div class="d-flex justify-content-center pricing-btn-container">
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#serviceModal">
                                Pricing Info
                            </button>
                        </div>
                    </div>

                    <input type="radio" name="plan" class="d-none" value="1"
                        @if(!empty($patient->treatment_type) && $patient->treatment_type == 1)
                            checked="checked"
                        @elseif($change_plan == 'false')
                            checked="checked"
                        @endif
                    >
                </div>
            </div>

            <div class="col-12 col-md-6 treatment-plan-col">
                <div class="plan-box d-flex flex-column justify-content-end"  data-plan-type="aligners" style="background-image: url('{{ asset('public') }}/assets/Aligners-light.webp'); background-size: cover; background-position: center; " @if($change_plan == 'true') onclick="selectPlan(this)" @endif>

                    <div class="treatment-info-overlay">
                        <div class="plan-title text-center text-white">Aligners Full-Service</div>
                        <h4 class="page-title treatment-desc-title">
                            Digital Planning and Precision Production
                        </h4>
                    </div>

                    <input type="radio" name="plan" class="d-none" value="2"
                        @if(!empty($patient->treatment_type) && $patient->treatment_type == 2 && $change_plan == 'true')
                            checked="checked"
                        @endif>
                </div>
            </div>
        </div>
    </div>

    <div class="treatment-buttons-bar text-end">
        <button class="btn btn-primary btn-sm waves-effect waves-light px-3 previous-tab" data-target="#pill-tab-li1">Previous</button>
        <button  class="btn btn-primary btn-sm waves-effect waves-light px-3"  id="submit-treatment-plan" @if(empty($patient->treatment_type)) disabled="disabled" @endif>
            Next
        </button>
    </div>
</div>
{{-- Patient  treatment type End --}}

<script>
    (function () {
        function autoAdjustTreatmentPlanHeight() {
            const tabPane = document.getElementById('pill-tab-li-treatment-type-div');
            if (!tabPane) return;

            const planCols = tabPane.querySelectorAll('.treatment-plan-col');
            if (!planCols.length) return;

            const isTabActive = tabPane.classList.contains('active') || tabPane.classList.contains('show');
            const container = tabPane.querySelector('.container');
            const tabContent = document.getElementById('pill-myTabContent');
            const buttonsBar = tabPane.querySelector('.treatment-buttons-bar');

            const windowHeight = window.innerHeight;
            const windowWidth = window.innerWidth;

            // Measure top offset relative to viewport
            let contentTop = 0;
            if (isTabActive && container && container.offsetParent !== null) {
                contentTop = container.getBoundingClientRect().top;
            } else if (tabContent && tabContent.offsetParent !== null) {
                contentTop = tabContent.getBoundingClientRect().top + 16;
            } else {
                // Approximate fallback for top bar + title + tabs
                contentTop = 230;
            }

            // Measure space needed below the cards
            const btnHeight = (buttonsBar && buttonsBar.offsetHeight > 0) ? buttonsBar.offsetHeight : 38;
            
            // Footer height
            const footer = document.querySelector('.footer');
            const footerHeight = (footer && window.getComputedStyle(footer).display !== 'none') ? footer.offsetHeight : 55;

            // Bottom space: buttons height + card body padding + footer + extra safety margin
            const bottomReserved = btnHeight + footerHeight + 40;

            let targetHeight = windowHeight - contentTop - bottomReserved;

            if (windowWidth >= 768) {
                // Desktop / Laptop: cards side-by-side
                targetHeight = Math.max(250, Math.min(Math.floor(targetHeight), 580));
            } else {
                // Mobile / Small screen: stacked cards
                targetHeight = Math.max(180, Math.min(Math.floor((windowHeight - contentTop - bottomReserved) / 2), 280));
            }

            planCols.forEach(col => {
                col.style.height = targetHeight + 'px';
            });
        }

        // Adjust on DOMContentLoaded and full load
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', autoAdjustTreatmentPlanHeight);
        } else {
            autoAdjustTreatmentPlanHeight();
        }
        window.addEventListener('load', autoAdjustTreatmentPlanHeight);

        // Adjust on window resize
        let resizeTimer;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(autoAdjustTreatmentPlanHeight, 50);
        });

        // Adjust when switching to treatment-type tab (Bootstrap 5 tab events)
        const tabTrigger = document.querySelector('a[href="#pill-tab-li-treatment-type-div"]');
        if (tabTrigger) {
            tabTrigger.addEventListener('shown.bs.tab', function () {
                setTimeout(autoAdjustTreatmentPlanHeight, 10);
            });
        }

        // Also listen for any tab clicks or changes via jQuery if present
        if (typeof $ !== 'undefined') {
            $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function () {
                setTimeout(autoAdjustTreatmentPlanHeight, 10);
            });
        }
    })();
</script>
