@extends('layouts.admin.template')
@section('content')
<style>
    .button-display button {
        margin-right: 5px; /* Sesuaikan sesuai kebutuhan Anda */
    }
</style>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">New</button>
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Merk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Upload Logo</h5>
                                <form action="{{ route('logos.store') }}" method="post" enctype="multipart/form-data">@csrf
                                    <div class="mb-3">
                                        <label for="logo" class="form-label">Select Logo:</label>
                                        <input type="file" class="form-control" id="logo" name="image" accept="image/*" onchange="previewLogo(this)">
                                    </div>
                                    <div class="mb-3">
                                        <img id="logoPreview" class="img-fluid" alt="Logo Preview" style="display: none;">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>
<table class="table table-striped table-bordered mt-4">
    <thead class="thead-inverse">
        <tr class="text-center bg-gray">
            <th>Logo</th>
            <th>Status</th>
            <th colspan="2">Action</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($logos as $item)
            <tr>
                <td><img src="storage/{{ $item['image'] }}" alt="" width="70px"></td>
                <td scope="row">{{ $item['status'] }}</td>
                <td>
                    <form action="{{ route('logos.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
                <td>
                    @if ($item['status'] == 'non active')
                    <form action="{{ route('logos.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-danger">Ganti</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
</table>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function previewLogo(input) {
        var logoPreview = document.getElementById('logoPreview');
        var fileInput = input.files[0];

        if (fileInput) {
            var reader = new FileReader();

            reader.onload = function (e) {
                logoPreview.src = e.target.result;
                logoPreview.style.display = 'block';
            }

            reader.readAsDataURL(fileInput);
        }
    }
</script>
@endsection
