{{-- <div class="js-cookie-consent cookie-consent fixed bottom-0 inset-x-0 pb-2">
    <div class="max-w-7xl mx-auto px-6">
        <div class="p-2 rounded-lg bg-yellow-100">
            <div class="flex items-center justify-between flex-wrap">
                <div class="w-0 flex-1 items-center hidden md:inline">
                    <p class="ml-3 text-black cookie-consent__message">
                        {!! trans('cookie-consent::texts.message') !!}
                    </p>
                </div>
                <div class="mt-2 flex-shrink-0 w-full sm:mt-0 sm:w-auto">
                    <button class="js-cookie-consent-agree cookie-consent__agree cursor-pointer flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium text-yellow-800 bg-yellow-400 hover:bg-yellow-300">
                        {{ trans('cookie-consent::texts.agree') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div> --}}


<div class="toast notice shadow-none bg-transparent " id="cookie-notice" role="alert" data-options='{"autoShow":true,"autoShowDelay":0,"showOnce":true,"cookieExpireTime":7200000}' data-autohide="false" aria-live="assertive" aria-atomic="true" style="max-width:35rem">
  <div class="toast-body my-3 ms-0 ms-md-5">
<div class="card shadow-lg">
              <div class="card-body">
                <div class="d-flex">
                  <div class="pe-3"><img src="{{asset('public/dashboard')}}/assets/img/icons/cookie-1.png" width="40" alt="cookie"></div>
                  <div>
                    <p>{!! trans('cookie-consent::texts.message') !!}</p>
                    <button class="btn btn-sm btn-primary me-3 js-cookie-consent-agree" type="button" data-bs-dismiss="toast" aria-label="Close">Okay</button>
                    {{-- <a class="learn-more me-3" href="javascript:void(0);">Learn more<svg class="svg-inline--fa fa-chevron-right fa-w-10 ms-1 fs--2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"></path></svg><!-- <span class="fas fa-chevron-right ms-1 fs--2"></span> Font Awesome fontawesome.com --></a> --}}
                  </div>
                </div>
              </div>
            </div>
  </div>
</div>

