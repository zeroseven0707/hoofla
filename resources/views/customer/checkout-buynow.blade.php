@extends('layouts.admin.navfootbar')
@section('content')
<div>
    <div class="heading heading-page">
        Periksa Pembelian
    </div>
    <div class="information-layout container">
        <div class="login-box-layout">
            <form action="{{ url('/post-pesanan-buynow') }}" method="post">
                @csrf
                <div class="form-box">
                    <div class="label-double">
                        <label>Nama Pelanggan</label>
                        <div class="create-link">
                            <a href="#" onclick="togglePopup('createCustomer')">+Tambah Pelanggan</a> | <a href="#" onclick="toggleFormCustomer()">+Alamat Saya</a>
                        </div>
                    </div>
                    <div class="select-style select-style-single">
                        <select id="customerSelect" name="pelanggan_id">
                            <option value="" selected>Pilih Pelanggan</option>
                            @foreach ($pelanggans as $pelanggan)
                            <option value="{{ $pelanggan['id'] }}">{{ $pelanggan['name'] }}</option>
                            @endforeach
                        </select>
                        <iconify-icon icon="octicon:chevron-down-12"></iconify-icon>
                    </div>
                </div>
                <!-- FORM INI MUNCUL SETELAH MEMILIH PELANGGAN ATAU MENGKLIK ALAMAT SAYA -->
                <div class="form-customer">
                    <div class="form-box">
                        <label>Penerima</label>
                        <input type="text" name="penerima" value="{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}" id="namaPenerima">
                    </div>
                    <div class="form-box-double">
                        <div class="form-box">
                            <label>Kota</label>
                            <input type="text" name="kota" value="{{ auth()->user()->city }}" id="kotaPenerima">
                        </div>
                        <div class="form-box">
                            <label>Kecamatan</label>
                            <input type="text" name="kecamatan" value="{{ auth()->user()->subdistrict }}" id="kecamatanPenerima">
                        </div>
                    </div>
                    <div class="form-box">
                        <label for="alamat">Alamat Lengkap</label>
                        <textarea name="full_address" name="alamat" rows="3" id="alamatlengkapPenerima">{{ auth()->user()->address }}
                        </textarea>
                    </div>
                    <label for="" class="label-single">Pilih Ekspedisi</label>
                    <div class="form-box__shipping">
                        {{-- foreach disini --}}
                    @foreach ($ongkos as $item)
                    @foreach ($item['costs'] as $detail)
                    <label class="shipping-radio" id="shipping">
                        <input type="radio" name="cost" value="{{ $detail['service'] }}" checked/>
                        <span>
                            <div class="heading-shipping-method">
                                <h3>JNE -  {{ $detail['service'] }} ({{ $detail['description'] }})</h3>
                                @foreach ($detail['cost'] as $harga)
                                <p>{{ $harga['etd'] }} Days</p>
                                <p class="price-mobile-sidebar">Rp. {{ number_format($harga['value']) }} ,-</p>
                            </div>
                            <div class="price-shipping">
                                <h5>Rp. {{ number_format($harga['value']) }} ,-</h5>
                            </div>
                            @endforeach
                        </span>
                    </label>
                    @endforeach
                    @endforeach
                    {{-- <label class="shipping-radio" id="shipping">
                    </label> --}}
                    {{-- endforeach disini --}}
                    </div>
                </div>
                {{-- <div class="form-box">
                    <div class="label-double">
                        <label>Nama Gudang</label>
                    </div>
                    <div class="select-style select-style-single">
                        <select>
                            <option value="" selected>Pilih Gudang</option>
                            <option value="Gudang Surabaya">Gudang Surabaya</option>
                            <option value="Gudang Bandung">Gudang Bandung</option>
                            <option value="Gudang Jakarta">Gudang Jakarta</option>
                        </select>
                        <iconify-icon icon="octicon:chevron-down-12"></iconify-icon>
                    </div>
                </div> --}}
                <div class="form-box">
                    <div class="label-double-second label-double">
                        <label for="alamat">Catatan</label>
                        <input type="file" id="file-input" name="file-input" onchange="updateFileName()" />
                        <label id="file-input-label" for="file-input">Upload File <iconify-icon icon="material-symbols:upload-sharp"></iconify-icon></label>
                    </div>
                    <textarea name="alamat_lengkap" rows="3" name="catatan" placeholder="Isi catatan disini..." required></textarea>
                </div>
                <div>
                    <label class="remind">
                        <input type="checkbox" id="dropshipperCheckbox" name="isDropshipper">
                        <span class="checkmark"></span>
                        Kirim Sebagai Dropshipper
                    </label>
                </div>
                <div class="form-box form-box-dropshipper" id="menuLayoutMobile">
                    <div class="label-double">
                        <label>Dropshipper</label>
                        <div class="create-link">
                            <a href="#" onclick="togglePopup('createDropshipper')">+Tambah Dropshipper</a>
                        </div>
                    </div>
                    <div class="select-style select-style-single">
                        <select name="dropshipper">
                            <option value="" selected disabled>Pilih Dropshipper</option>
                            @foreach ($dropshippers as $dropshipper)
                            <option value="{{ $dropshipper['id'] }}">{{ $dropshipper['name'] }}</option>
                            @endforeach
                        </select>
                        <iconify-icon icon="octicon:chevron-down-12"></iconify-icon>
                    </div>
                </div>
                <div class="informasi-layout-button__form informasi-layout-button__form-shipping">
                    <a href="/cart"><button class="back__btn">Kembali ke Informasi</button></a>
                    <button type="submit">Lanjutkan Pembayaran</button>
                </div>
            </div>
            <div class="sidebar-informasi-layout">
                <div class="sidebar-informasi-overflow">
                {{-- @foreach (session('cart') as $cart) --}}
                <div class="sidebar-informasi-box">
                    <div class="sidebar-informasi__image">
                        <img src="images/1.jpg" alt="">
                        {{-- <div>Komisi {{  ($cart['commission']) }}% (Rp {{ number_format($cart['rpCommission']) }},-)</div> --}}
                    </div>
                    <div class="sidebar-informasi__desc">
                        <h4>{{ session('buynow')['nama'] }}</h4>
                        <span>{{ session('buynow')['size'] }} {{ session('buynow')['color'] }}</span>
                        <span>{{ session('buynow')['qty'] }} Pcs</span>
                        <span class="price-mobile-sidebar">Rp. {{ number_format(session('buynow')['price']) }} ,-</span>
                    </div>
                    <div class="sidebar-informasi__price">
                        <span>Rp. {{ number_format(session('buynow')['price']) }} ,-</span>
                    </div>
                </div>
                {{-- @endforeach --}}
            </div>
            <div class="sidebar-informasi__total">
                <div class="sidebar-informasi__total-box">
                    <span>Berat</span>
                    <span>{{ session('buynow')['package_weight'] }} Kg</span>
                </div>
            </div>
            <div class="sidebar-informasi__total">
                <div class="sidebar-informasi__total-box">
                    <span>Kode Kupon</span>
                    <input type="text" class="input-focus" name="kupon">
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
                    <span>Rp. {{ number_format(session('buynow')['price_total']) }} ,-</span>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<div class="popup hide-popup" id="createCustomer">
    <div class="main-popup">
        <div class="overlay-popup" onclick="togglePopup('createCustomer')"></div>
        <div class="layout-popup">
            <div class="popup-form-box">
                <div class="heading-popup">
                    <h3>Tambah Pelanggan</h3>
                    <iconify-icon icon="mingcute:close-line" onclick="togglePopup('createCustomer')"></iconify-icon>
                </div>
                <form action="/post-pelanggan" method="post">@csrf
                    <div class="content-popup">
                        <div class="form-box">
                            <label for="">Nama Lengkap</label>
                            <input type="text" name="name" placeholder="Nama Lengkap Pelanggan">
                        </div>
                        <div class="form-box">
                            <label for="">Nomor Telepon</label>
                            <input type="text" name="no_telp" placeholder="Nomor Telepon Pelanggan">
                        </div>
                        <div class="form-box">
                            <label for="kelurahan">Kelurahan</label>
                            <input type="text" name="kelurahan" placeholder="Kelurahan Kamu" required>
                        </div>
                        <div class="form-box">
                            <label for="">Email</label>
                            <input type="text" name="email" placeholder="Email Pelanggan">
                        </div>
                        <div class="form-box">
                            <label for="">Provinsi</label>
                            <div class="select-style select-style-single">
                                <select name="province_code" id="provinsi" required>
                                    <option value="" default>Choose Province</option>
                                    @foreach ($prov as $provs)
                                    <option value="{{ $provs['province_id'] }}">{{ $provs['province'] }}</option>
                                    @endforeach
                                </select>
                                <iconify-icon icon="octicon:chevron-down-12"></iconify-icon>
                            </div>
                        </div>
                        <div class="form-box">
                            <label for="">Kota</label>
                            <div class="select-style select-style-single">
                                <select name="city_code" id="city">
                                    <option value="">Choose City</option>
                                </select>
                                <iconify-icon icon="octicon:chevron-down-12"></iconify-icon>
                            </div>
                        </div>
                        <div class="form-box">
                            <label for="">Kecamatan</label>
                            <div class="select-style select-style-single">
                                <select name="subdistrict_code" id="subdistrict">
                                    <option value="">Choose Subdistrict</option>
                                </select>
                                <iconify-icon icon="octicon:chevron-down-12"></iconify-icon>
                            </div>
                        </div>
                        <div class="form-box">
                            <label for="">Kontak Lain</label>
                            <input type="number" name="kontak lain" placeholder="Kontak Lain Pelanggan">
                        </div>
                        <div class="form-box">
                            <label for="alamat">Alamat Lengkap</label>
                            <textarea rows="3" name="full_address" placeholder="Alamat Lengkap Pelanggan" required></textarea>
                        </div>
                        <div class="informasi-layout-button__form informasi-layout-button__form-single">
                            <button type="submit">Simpan Pelanggan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="popup hide-popup" id="createDropshipper">
    <div class="main-popup">
        <div class="overlay-popup" onclick="togglePopup('createDropshipper')"></div>
        <div class="layout-popup">
            <div class="popup-form-box">
                <div class="heading-popup">
                    <h3>Tambah Dropshipper</h3>
                    <iconify-icon icon="mingcute:close-line" onclick="togglePopup('createDropshipper')"></iconify-icon>
                </div>
                <form action="/post-dropshipper" method="post">@csrf
                    <div class="content-popup">
                        <div class="form-box">
                            <label for="">Nama Lengkap</label>
                            <input type="text" name="name" placeholder="Nama Lengkap Pelanggan">
                        </div>
                        <div class="form-box">
                            <label for="">Nomor Telepon</label>
                            <input type="text" name="no_telp" placeholder="Nomor Telepon Pelanggan">
                        </div>
                        <div class="form-box">
                            <label for="kelurahan">Kelurahan</label>
                            <input type="text" name="kelurahan" placeholder="Kelurahan Kamu" required>
                        </div>
                        <div class="form-box">
                            <label for="">Email</label>
                            <input type="text" name="email" placeholder="Email Dropshipper">
                        </div>
                        <div class="form-box">
                            <label for="">Provinsi</label>
                            <div class="select-style select-style-single">
                                <select name="province_code" id="provinsi_dropshipper" required>
                                    <option value="" default>Choose Province</option>
                                    @foreach ($prov as $provs)
                                    <option value="{{ $provs['province_id'] }}">{{ $provs['province'] }}</option>
                                    @endforeach
                                </select>
                                <iconify-icon icon="octicon:chevron-down-12"></iconify-icon>
                            </div>
                        </div>
                        <div class="form-box">
                            <label for="">Kota</label>
                            <div class="select-style select-style-single">
                                <select name="city_code" id="city_dropshipper">
                                    <option value="">Choose City</option>
                                </select>
                                <iconify-icon icon="octicon:chevron-down-12"></iconify-icon>
                            </div>
                        </div>
                        <div class="form-box">
                            <label for="">Kecamatan</label>
                            <div class="select-style select-style-single">
                                <select name="subdistrict_code" id="subdistrict_dropshipper">
                                    <option value="">Choose Subdistrict</option>
                                </select>
                                <iconify-icon icon="octicon:chevron-down-12"></iconify-icon>
                            </div>
                        </div>
                        <div class="form-box">
                            <label for="">Kontak Lain</label>
                            <input type="number" name="kontak lain" placeholder="Kontak Lain Pelanggan">
                        </div>
                        <div class="form-box">
                            <label for="alamat">Alamat Lengkap</label>
                            <textarea rows="3" name="full_address" placeholder="Alamat Lengkap Pelanggan" required></textarea>
                        </div>
                        <div class="informasi-layout-button__form informasi-layout-button__form-single">
                            <button type="submit">Simpan Dropshipper</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT UNTUK INPUT FILE --}}
