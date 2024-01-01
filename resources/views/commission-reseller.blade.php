@extends('layouts.admin.template-reseller')
@section('content')
<div class="container mt-5">
<div class="row">
    <div class="col-md-10"><h2>Rp. {{ $komisi }}</h2></div>
    <div class="col-md-1"><button class="btn btn-danger">My Coevo</button></div>
    <div class="col-md-1"><button class="btn btn-green">WD</button></div>
</div>
      <br> 
    <h4 class="mt-4">History Komisi</h4>
    <form action="/commission-reseller" method="GET" class="d-flex gap-4" style="align-items: center;">
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
                    <th>Komisi Yang didapat</th>
                    <th>Code Transaksi</th>
                    <th>Total Bayar</th>
                    <th>Pelanggan</th>
                    <th>List Product</th>
                </tr>
                </thead>
                <tbody>
                <!-- Loop through active resellers data -->
                @foreach($transaction as $key => $transaction)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>Rp {{ number_format($transaction->commission) }} -,</td>
                        <td>{{ $transaction->code_inv }}</td>
                        <td>{{ number_format($transaction->total_bayar) }}</td>
                        <td>{{ $transaction->pelanggan->name }}</td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#product{{ $transaction->id }}">
                                View
                            </button>

                            <!-- Modal -->
                            <div class="modal fade modal-fullscreen-sm-down" id="product{{ $transaction->id }}" tabindex="-1" aria-labelledby="product" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="product">List Product</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-bordered table-striped">
                                                <tr>
                                                    <td>No.</td>
                                                    <td>Nama</td>
                                                    <td>Warna</td>
                                                    <td>Size</td>
                                                    <td>Harga</td>
                                                    <td>Jumlah</td>
                                                    <td>Komisi Yang didapat</td>
                                                </tr>
                                                @foreach ($transaction->detran as $key => $item)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $item->variations->product->item_group_name }}</td>
                                                    <td>{{ $item->variations->warna }}</td>
                                                    <td>{{ $item->variations->size }}</td>
                                                    <td>{{ number_format($item['total']) }}</td>
                                                    <td>{{ $item['qty'] }}</td>
                                                    <td>{{ number_format(($item['commission'] == null)?'0':$item['commission']) }}</td>
                                                </tr>
                                            @endforeach
                                            </table>
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
