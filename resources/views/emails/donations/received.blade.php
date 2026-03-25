<x-mail::message>
# Thank you for your support, {{ $donation->user->name ?? 'Friend' }}!

Your generous contribution of **KES {{ number_format($donation->amount) }}** to the campaign **"{{ $donation->campaign->title }}"** has been successfully received.

Your support makes a real difference. We are incredibly grateful for your kindness and commitment to this cause.

**Transaction Details:**
- **Amount:** KES {{ number_format($donation->amount) }}
- **Campaign:** {{ $donation->campaign->title }}
- **Reference:** {{ $donation->transaction_reference }}
- **Date:** {{ $donation->created_at->format('M d, Y H:i A') }}

<x-mail::button :url="route('campaigns.show', $donation->campaign)">
View Campaign Progress
</x-mail::button>

If you have any questions, feel free to reply to this email or contact our support team.

With gratitude,<br>
The {{ config('app.name') }} Team
</x-mail::message>
