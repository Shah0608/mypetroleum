<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hubungi Kami</title>
    <link rel="stylesheet" href="{{ asset('css/mypetroleum.css') }}">
</head>
<body>
    <header class="mp-header">
        <div class="mp-left">
            <img src="{{ asset('images/kastam-diraja-malaysia-seeklogo.png') }}" alt="Kastam">
            <img src="{{ asset('images/logo_mypetroleum-removebg-preview.png') }}" alt="MyPetroleum">
        </div>
        <nav class="mp-nav">
            <a href="{{ url('/') }}">Utama</a>
            <a href="{{ route('about') }}">Mengenai MyPetroleum</a>
            <a href="{{ route('panduan.58a') }}">Panduan Butiran 58 A</a>
            <a href="{{ route('manual') }}">Manual Pengguna</a>
            <a href="{{ route('contact') }}">Hubungi Kami</a>
            <a href="{{ route('login') }}" class="primary">Daftar Masuk</a>
        </nav>
    </header>

    <main class="mp-container">
        <h1>Hubungi Kami</h1>
            <p>
            Para Syarikat Bunker boleh menghubungi maklumat yang tertera jika terdapat sebarang keraguan atau persoalan yang mungkin timbul.
            <br>
            <br>Jabatan Kastam Diraja Malaysia,
            <br>Wisma Kastam Ayer keroh,
            <br>75450 Melaka
            <br>06-232 5855 (Talian Umum)

            <br><br>Meja bantuan :

            <br>Tn Razidi Bin Abu
                    <br>Penolong Pengarah Kastam 
                    <br>emel : razidi.abu@customs.gov.my

            <br><br>En Hairulazuan Bin Hairullah
                    <br>Pegawai Kastam Tinggi
                    <br>Emel : hairulazuan.hairullah@customs.gov.my

        </p>
    </main>
</body>
</html>
