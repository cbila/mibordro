<x-mail::message>

mibordro.com sitesinde iletişim formu doludurulmuştur:

Adı: {{ $name }}

Email: {{ $email }}

Konu: {{ $subject }}

Mesaj: 

{{ $message }}



{{ config('app.name') }}
</x-mail::message>
