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
            <form id="productForm" method="POST" action="{{ route('banks.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" class="form-control" style="border: 1px solid black;" id="name" name="name" required>
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
            <th colspan="2">Action</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($banks as $item)
            <tr>
                <td>{{ $item['name'] }}</td>
                <td>
                    <form action="{{ route('banks.destroy', $item->id) }}" method="POST">
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
                              <form id="productForm" method="POST" action="{{ route('banks.update', $item->id) }}" enctype="multipart/form-data">
                                      @csrf
                                      @method('PUT')
                                      <div class="form-group">
                                          <div class="mb-3">
                                              <label for="name" class="form-label">Name:</label>
                                              <input type="text" class="form-control" value="{{ $item['name'] }}" style="border: 1px solid black;" id="name" name="name" required>
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
