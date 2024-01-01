<!-- File: resources/views/home.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Home</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
     <!-- Fonts -->
     <link rel="preconnect" href="https://fonts.bunny.net">
     <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

     <!-- Scripts -->
     @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* File: public/css/style.css */

body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.container {
    width: 80%;
    margin: 0 auto;
}

header {
    background-color: #333;
    color: #fff;
    padding: 20px 0;
    text-align: center;
}

header h1 {
    margin: 0;
}

.features {
    background-color: #f4f4f4;
    padding: 40px 0;
}

.feature {
    text-align: center;
    margin-bottom: 40px;
}

.feature img {
    width: 80px;
    height: 80px;
}

footer {
    background-color: #333;
    color: #fff;
    padding: 20px 0;
    text-align: center;
}

    </style>
</head>
<body>
    @include('layouts.navigation')
    <section class="features">
        <div class="container">
            <div class="feature">
                <img src="{{ asset('images/icon1.png') }}" alt="Icon 1">
                <h2>Fitur 1</h2>
                <p>Deskripsi singkat tentang fitur ini.</p>
            </div>
            <div class="feature">
                <img src="{{ asset('images/icon2.png') }}" alt="Icon 2">
                <h2>Fitur 2</h2>
                <p>Deskripsi singkat tentang fitur ini.</p>
            </div>
            <div class="feature">
                <img src="{{ asset('images/icon3.png') }}" alt="Icon 3">
                <h2>Fitur 3</h2>
                <p>Deskripsi singkat tentang fitur ini.</p>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2023 Nama Perusahaan. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
