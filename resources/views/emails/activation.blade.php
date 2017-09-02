<p>Halo</p>
<p>Seseorang baru saja telah mendaftarkan akunnya dengan email ini</p>
<p>Jika orang tersebut memang kamu, silahkan verifikasi pendaftaran kamu di NovelBaru dengan mengklik tombol dibawah ini.</p>

@component('mail::button', ['url' => route('index.activation', ['token' => $aktivasi->token]), 'color' => 'green'])
Aktifkan Akun
@endcomponent