@extends('layouts.admin.template')
@section('content')
<div class="container">
    <table class="table table-bordered">
        @foreach ($form as $item)
        <tr>
            <td>{{ $item['warna'] }}</td>
            <td>{{ $item['ukuran'] }}</td>

                <td>
                    <label for="category" class="form-label">Price</label>
                    <input type="text" class="form-control" id="category" name="category">
                </td>
                <td>
                    <label for="category" class="form-label">Reseller Price</label>
                    <input type="text" class="form-control" id="category" name="category">
                </td>
                <td>
                    <label for="category" class="form-label">Stok</label>
                    <input type="text" class="form-control" id="category" name="category">
                </td>
            </tr>
        @endforeach
    </table>
</div>
@endsection
