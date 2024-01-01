@extends('layouts.admin.navfootbar')
@section('content')
    <div class="heading heading-page">
        Masuk
    </div>
    <div class="login-form">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-box-double">
            <div class="form-box">
                <label>Email</label>
                <input type="email" name="email" placeholder="Email Kamu">
            </div>
            <div class="form-box">
                <label>Kata Sandi</label>
                <input type="password" name="password" placeholder="Kata Sandi Kamu">
            </div>
        </div>
        <button>Masuk</button>
    </form>

        <div class="link-login">
        {{-- <a href="">Lupa Password?</a> --}}
        @if (Route::has('password.request'))
        <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
            {{ __('Forgot your password?') }}
        </a>
    @endif
        <span>Belum Punya Akun? <a href="daftar.php"><b>Daftar</b></a></span>
        </div>

    </div>
@endsection
