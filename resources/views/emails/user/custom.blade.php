

<x-mail::message>

Sayın {{ $user->name }},


{{ $message }}


Teşekkürlerimizle,<br>
{{ config('app.name') }}
</x-mail::message>
