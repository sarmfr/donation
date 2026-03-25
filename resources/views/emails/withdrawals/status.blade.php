<x-mail::message>
# Withdrawal Update: {{ ucfirst($withdrawal->status) }}

Hello {{ $withdrawal->campaign->user->name }},

This is an update regarding your withdrawal request for the campaign **"{{ $withdrawal->campaign->title }}"**.

**Status:** {{ ucfirst($withdrawal->status) }}
**Amount:** KES {{ number_format($withdrawal->amount) }}
**M-Pesa Number:** {{ $withdrawal->recipient_phone }}
@if($withdrawal->mpesa_reference)
**M-Pesa Reference:** {{ $withdrawal->mpesa_reference }}
@endif

@if($withdrawal->status === 'pending')
Your request has been received and is currently being processed by our team. We'll notify you once the funds have been disbursed.
@elseif($withdrawal->status === 'completed')
Great news! Your withdrawal request has been approved and the funds have been sent to your M-Pesa number.
@endif

<x-mail::button :url="route('my-withdrawals')">
View My Withdrawals
</x-mail::button>

If you have any questions, please contact our support team.

Thanks,<br>
The {{ config('app.name') }} Team
</x-mail::message>
