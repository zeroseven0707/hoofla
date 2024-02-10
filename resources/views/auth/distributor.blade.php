<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
</head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<style>
.level-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.level-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background-color: #ffffff;
    border: 1px solid #dddddd;
    border-radius: 8px;
    padding: 20px;
    cursor: pointer;
    transition: transform 0.2s ease-in-out;
}

.level-card:hover {
    transform: scale(1.05);
}

input[type="radio"] {
    display: none;
}

input[type="radio"]:checked + .level-card {
    border-color: #306bb3;
    box-shadow: 0 0 10px rgba(6, 14, 150, 0.5);
}

h2 {
    margin: 0;
    color: #333333;
}

p {
    color: #777777;
}

</style>
<body>
<div class="container mt-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="row">
                        <div class="col-md-10">
                            <h2><b>Register Distributor</b></h2>
                        </div>
                        <div class="col-md-2 d-flex gap-2">
                            <button class="btn btn-primary" onclick="submitForm()">
                                Register
                            </button>
                        </div>
                    </div>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                    <div class="row mt-4">
                        <div class="col-md-4">
                                <div class="row gap-3">
                                    <div class="col-md-12"><button class="btn w-100 btn-light border text-start" onclick="showTab('detail_product')">Informasi Pribadi</button></div>
                                    <div class="col-md-12"><button class="btn w-100 btn-light border text-start" onclick="showTab('gambar_product')">Informasi Bank</button></div>
                                    {{-- <div class="col-md-12"><button class="btn w-100 btn-light border text-start" onclick="showTab('ipdp')">Level</button></div> --}}
                                    {{-- <div class="col-md-12"><button class="btn w-100 btn-outline-light text-start" onclick="showTab('informasi_pengiriman')">Informasi Pengiriman</button></div> --}}
                                </div>
                        </div>
                        <div class="col-md-8 border p-4">
                            <form id="productForm" method="POST" action="{{ url('/register-distributor') }}" enctype="multipart/form-data">
                                @csrf
                                <div id="detail_product_tab" class="tab-content">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="first_name" class="form-label">First Name:</label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="Last_name" class="form-label">Last Name:</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="no_wa" class="form-label">No Whatsapp:</label>
                                                <input type="text" class="form-control" id="no_wa" name="no_wa" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="no_ktp" class="form-label">No Ktp:</label>
                                                <input type="text" class="form-control" id="no_ktp" name="no_ktp" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="foto_ktp" class="form-label">Foto Ktp:</label>
                                                <input type="file" class="form-control" id="foto_ktp" name="foto_ktp" required>
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="province" class="form-label">Province:</label>
                                                <input type="text" class="form-control" id="province" name="province" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="city" class="form-label">City:</label>
                                                <input type="text" class="form-control" id="city" name="city" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="subdistrict" class="form-label">Subdistrict:</label>
                                                <input type="text" class="form-control" id="subdistrict" name="subdistrict" required>
                                            </div>
                                        </div> --}}
                                        <div class="col-md-6">
                                            <label for="provinsi">Provinsi</label>
                                            <div class="select-style">
                                                <select name="province_code" class="form-control" id="provinsi" required>
                                                    <option value="" default>Choose Province</option>
                                                    @foreach ($prov as $prov)
                                                    <option value="{{ $prov['province_id'] }}">{{ $prov['province'] }}</option>
                                                    @endforeach
                                                </select>
                                                <iconify-icon icon="octicon:chevron-down-12"></iconify-icon>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="city">City</label>
                                            <div class="select-style">
                                                <select name="city_code" class="form-control" id="city">
                                                    <option value="">Choose City</option>
                                                </select>
                                                <iconify-icon icon="octicon:chevron-down-12"></iconify-icon>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="subdistrict">Kecamatan</label>
                                            <div class="select-style">
                                                <select name="subdistrict_code" class="form-control" id="subdistrict">
                                                    <option value="">Choose Subdistrict</option>
                                                </select>
                                                <iconify-icon icon="octicon:chevron-down-12"></iconify-icon>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email:</label>
                                                <input type="text" class="form-control" id="email" name="email" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password:</label>
                                                <input type="text" class="form-control" id="password" name="password" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editor" class="form-label">Address:</label>
                                        <textarea class="form-control" id="editor" name="address" required></textarea>
                                    </div>
                                </div>
                                <div id="gambar_product_tab" class="tab-content" style="display: none;">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="my-select">Bank Name:</label>
                                            <select id="my-select" class="form-control" name="bank_id">
                                                @foreach ($bank as $banks)
                                                <option value="{{ $banks['id'] }}">{{ $banks['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{-- <input type="text" class="form-control" id="bank_id" name="bank_id" required> --}}
                                    </div>
                                    <div class="mb-3">
                                        <label for="nomor_rekening" class="form-label">Nomor Rekening:</label>
                                        <input type="text" class="form-control" id="nomor_rekening" name="nomor_rekening" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="account_holders_name" class="form-label">Account Holder's Name:</label>
                                        <input type="text" class="form-control" id="account_holders_name" name="account_holders_name" required>
                                    </div>
                                </div>
                                {{-- <div id="ipdp_tab" class="tab-content" style="display: none;">
                                    <div class="level-container">
                                        @foreach ($grades as $item)
                                        <input type="radio" id="{{ $item['name'] }}" name="type" value="{{ $item['id'] }}">
                                        <label for="{{ $item['name'] }}" class="level-card">
                                            <h2>{{ $item['name'] }}</h2>
                                            <p>{{ $item['description'] }}</p>
                                        </label>
                                        @endforeach
                                    </div>
                                </div> --}}
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
</div>
<script>
    function showTab(tabId) {
        // Hide all tabs
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.style.display = 'none';
        });

        // Show the selected tab
        document.getElementById(tabId + '_tab').style.display = 'block';
    }
</script>
<script>
    function submitForm() {
        // Memanggil fungsi submit form saat tombol "Simpan" ditekan
        document.getElementById('productForm').submit();
    }
</script>
    <script src="{{ asset('text-editor/tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: '#editor',
            plugins: 'autolink link image lists print preview',
            toolbar: 'undo redo | styleselect | bold italic | bullist numlist | alignleft | aligncenter | alignright | styleselect | preview',
            menubar: false,
        });
    </script>
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
</body>
</html>
