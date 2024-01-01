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
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="productForm" method="POST" action="{{ url('category') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="Category" class="form-label">Category:</label>
                            <input type="text" class="form-control" style="border: 1px solid black;" id="Category" name="name" required>
                        </div>
                        <div id="buttonContainer" class="input-with-buttons" onclick="focusInput()">
                            <input type="text" id="subCategoryInput" class="form-control" name="sub_categories" style="border: 1px solid black;" placeholder="Pisahkan dengan koma" oninput="updateButtonContainer()">
                            <div id="buttonDisplay" class="button-display mt-4"></div>
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
<table class="table table-striped table-bordered">
    <thead class="thead-inverse">
        <tr>
            <th>Category</th>
            <th>Sub</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($category as $item)
            <tr>
                <td scope="row">{{ $item['name'] }}</td>
                <td>
                    @foreach ($item->sub as $sub)
                    {{ $sub }},
                    @endforeach
                </td>
                <td>
                    <a href="{{ url('/category-delete'.'/'.$item['id']) }}">Hapus</a>
                </td>
            </tr>
            @endforeach
            <tr>
                <td scope="row"></td>
                <td></td>
                <td></td>
            </tr>
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
