@extends('layouts.admin.template')
@section('content')
<style>
    /* Warna latar belakang untuk tab yang aktif */
    #myTabs .nav-item .nav-link.active {
        background-color: #3ded86; /* Ganti dengan warna primary yang diinginkan */
    }

    /* Warna hover untuk tab */
    #myTabs .nav-item .nav-link:hover {
        zoom: 110%;
        background-color: #b0d1bd; /* Ganti dengan warna danger yang diinginkan */
    }
</style>
<div class="container mt-5">
    <ul class="nav nav-tabs" id="myTabs">
        <li class="nav-item">
            <a class="nav-link active" id="inactive-tab" data-bs-toggle="tab" href="#inactiveResellers">Nonactive Resellers</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="active-tab" data-bs-toggle="tab" href="#activeResellers">Active Resellers</a>
        </li>
    </ul>

    <div class="tab-content mt-2">
        <!-- Tab Content for Active Resellers -->
        <div class="tab-pane fade" id="activeResellers">
            <h2 class="mt-3">Active Resellers</h2>
            <div class="table-responsive export-table">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tr>
                            <th>Foto KTP</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Grade</th>
                            <th>Nama</th>
                            <th>Provinsi</th>
                            <th>Kota</th>
                            <th>Kecamatan</th>
                            <th>Nomor KTP</th>
                            <th>Nomor WhatsApp</th>
                            <th>Alamat Lengkap</th>
                            <th>Nama Rekening</th>
                            <th>Nomor Rekening</th>
                        </tr>
                        @foreach($activeResellers as $reseller)
                        <tr>
                            <td><img src="{{ asset('storage/'.$reseller['foto_ktp']) }}" alt=""></td>
                            <td>{{ $reseller['first_name'] }} {{ $reseller['last_name'] }}</td>
                            <td>{{ $reseller->email }}</td>
                            <td>{{ $reseller->grade->name }}</td>
                            <td>{{ $reseller['first_name'] }} {{ $reseller['last_name'] }}</td>
                            <td>{{ $reseller['province']  }}</td>
                            <td>{{ $reseller['city']  }}</td>
                            <td>{{ $reseller['subdistrict']  }}</td>
                            <td>{{ $reseller['no_ktp']  }}</td>
                            <td>{{ $reseller['no_wa']  }}</td>
                            <td>{{ $reseller['address']  }}</td>
                            <td>{{ $reseller->bank->name }}</td>
                            <td>{{ $reseller['nomor_rekening']  }}</td>
                        </tr>
                        @endforeach

                </table>
            </div>
        </div>
        <div class="card-body">
</div>


        <!-- Tab Content for Inactive Resellers -->
        <div class="tab-pane fade show active" id="inactiveResellers">
            <h2 class="mt-3">Inactive Resellers</h2>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>View detail</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <!-- Loop through inactive resellers data -->
                @foreach($inactiveResellers as $reseller)
                    <tr>
                        <td>{{ $reseller->first_name }} {{ $reseller->last_name }}</td>
                        <td>{{ $reseller->email }}</td>
                        <td>Nonactive</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#view{{ $reseller['id'] }}">
                                    View
                                  </button>
                                <div class="modal fade" id="view{{ $reseller['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Reseller - Detail</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container mt-5">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <img src="{{ asset('storage/'.$reseller['foto_ktp']) }}" alt="User Profile" class="img-fluid">
                                                    </div>
                                                    <div class="col-md-8">
                                                        <h2>Reseller Profile</h2>
                                                        <table class="table">
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">Nama</th>
                                                                    <td>{{ $reseller['first_name'] }} {{ $reseller['last_name'] }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Provinsi</th>
                                                                    <td>{{ $reseller['province']  }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Kota</th>
                                                                    <td>{{ $reseller['city']  }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Kecamatan</th>
                                                                    <td>{{ $reseller['subdistrict']  }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Nomor KTP</th>
                                                                    <td>{{ $reseller['no_ktp']  }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Nomor WhatsApp</th>
                                                                    <td>{{ $reseller['no_wa']  }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Alamat Lengkap</th>
                                                                    <td>{{ $reseller['address']  }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Nama Rekening</th>
                                                                    <td>{{ $reseller->bank->name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Nomor Rekening</th>
                                                                    <td>{{ $reseller['nomor_rekening']  }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                          <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </td>
                        <td>
                            <form action="{{ url('/reseller-verify'.'/'.$reseller['id']) }}" method="post">@csrf
                            <button class="btn btn-danger">Verify</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
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