<script>
    function updateFileName() {
        // Dapatkan elemen input file
        var fileInput = document.getElementById('file-input');

        // Dapatkan elemen label
        var fileInputLabel = document.getElementById('file-input-label');

        // Periksa apakah file telah dipilih
        if (fileInput.files.length > 0) {
            // Perbarui label dengan nama file
            fileInputLabel.textContent = fileInput.files[0].name;
        } else {
            // Kembali ke label asli jika tidak ada file yang dipilih
            fileInputLabel.textContent = 'Upload File';
        }
    }
</script>
{{-- SCRIPT MEMUNCULKAN FORM CUSTOMER SAAT KLIK ALAMAT SAYA --}}
<script>
    function toggleFormCustomer() {
        // Dapatkan elemen form customer
        const formCustomer = document.querySelector('.form-customer');
        // Dapatkan elemen div select-style-single
        const selectDiv = document.querySelector('.select-style-single');
        // Periksa apakah form customer sedang ditampilkan atau disembunyikan
        const isFormVisible = formCustomer.style.display === 'block';
        // Toggle kelas untuk menampilkan/sembunyikan form customer
        formCustomer.style.display = isFormVisible ? 'none' : 'block';
        // Atur properti display pada elemen selectDiv
        selectDiv.style.display = isFormVisible ? 'block' : 'none';
    }
