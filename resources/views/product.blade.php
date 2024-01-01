@extends('layouts.admin.template')
<style>
    .input-group { margin-bottom: 15px; }
</style>
@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="row">
                        <div class="col-md-10">
                            <h1><b>Product</b></h1>
                        </div>
                        <div class="col-md-2 d-flex gap-2">
                            <button class="btn btn-primary" onclick="submitForm()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                                    <path d="M11 2H9v3h2z"/>
                                    <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
                                </svg>
                                Simpan
                            </button>
                            <a href="" class="text-dark"><h1>X</h1></a>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-4">
                                <div class="row gap-3">
                                    <div class="col-md-12"><button class="btn w-100 btn-outline-light text-start" onclick="showTab('detail_product')">Detail Product</button></div>
                                    <div class="col-md-12"><button class="btn w-100 btn-outline-light text-start" onclick="showTab('gambar_product')">Gambar Product</button></div>
                                    <div class="col-md-12"><button class="btn w-100 btn-outline-light text-start" onclick="showTab('ipdp')">Informasi Penjualan dan Pembelian</button></div>
                                    <div class="col-md-12"><button class="btn w-100 btn-outline-light text-start" onclick="showTab('informasi_pengiriman')">Informasi Pengiriman</button></div>
                                </div>
                        </div>
                        <div class="col-md-8 border">
                            <form id="productForm" method="POST" action="{{ url('products-input') }}" enctype="multipart/form-data">
                                <div id="detail_product_tab" class="tab-content">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="product_name" class="form-label">Nama Produk:</label>
                                        <input type="text" class="form-control" id="product_name" name="product_name" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="category" class="form-label">Kategori:</label>
                                        <select class="form-select" id="category" name="category" required>
                                            <option value="" disabled selected>Pilih Kategori</option>
                                            @foreach (category() as $categories)
                                            <option value="{{  $categories['id']  }}">{{  $categories['name']  }}</option>
                                            @endforeach
                                            <!-- Tambahkan opsi kategori lainnya sesuai kebutuhan -->
                                        </select>
                                    </div>

                                    <div id="sub_category_container" style="display: none;" class="mb-3">
                                        <label for="sub_category" class="form-label">Sub Kategori:</label>
                                        <select class="form-select" id="sub_category" name="sub_category">
                                            <!-- Sub kategori akan muncul setelah kategori dipilih -->
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="brand" class="form-label">Merk:</label>
                                        <select class="form-select" id="brand" name="brand">
                                            <option value="" disabled selected>Pilih Merk</option>
                                            @foreach ($merk as $merks)
                                            <option value="{{ $merks['code'] }}">{{ $merks['name'] }}</option>
                                            @endforeach
                                            {{-- <option value="sayur">Sayur</option> --}}
                                            <!-- Tambahkan opsi kategori lainnya sesuai kebutuhan -->
                                        </select>
                                    </div>

                                    {{-- <label for="brand_l" class="form-label">Merk Lainya:</label>
                                    <div class="mb-3 d-flex gap-4">
                                        <div class="">
                                            <input type="text" class="form-control" id="brand_l" name="brand_l">
                                        </div>
                                        <div class="">
                                            <label class="switch">
                                                <input type="checkbox" name="">
                                                <span class="slider round"></span>
                                            </label>
                                            <label for="">Tidak ada Merk</label>
                                        </div>
                                    </div> --}}
                                    <div class="mb-3">
                                        <label for="barcode" class="form-label">Barcode:</label>
                                        <input type="text" class="form-control" id="barcode" name="barcode" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="description">Deskripsi</label>
                                                    <textarea id="editor" name="description"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="spesifikasi">Spesifikasi</label>
                                                    <textarea id="editor" name="spesifikasi"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="gambar_product_tab" class="tab-content" style="display: none;">
                                    <div class="container mt-5">
                                        <div class="row">
                                            <div class="col-md-6 mx-auto">
                                                <div class="file-input-card">
                                                    <label for="fileInput" class="mb-0">
                                                        <h5><i class="fas fa-cloud-upload-alt"></i> Pilih file</h5>
                                                        <p class="mb-0">Pilih file untuk diunggah</p>
                                                    </label>
                                                    <input type="file" name="images[]" id="fileInput" class="form-control" multiple>
                                                </div>
                                                <small class="text-danger">*Maksimal 9 gambar</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="ipdp_tab" class="tab-content" style="display: none;">
                                    <div class="container mt-5">
                                        <div class="d-flex gap-4">
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="dijual" name="dijual">
                                                    <label class="form-check-label" for="dijual">Dijual</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="dibeli" name="dibeli">
                                                    <label class="form-check-label" for="dibeli">Dibeli</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="disimpan" name="disimpan">
                                                    <label class="form-check-label" for="disimpan">Disimpan</label>
                                                </div>
                                            </div>
                                            <div  class="d-flex">
                                                <label class="switch">
                                                    <input type="checkbox"id="recomendation" name="recomendation">
                                                    <span class="slider round"></span>
                                                </label>
                                                <label for="recomendation">Rekomendasikan Product</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <h5 class="d-flex">Harga di depan<p class="text-danger">*</p></h5>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="hargaDefault">Harga Default</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1">Rp</span>
                                                        <input type="number" class="form-control" id="hargaDefault" name="hargaDefault" aria-describedby="basic-addon1" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="hr">Harga Reseller</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1">Rp</span>
                                                        <input id="hr" type="number" class="form-control" id="hargaReseller" name="hargaReseller" aria-describedby="basic-addon1" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="hd">Harga Dropshipper</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1">Rp</span>
                                                        <input id="hd" type="number" class="form-control" id="hargaDropshipper" name="hargaDropshipper" aria-describedby="basic-addon1" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="variantForm">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="warna[]" placeholder="Warna">
                                                            <button type="button" onclick="addInput('warna')">+</button>
                                                        </div>
                                                    </div>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="size[]" placeholder="Size">
                                                            <button type="button" onclick="addInput('size')">+</button>
                                                        </div>
                                                </div>


                                                <h5 class="d-flex">Detail Harga Variant<p class="text-danger">*</p></h5>
                                                <table id="variantTable" class="table table-responsive table-striped table-bordered">
                                                    <!-- Tabel akan diisi oleh JavaScript -->
                                                </table>
                                            </div>
                                </div>
                                <div id="informasi_pengiriman_tab" class="tab-content" style="display: none;">
                                    <div class="container mt-5">
                                        <div class="form-group">
                                            <label for="beratPaket">Berat Paket (Gram)*:</label>
                                            <input type="text" class="form-control" id="beratPaket" name="package_weight" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="panjangPaket">Panjang Paket (cm):</label>
                                            <input type="text" class="form-control" id="panjangPaket" name="package_length">
                                        </div>

                                        <div class="form-group">
                                            <label for="tinggiPaket">Tinggi Paket (cm):</label>
                                            <input type="text" class="form-control" id="tinggiPaket" name="package_height">
                                        </div>

                                        <div class="form-group">
                                            <label for="lebarPaket">Lebar Paket (cm):</label>
                                            <input type="text" class="form-control" id="lebarPaket" name="package_width">
                                        </div>

                                        <div class="form-group">
                                            <label for="isiPaket">Isi Paket:</label>
                                            <textarea class="form-control" id="isiPaket" name="isiPaket" rows="4"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        function addInput(type) {
    let container = document.createElement('div');
    container.className = 'input-group';
    container.innerHTML = `<input type="text" name="${type}[]" class="form-control" placeholder="${type.charAt(0).toUpperCase() + type.slice(1)}"><button type="button" onclick="removeInput(this)">-</button>`;
    document.getElementById('variantForm').insertBefore(container, document.getElementById('variantForm').children[type === 'warna' ? 1 : 2]);
}

