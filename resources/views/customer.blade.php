
    @extends('layouts.admin.template')
    @section('content')
    <style>
        .button-display button {
    margin-right: 5px; /* Sesuaikan sesuai kebutuhan Anda */
}
</style>
<!-- Button trigger modal -->
<table class="table table-striped table-bordered mt-4">
    <thead class="thead-inverse">
        <tr class="text-center bg-gray">
            <th>Kode</th>
            <th>Name</th>
            <th>Keuntungan</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($customers as $item)
            <tr>
                <td>{{ $item['code'] }}</td>
                <td>{{ $item['name'] }}</td>
                <td scope="row">{{ $item['persentase'] }}</td>
                <td>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit{{ $item['id'] }}">Edit</button>
                    <!-- Modal -->
                    <div class="modal fade" id="edit{{ $item['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                          <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                              <form id="productForm" method="POST" action="{{ route('customers.update', $item->id) }}" enctype="multipart/form-data">
                                      @csrf
                                      @method('PUT')
                                      <div class="form-group">
                                          <div class="mb-3">
                                              <label for="code" class="form-label">Kode:</label>
                                              <input type="text" class="form-control" value="{{ $item['code'] }}" style="border: 1px solid black;" id="code" name="code" required>
                                          </div>
                                          <div class="mb-3">
                                            <label for="name" class="form-label">Name:</label>
                                            <input type="text" class="form-control" value="{{ $item['name'] }}" style="border: 1px solid black;" id="name" name="name" required>
                                        </div>
                                          <div class="mb-3">
                                              <label for="keuntungan" class="form-label">Keuntungan:</label>
                                              <input type="text" class="form-control" value="{{ $item['persentase'] }}" style="border: 1px solid black;" id="keuntungan" name="persentase" required>
                                          </div>
                                          <div class="mb-3">
                                              <button class="btn btn-primary mt-4">Save</button>
                                          </div>
                                      </div>
                              </form>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          </div>
                      </div>
                      </div>
                  </div>
                </td>
            </tr>
            @endforeach
        </tbody>
</table>
@endsection
