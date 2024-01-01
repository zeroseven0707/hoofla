@extends('layouts.admin.template')
@section('content')
<div class="container mt-5">
    <div class="tab-content mt-2">
            <div class="table-responsive export-table">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Provinsi</th>
                                <th>Kota</th>
                                <th>Kecamatan</th>
                                <th>kontak</th>
                                <th>Alamat Lengkap</th>
                            </tr>
                        @foreach($pelanggans as $pelanggan)
                            <tr>
                                <td>{{ $pelanggan['name'] }}</td>
                                <td>{{ $pelanggan['email'] }}</td>
                                <td>{{ $pelanggan['province']  }}</td>
                                <td>{{ $pelanggan['city']  }}</td>
                                <td>{{ $pelanggan['subdistrict']  }}</td>
                                <td>{{ $pelanggan['no_telp']  }}</td>
                                <td>{{ $pelanggan['address']  }}</td>
                            </tr>
                        @endforeach

                </table>
            </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('.toggleDetails').forEach(button => {
    button.addEventListener('click', function() {
        let row = this.parentElement.parentElement;
        row.querySelectorAll('.extra').forEach(cell => {
            cell.classList.toggle('d-none');
        });
    });
});
</script>
@endsection
