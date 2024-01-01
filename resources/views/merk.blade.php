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
            <form id="productForm" method="POST" action="{{ route('merks.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="Category" class="form-label">Code Merk:</label>
                            <input type="text" class="form-control" style="border: 1px solid black;" id="Category" name="code" required>
                        </div>
                        <div class="mb-3">
                            <label for="Category" class="form-label">Nama Merk:</label>
                            <input type="text" class="form-control" style="border: 1px solid black;" id="Category" name="name" required>
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
            <th>Code</th>
            <th>Nama</th>
            <th colspan="2">Action</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($merks as $item)
            <tr>
                <td>{{ $item['code'] }}</td>
                <td scope="row">{{ $item['name'] }}</td>
                <td>
                    <form action="{{ route('merks.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
                <td>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit{{ $item['code'] }}">Edit</button>
                    <!-- Modal -->
                    <div class="modal fade" id="edit{{ $item['code'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                          <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Edit Merk</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                              <form id="productForm" method="POST" action="{{ route('merks.update', $item->id) }}" enctype="multipart/form-data">
                                      @csrf
                                      @method('PUT')
                                      <div class="form-group">
                                          <div class="mb-3">
                                              <label for="Category" class="form-label">Code Merk:</label>
                                              <input type="text" class="form-control" value="{{ $item['code'] }}" style="border: 1px solid black;" id="Category" name="code" required>
                                          </div>
                                          <div class="mb-3">
                                              <label for="Category" class="form-label">Nama Merk:</label>
                                              <input type="text" class="form-control" value="{{ $item['name'] }}" style="border: 1px solid black;" id="Category" name="name" required>
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

                            <script>
                            // public/js/subCategoryInput.js
                            document.addEventListener('DOMContentLoaded', function () {
                                var subCategoryInput = document.getElementById('subCategoryInput');
                                var buttonContainer = document.getElementById('buttonContainer');
                                var buttonDisplay = document.getElementById('buttonDisplay');

                                function updateButtonDisplay() {
                                    var subCategories = subCategoryInput.value.split(',').map(function (subCategory) {
                                        return subCategory.trim();
                                    });

                                    // Kosongkan kontainer button
                                    buttonDisplay.innerHTML = '';

                                    // Tambahkan button untuk setiap subkategori
                                    subCategories.forEach(function (subCategory) {
                                        if (subCategory !== '') {
                                            var button = document.createElement('button');
                                            button.textContent = subCategory;
                                            button.type = 'button';
                                            button.className = 'btn btn-red'; // Tambahkan kelas CSS di sini
                                            buttonDisplay.appendChild(button);
                                        }
                                    });
                                }

                                function focusInput() {
                                    subCategoryInput.focus();
                                }

                                subCategoryInput.addEventListener('input', updateButtonDisplay);
                                buttonContainer.addEventListener('click', focusInput);
                            });
                            </script>
                            <script>
                                function submitForm() {
                                    // Memanggil fungsi submit form saat tombol "Simpan" ditekan
                                    document.getElementById('productForm').submit();
                                }
                            </script>

@endsection