function removeInput(button) {
    button.parentElement.remove();
    updateTable();
}

function updateTable() {
    let warna = Array.from(document.querySelectorAll('input[name="warna[]"]')).map(input => input.value);
    let size = Array.from(document.querySelectorAll('input[name="size[]"]')).map(input => input.value);
    let table = document.getElementById('variantTable');
    table.innerHTML = '';
    let headerRow = table.insertRow();
    headerRow.innerHTML = '<td>Warna dan Ukuran</td><td>SKU</td><td>Stok</td><td>Harga</td><td>Harga Reseller</td><td>Harga Dropshipper</td>';

    warna.forEach(w => {
        size.forEach(s => {
            let row = table.insertRow();
            row.innerHTML = `<td>Warna<input type="text" value="${w}" class="form-control" name="colors[]"> Size<input type="text" value="${s}" class="form-control" name="sizes[]"></td><td><input type="text" class="form-control" name="sku[]" placeholder="SKU"></td><td><input type="text" class="form-control" name="stok[]" placeholder="Stok"></td><td><input class="form-control" type="text" name="price[]" placeholder="Harga"></td><td><input type="text" class="form-control" name="reseller_price[]" placeholder="Harga Reseller"></td><td><input class="form-control" type="text" name="dropshipper_price[]" placeholder="Harga Dropshipper"></td>`;
        });
    });
}

document.getElementById('variantForm').addEventListener('input', updateTable);
updateTable();
</script>
    <script>
        function submitForm() {
            // Memanggil fungsi submit form saat tombol "Simpan" ditekan
            document.getElementById('productForm').submit();
        }
    </script>
    {{-- select sub --}}
<script>
    $(document).ready(function () {
        $('#category').on('change', function () {
            var categoryId = $(this).val();
            if (categoryId) {
                $.ajax({
                    url: '/select-sub-category/' + categoryId,
                    type: 'GET',
                    success: function (response) {
                        if (response.subCategories.length > 0) {
                            $('#sub_category').empty(); // Kosongkan opsi subkategori sebelum memperbarui
                            $.each(response.subCategories, function (index, subCategory) {
                                $('#sub_category').append('<option value="' + subCategory + '">' + subCategory + '</option>');
                            });
                            $('#sub_category_container').show(); // Tampilkan container subkategori
                        } else {
                            $('#sub_category_container').hide(); // Sembunyikan container subkategori jika tidak ada subkategori yang ditemukan
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            } else {
                $('#sub_category_container').hide(); // Sembunyikan container subkategori jika kategori tidak dipilih
            }
        });
    });
</script>
<script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
<script>
    tinymce.init({
        selector: '#editor',
        plugins: 'autolink link image lists print preview',
        toolbar: 'undo redo | styleselect | bold italic | bullist numlist | alignleft | aligncenter | alignright | styleselect | preview',
        menubar: false,
    });
</script>
@endsection