</script>
{{-- SCRIPT UNTUK SHOW DROPSHIPPER  --}}
<script>
    const dropshipperCheckbox = document.getElementById("dropshipperCheckbox");
    const formBoxDropshipper = document.querySelector(".form-box-dropshipper");

    dropshipperCheckbox.addEventListener("change", function() {
        formBoxDropshipper.style.display = this.checked ? "flex" : "none";
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
{{-- get city and subdistrict by pelangan --}}
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
{{-- get city and subdistrict by dropshipper --}}
<script>
    $(document).ready(function () {
        $('#provinsi_dropshipper').on('change', function () {
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
                $('#city_dropshipper').empty();

                $.each(data.rajaongkir.results, function (index, city) {
                    $('#city_dropshipper').append($('<option>', {
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
        $('#city_dropshipper').on('change', function () {
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
                $('#subdistrict_dropshipper').empty();


                $.each(data.rajaongkir.results, function (index, subdistrict) {
                        $('#subdistrict_dropshipper').append($('<option>', {
                            value: subdistrict.subdistrict_id,
                            text: 'Kecamatan '+subdistrict.subdistrict_name
                        }));
                    });
            }

            });
        });
    });
</script>
{{-- JS confirmasi LOGOUT --}}
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
{{-- Select Pelanggan dan menampilkan data beserta cost nya--}}
<script>
    document.getElementById('customerSelect').addEventListener('change', function() {
    const formCustomer = document.querySelector(".form-customer");
    formCustomer.style.display = this.value ? "block" : "none";
    var customerId = this.value; // Mendapatkan ID pelanggan yang dipilih
    if (customerId) {
        // Kirim permintaan AJAX ke backend
        fetch('/get-pelanggan-info/' + customerId)
        .then(response => response.json())
        .then(data => {
            // Mengisi field dengan data informasi pelanggan yang diterima dari backend
            document.getElementById('namaPenerima').value = data.pelanggan.name;
            document.getElementById('kotaPenerima').value = data.pelanggan.city;
            document.getElementById('kecamatanPenerima').value = data.pelanggan.subdistrict;
            document.getElementById('alamatlengkapPenerima').value = data.pelanggan.address;
            // Menambahkan hasil perulangan foreach ke elemen dengan class "form-box__shipping"
            var shippingContainer = document.querySelector(".form-box__shipping");
            shippingContainer.innerHTML = ""; // Mengosongkan elemen sebelum mengisinya kembali
            data.ongkos.forEach(function(item) {
            item.costs.forEach(function(detail) {
                var label = document.createElement("label");
                label.classList.add("shipping-radio");
                var input = document.createElement("input");
                input.type = "radio";
                input.name = "cost";
                input.value = detail.service;
                input.checked = true;
                var span = document.createElement("span");
                var heading = document.createElement("div");
                heading.classList.add("heading-shipping-method");
                var h3 = document.createElement("h3");
                h3.textContent = "JNE - " + detail.service + " (" + detail.description + ")";
                detail.cost.forEach(function(harga) {
                var p1 = document.createElement("p");
                p1.textContent = harga.etd + " Days";
                var p2 = document.createElement("p");
                p2.classList.add("price-mobile-sidebar");
                p2.textContent = "Rp. " + new Intl.NumberFormat().format(harga.value) + ",-";
                var priceShipping = document.createElement("div");
                priceShipping.classList.add("price-shipping");
                var h5 = document.createElement("h5");
                h5.textContent = "Rp. " + new Intl.NumberFormat().format(harga.value) + ",-";
                priceShipping.appendChild(h5);
                heading.appendChild(h3);
                heading.appendChild(p1);
                heading.appendChild(p2);
                span.appendChild(heading);
                span.appendChild(priceShipping);
                });
                label.appendChild(input);
                label.appendChild(span);
                shippingContainer.appendChild(label);
            });
            });
        })
        .catch(error => {
            console.log(error); // menampilkan pesan error jika ada
        });
    } else {
        // Me-reset field jika tidak ada pelanggan yang dipilih
        document.getElementById('namaPenerima').value = '';
        document.getElementById('kotaPenerima').value = '';
        document.getElementById('kecamatanPenerima').value = '';
        document.getElementById('alamatlengkapPenerima').value = '';
        // Mengosongkan elemen dengan class "form-box__shipping"
        var shippingContainer = document.querySelector(".form-box__shipping");
        shippingContainer.innerHTML = "";
    }
    });
</script>
@endsection
