@extends('layouts.admin.navfootbar')
@section('content')
<div class="container">
    <div class="heading heading-page">
        Pelanggan
    </div>

    <div class="pesanan-layout-top pesanan-layout-top-pelanggan">
        <div class="pesanan-layout-top__box">
            <div class="search-box-page search-box-page-pelanggan">
                <input type="text" placeholder="Cari Pelanggan">
                <iconify-icon icon="ic:round-search"></iconify-icon>
            </div>
        </div>
        <div class="pesanan-layout-top__box">
            <button class="btn-blue-download">
                <iconify-icon icon="file-icons:microsoft-excel"></iconify-icon> Download Excel
            </button>
        </div>
    </div>

    <div class="table-layout">
        <table>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Nomor Telepon</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Muhamad Rafli</td>
                <td>0895610411991</td>
                <td>muhamadrafli6207@gmail.com</td>
                <td>Jl Patrakomala no.49 Merdeka, Kec. Sumur Bandung, Kota Bandung, Jawa Barat 40113</td>
                <td><button class="btn-edit" onclick="togglePopup('editCustomer')"><iconify-icon icon="ep:edit"></iconify-icon> Edit</button></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Tedy Syach</td>
                <td>087866291056</td>
                <td> Tedy.syach70@gmail.com</td>
                <td>Perum Alexandria No.13, Jl. Cipicung, Tugujaya, Kec. Cihideung, Kota. Tasikmalaya, Jawa Barat 46126</td>
                <td><button class="btn-edit" onclick="togglePopup('editCustomer')"><iconify-icon icon="ep:edit"></iconify-icon> Edit</button></td>
            </tr>
        </table>
    </div>
</div>
<div class="popup hide-popup" id="editCustomer">
    <div class="main-popup">
        <div class="overlay-popup" onclick="togglePopup('editCustomer')"></div>
        <div class="layout-popup">
            <div class="popup-form-box">
                <div class="heading-popup">
                    <h3>Edit Pelanggan</h3>
                    <iconify-icon icon="mingcute:close-line" onclick="togglePopup('editCustomer')"></iconify-icon>
                </div>
                <div class="content-popup">
                    <div class="form-box">
                        <label for="">Nama Pelanggan</label>
                        <input type="text" placeholder="Nama Lengkap Pelanggan">
                    </div>
                    <div class="form-box">
                        <label for="">Nomor Telepon</label>
                        <input type="text" placeholder="Nomor Telepon Pelanggan">
                    </div>
                    <div class="form-box">
                        <label for="">Email</label>
                        <input type="text" placeholder="Email Pelanggan">
                    </div>
                    <div class="form-box">
                        <label for="alamat">Alamat Lengkap</label>
                        <textarea rows="3" placeholder="Alamat Lengkap Pelanggan" required></textarea>
                    </div>
                    <div class="informasi-layout-button__form informasi-layout-button__form-single">
                        <button type="submit">Simpan Pelanggan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
