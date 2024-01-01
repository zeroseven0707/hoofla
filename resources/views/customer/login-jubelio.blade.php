@extends('layouts.admin.navfootbar')
@section('content')
    <div class="heading heading-page">
        Masuk
    </div>
    <div class="login-form">
    <form method="POST" action="{{ route('loginjubelio') }}">
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
    </div>
@endsection
