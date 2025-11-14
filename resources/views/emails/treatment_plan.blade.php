@component('mail::message')
# Dear Doctor,

The treatment plan for your patient, **{{ $first_name }} {{ $last_name }}** is now ready for your review and approval.
You can view your tasks and order status here:

Please review the plan at your convenience.
If you have any modifications, please feel free to make them.
Kindly provide a comment whenever you make any changes to the plan.

@component('mail::button', ['url' => 'https://secretalign-user.com/home'])
View Dashboard
@endcomponent

@if(!empty($comment))
### Added Comment:
{!! $comment !!} {{-- renders CKEditor HTML --}}
@endif

Best regards,
**SECRET Aligners Team**

Thank you for choosing Secret Clear Aligner System!
<hr>

If you're having trouble clicking the "View Dashboard" button, copy and paste the URL below into your web browser: <a href="https://secretalign-user.com/home">https://secretalign-user.com/home</a>
@endcomponent
