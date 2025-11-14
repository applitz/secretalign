@component('mail::message')
# Hi, a new task has been added to you. New task details are as follows:

@if(!empty($comment))
{!! $comment !!} {{-- CKEditor HTML will render --}}
@endif

@component('mail::button', ['url' => url('/home')])
View Tasks
@endcomponent

Thank you for using **Secret Clear Aligner System**.
<hr>

@endcomponent
