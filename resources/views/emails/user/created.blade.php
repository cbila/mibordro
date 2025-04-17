<x-mail::message>
# mibordro.com Platformuna hoşgeldiniz.


Kullanıcı adınız sistemde kayıtlı e-posta adresinizdir.

Şifreniz sistem tarafından üretilmiştir. Sisteme giriş yaptıktan sonra kullnanıcı menüsünden 
Profilimi Düzenle seçeneğinden değiştirmeniz önerilir.


Şifreniz: {{ $password }}

<x-mail::button :url="'https://mibordro.com/user/user.id'">
Hesabıma git
</x-mail::button>

Teşekkürlerimizle,<br>
{{ config('app.name') }}
</x-mail::message>
