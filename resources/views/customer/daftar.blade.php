@extends('layouts.admin.navfootbar')
@section('content')
    <div class="heading heading-page">
        Daftar
    </div>
    <div class="login-form">
        <div class="form-box-double">
            <div class="form-box">
                <label>Nama Lengkap</label>
                <input type="text" placeholder="Nama Lengkap Kamu">
            </div>
            <div class="form-box">
                <label>Email</label>
                <input type="email" placeholder="Email Kamu">
            </div>
            <div class="form-box">
                <label>Nomor Telepon</label>
                <input type="number" placeholder="Nomor Telepon Kamu">
            </div>
            <div class="form-box">
                <label>Perusahaan(Opsional)</label>
                <input type="number" placeholder="Perusahaan Kamu">
            </div>
            <div class="form-box">
                <label>Kata Sandi</label>
                <input type="password" placeholder="Kata Sandi Kamu">
            </div>
            <div class="form-box">
                <label>Ulangi Kata Sandi</label>
                <input type="password" placeholder="Ulangi Kata Sandi Kamu">
            </div>
        </div>
        <button>Daftar</button>

    </div>
@endsection
