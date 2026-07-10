<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manual Pengguna</title>
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
        <h1>Manual Pengguna</h1>
        <p>
            Bagaimana Untuk Menggunakan Sistem MyPetroleum?

            <br><br>Para syarikat bunker boleh mengakses Sistem MyPetroleum (Sistem Maklumat Bunker) menggunakan aplikasi browser laman sesawang (Sila gunakan Chrome untuk paparan terbaik) dengan melayari url <a href="http://mypetroleum.customs.gov.my/" target="_blank">http://mypetroleum.customs.gov.my/</a>

            <br><br>Untuk pemohon baharu, sila klik pada pautan “BORANG ID" untuk mendapatkan  Borang ID MyPetroleum. Sila isikan semua maklumat yang diperlukan di dalam borang tersebut dan emel kepada pentadbir sistem seperti di alamat di butang ‘HUBUNGI KAMI”. Permohonan anda akan diproses dan jika diluluskan, anda akan diberikan kata nama dan kata laluan untuk log masuk ke dalam sistem ini dalam tempoh 2 hari. Sila rujuk emel anda untuk sebarang maklumat berkaitan permohonan yang telah dilaksanakan.

        </p>
    </main>
</body>
</html>
