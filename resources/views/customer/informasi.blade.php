@extends('layouts.admin.navfootbar')
@section('content')
<div>
    <div class="heading heading-page">
        Detail Informasi
    </div>
    <div class="information-layout container">
        <div class="login-box-layout">
            <form action="/confirmshipping" method="post">@csrf
                <div class="signup-layout">
                    <div class="form-box">
                        <label for="nama-lengkap">Nama Lengkap</label>
                        <input type="text" name="name" placeholder="Nama Lengkap Kamu" required>
                    </div>
                    <div class="form-box">
                        <label for="no-telp">Nomor Telepon</label>
                        <input type="text" name="no_telp" placeholder="Nomor Telepon" required>
                    </div>
                    <div class="form-box">
                        <label for="kelurahan">Kelurahan</label>
                        <input type="text" name="kelurahan" placeholder="Kelurahan Kamu" required>
                    </div>
                    <div class="form-box">
                        <label for="provinsi">Provinsi</label>
                        <div class="select-style">
                            <select name="province_code" id="provinsi" required>
                                <option value="" default>Choose Province</option>
                                @foreach ($prov as $prov)
                                <option value="{{ $prov['province_id'] }}">{{ $prov['province'] }}</option>
                                @endforeach
                            </select>
                            <iconify-icon icon="octicon:chevron-down-12"></iconify-icon>
                        </div>
                    </div>
                    <div class="form-box">
                        <label for="city">City</label>
                        <div class="select-style">
                            <select name="city_code" id="city">
                                <option value="">Choose City</option>
                            </select>
                            <iconify-icon icon="octicon:chevron-down-12"></iconify-icon>
                        </div>
                    </div>
                    <div class="form-box">
                        <label for="subdistrict">Kecamatan</label>
                        <div class="select-style">
                            <select name="subdistrict_code" id="subdistrict">
                                <option value="">Choose Subdistrict</option>
                            </select>
                            <iconify-icon icon="octicon:chevron-down-12"></iconify-icon>
                        </div>
                    </div>
                </div>
                <div class="form-box">
                    <label for="alamat">Alamat Lengkap</label>
                    <textarea name="full_address" placeholder="Isi Alamat Lengkap Kamu" rows="3" required></textarea>
                </div>
                {{-- <div>
                    <label class="remind">
                        <input type="checkbox" required>
                        <span class="checkmark"></span>
                        Simpan data ini untuk nanti
                    </label>
                </div> --}}
                <div class="informasi-layout-button__form">
                    <a href="{{ url('cart') }}"><button class="back__btn">Kembali ke Keranjang</button></a>
                    {{-- <input type="hidden" name="_token" value="NSTpmrapElixwARMTdRA4Us3StxIyqLkUSWGgGWx"> --}}
                    <button type="submit">Opsi Pengiriman</button>
                </div>
            </form>
        </div>
        <div class="sidebar-informasi-layout">
            <div class="sidebar-informasi-overflow">
                @foreach (session('cart') as $cart)
                <div class="sidebar-informasi-box">
                    <div class="sidebar-informasi__image">
                        <img src="images/1.jpg" alt="">
                    </div>
                    <div class="sidebar-informasi__desc">
                        <h4>{{ $cart['nama'] }}</h4>
                        <span>{{ $cart['size'] }} {{ $cart['color'] }}</span>
                        <span>{{ $cart['qty'] }} Pcs</span>
                        <span class="price-mobile-sidebar">Rp. {{ number_format($cart['price']) }} ,-</span>
                    </div>
                    <div class="sidebar-informasi__price">
                        <span>Rp. {{ number_format($cart['price']) }} ,-</span>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="sidebar-informasi__total">
                <div class="sidebar-informasi__total-box">
                    <span>Diskon</span>
                    <span>-</span>
                </div>
            </div>
            <div class="sidebar-informasi__total">
                <div class="sidebar-informasi__total-box">
                    <span>Kode Kupon</span>
                    <input type="text" class="input-focus">
                </div>
            </div>
            {{-- <div class="sidebar-informasi__total">
                <div class="sidebar-informasi__total-box">
                    <span>Kode Referal</span>
                    <input type="text" class="input-focus">
                </div>
            </div> --}}
            <div class="sidebar-informasi__total sidebar-informasi__total-main">
                <div class="sidebar-informasi__total-box">
                    <span>Total</span>
                    <span>Rp. 121.000 ,-</span>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#provinsi').on('change', function () {
            var selectedProvinceId = $(this).val();
        // Dapatkan token CSRF dari meta tag
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Atur header X-CSRF-TOKEN
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });

        // Kirim permintaan AJAX ke server Laravel
        $.ajax({
            type: 'POST',
            url: '/select-province', // Ganti dengan URL yang sesuai
            data: {
                selectedProvinceId: selectedProvinceId
            },
            success: function (data) {
                $('#city').empty();

                $.each(data.rajaongkir.results, function (index, city) {
                    $('#city').append($('<option>', {
                        value: city.city_id,
                        text: city.type + ' ' + city.city_name
                        }));
                    });
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#city').on('change', function () {
            var selectedCityId = $(this).val();

            // Dapatkan token CSRF dari meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Atur header X-CSRF-TOKEN
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            // Kirim permintaan AJAX ke server Laravel
            $.ajax({
                type: 'POST',
                url: '/select-city', // Ganti dengan URL yang sesuai
                data: {
                    selectedCityId: selectedCityId
                },
                success: function (data) {
                // Bersihkan elemen <select> dari opsi yang ada
                $('#subdistrict').empty();


                $.each(data.rajaongkir.results, function (index, subdistrict) {
                        $('#subdistrict').append($('<option>', {
                            value: subdistrict.subdistrict_id,
                            text: 'Kecamatan '+subdistrict.subdistrict_name
                        }));
                    });
            }

            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#logoutForm').on('submit', function (e) {
            e.preventDefault(); // Menghentikan pengiriman form

            Swal.fire({
                title: 'Are you sure?',
                text: "You will log out now!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Logout!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna mengonfirmasi, kirimkan form
                    $('#logoutForm').off('submit'); // Matikan event handler agar tidak ada konfirmasi tambahan
                    $('#logoutForm').submit(); // Kirim form logout setelah konfirmasi
                }
            });
        });
    });
</script>
@endsection
