@foreach ($comments as $c)
    @if($c->comment || $c->attachments != null)
    <div class="d-flex mt-3">
        <div class="flex-1 ms- 2 fs--1">
            <p class="mb-1 bg-gradient bg-light rounded-3 p-2"><a class="fw-semi-bold" href="javascript:void(0);">
                    @if($c->from_role == 'doctor') DOCTOR @else {{ $c->first_name }}
                    {{ $c->last_name }} @endif </a> {!! $c->comment !!}</p>
                     <div class="px-2">
                    @if($c->attachments!='')
                      <?php  $att=explode(',',$c->attachments);?>
                        @foreach($att as $key=>$a)
                        <a href="{{asset('file')}}/{{$a}}" target="_blank" ><i class="fa fa-download me-2"></i>Attachment {{++$key}}</a>
                        @endforeach
                    @endif
                </div>
            <div class="px-2"> {{ date('Y-m-d H:i A', strtotime($c->created_at)) }} </div>
        </div>
    </div>
    @endif
@endforeach
