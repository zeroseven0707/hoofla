{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}
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
            <h5 class="modal-title" id="exampleModalLabel">Add</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="productForm" method="POST" action="{{ route('grades.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" class="form-control" style="border: 1px solid black;" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="profit" class="form-label">Profit /%:</label>
                            <input type="number" class="form-control" style="border: 1px solid black;" id="profit" name="profit" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" class="form-control" name="description" rows="3"></textarea>
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
<table class="table table-striped table-bordered mt-4">
    <thead class="thead-inverse">
        <tr class="text-center bg-gray">
            <th>Name</th>
            <th>Komisi(%)</th>
            <th>Description</th>
            <th colspan="2">Action</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($grades as $item)
            <tr>
                <td scope="row">{{ $item['name'] }}</td>
                <td>{{ $item['profit'] }}</td>
                <td>{{ Str::substr($item['description'], 0, 30) }}...</td>
                <td>
                    <form action="{{ route('grades.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
                <td>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit{{ $item['id'] }}">Edit</button>
                    <!-- Modal -->
                    <div class="modal fade" id="edit{{ $item['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                          <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Edit Merk</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                              <form id="productForm" method="POST" action="{{ route('grades.update', $item->id) }}" enctype="multipart/form-data">
                                      @csrf
                                      @method('PUT')
                                      <div class="form-group">
                                          <div class="mb-3">
                                              <label for="name" class="form-label">Name:</label>
                                              <input type="text" class="form-control" value="{{ $item['name'] }}" style="border: 1px solid black;" id="name" name="name" required>
                                          </div>
                                          <div class="mb-3">
                                              <label for="profit" class="form-label">Profit:</label>
                                              <input type="text" class="form-control" value="{{ $item['profit'] }}" style="border: 1px solid black;" id="profit" name="profit" required>
                                          </div>
                                          <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea id="description" class="form-control" name="description" rows="3">{{ $item['description'] }}</textarea>
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
