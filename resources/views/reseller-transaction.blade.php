@extends('layouts.admin.template')
@section('content')
<div class="container mt-5">
    <form action="/reseller-transaction" method="GET" class="d-flex gap-4" style="align-items: center;">
        <label for="start_date" class="form-label">Tanggal Awal:</label>
        <div>
          <input type="date" class="form-control" name="start_date" id="start_date">
        </div>
        <label for="end_date" class="form-label">Tanggal Akhir:</label>
        <div>
          <input type="date" class="form-control" name="end_date" id="end_date">
        </div>
        <div>
          <button type="submit" class="btn btn-primary">Filter</button>
        </div>
      </form>
            <table class="table table-bordered mt-4">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>No. Wa</th>
                    <th>Grade</th>
                    <th>List Transaksi</th>
                    <th>Update Grade</th>
                </tr>
                </thead>
                <tbody>
                <!-- Loop through active resellers data -->
                @foreach($reseller as $key => $reseller)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $reseller->first_name }} {{ $reseller->last_name }}</td>
                        <td>{{ $reseller->email }}</td>
                        <td>{{ $reseller->no_wa }}</td>
                        <td>{{ $reseller->grade->name }}</td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateLevelModal{{ $reseller->id }}">
                                View
                            </button>
                            <!-- Modal -->
                            <div class="modal fade modal-fullscreen-sm-down" id="updateLevelModal{{ $reseller->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                {{-- <div class=""> --}}
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">History Transaksi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table-bordered">
                                                <tr>
                                                    <td>Kode Inv</td>
                                                    <td>Pelanggan</td>
                                                    <td>Total Bayar</td>
                                                    <td>Ongkos Pengiriman</td>
                                                </tr>
                                                @foreach ($reseller->resellerTransaction as $item)
                                                <tr>
                                                    <td>{{ $item['code_inv'] }}</td>
                                                    <td>{{ $item->pelanggan->name }}</td>
                                                    <td>{{ $item['total_bayar'] }}</td>
                                                    <td>{{ $item['cost'] }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateLevel{{ $reseller->id }}">
                                Update Level
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="updateLevel{{ $reseller->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Update Reseller Level</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Form for updating reseller level -->
                                            <form action="{{ url('update-level'.'/'.$reseller->id) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <label for="level">Select Level:</label>
                                                <select name="grade_id" id="level" class="form-control">
                                                    {{-- @dd($paket) --}}
                                                    @foreach ($paket as $pakets)
                                                        <option value="{{ $pakets['id'] }}" {{ ($pakets['id'] == $reseller['grade_id'])?'selected':'' }}>{{ $pakets['name'] }}</option>
                                                    @endforeach
                                                </select>
                                                <br>
                                                <button type="submit" class="btn btn-primary">Update Level</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
