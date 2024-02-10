    @extends('layouts.admin.template')
    @section('content')
    <style>
    .button-display button {
        margin-right: 5px;
    }
    .form-check-input {
        margin-right: 8px;
    }

    .form-check-label {
        display: flex;
        align-items: center;
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
            <div class="container mt-5">
                <h2 class="mb-4">Banner Form</h2>
                <form action="{{ route('banners.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-check form-element" data-type="1">
                        <input type="radio" class="form-check-input" name="type" value="1" id="r1" onchange="handleBannerTypeChange()">
                        <label class="form-check-label" for="r1">Banner Tipe 1</label>
                    </div>

                    <div class="form-check form-element" data-type="2">
                        <input type="radio" class="form-check-input" name="type" value="2" id="r2" onchange="handleBannerTypeChange()">
                        <label class="form-check-label" for="r2">Banner Tipe 2</label>
                    </div>

                    <div class="form-check form-element" data-type="3">
                        <input type="radio" class="form-check-input" name="type" value="3" id="r3" onchange="handleBannerTypeChange()">
                        <label class="form-check-label" for="r3">Untuk di body</label>
                    </div>

                    <div class="mb-3 form-element" data-type="2" id="limage">
                        <label for="image" class="form-label">Image Upload</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>

                    <div class="mb-3 form-element" data-type="2" id="lselect">
                        <div class="form-group">
                            <label for="my-select">Product yang dijadikan banner</label>
                            <select id="my-select" class="form-control" name="product_id">
                                <option>Pilih Product</option>
                                @foreach ($product as $item)
                                    <option value="{{ $item['id'] }}">{{ $item['item_group_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 form-element" data-type="1" id="llink">
                        <label for="link" class="form-label">Link</label>
                        <input type="text" class="form-control" id="link" name="link" placeholder="https://example.com">
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
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
            <th>Image</th>
            <th>Link</th>
            <th colspan="2">Action</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($banners as $item)
            <tr>
                <td><img src="storage/{{ $item['image'] }}" alt="" width="70px"></td>
                <td scope="row">{{ $item['link'] }}</td>
                <td>
                    <form action="{{ route('banners.destroy', $item->id) }}" method="POST">
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
                              <h5 class="modal-title" id="exampleModalLabel">Edit Bnner</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="container mt-5">
                                <h2 class="mb-4">Banner Form</h2>
                                <form action="{{ route('banners.update', $item->id) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3 form-element" data-type="2" id="himage">
                                        <label for="image" class="form-label">Image Upload</label>
                                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                    </div>
                                    @if ($item['type'] == 1)
                                    <div class="mb-3 form-element" data-type="2" id="hselect">
                                        <div class="form-group">
                                            <label for="my-select">Product yang dijadikan banner</label>
                                            <select id="my-select" class="form-control" name="product_id" required>
                                                <option>Pilih Product</option>
                                                @foreach ($product as $item)
                                                    <option value="{{ $item['id'] }}">{{ $item['item_group_name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @else
                                    <div class="mb-3 form-element" data-type="1" id="hlink">
                                        <label for="link" class="form-label">Link</label>
                                        <input type="text" class="form-control" id="link" name="link" value="{{ $item['link'] }}">
                                    </div>
                                    @endif
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
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
function handleBannerTypeChange() {
    var bannerType = document.querySelector('input[name="type"]:checked').value;

    // Dapatkan elemen-elemen form yang ingin ditampilkan atau disembunyikan
    var imageInput = document.getElementById('limage');
    var productSelect = document.getElementById('lselect');
    var linkInput = document.getElementById('llink');

    // Tentukan elemen-elemen yang akan ditampilkan berdasarkan tipe banner yang dipilih
    var elementsToShow = [imageInput];

    if (bannerType === '1') {
        elementsToShow.push(productSelect);
        // Sembunyikan elemen productSelect jika tipe banner adalah 1
        productSelect.style.display = 'block';
        linkInput.style.display = 'none';
    } else {
        // Tampilkan elemen productSelect jika tipe banner adalah 2 atau 3
        elementsToShow.push(linkInput);
        linkInput.style.display = 'block';
    }

    // Dapatkan semua elemen form
    var allFormElements = [imageInput, productSelect, linkInput];

    // Sembunyikan elemen-elemen yang tidak termasuk dalam elementsToShow
    var elementsToHide = Array.from(allFormElements).filter(element => !elementsToShow.includes(element));

    // Terapkan gaya untuk menyembunyikan elemen-elemen yang tidak diperlukan
    elementsToHide.forEach(element => {
        element.style.display = 'none';
    });

    // Tampilkan elemen-elemen yang diperlukan
    elementsToShow.forEach(element => {
        element.style.display = 'block';
    });
}

function handleBannerTypeChangeUpdate() {
    var bannerType = document.querySelector('input[name="type"]:checked').value;

    // Dapatkan elemen-elemen form yang ingin ditampilkan atau disembunyikan
    var imageInput = document.getElementById('himage');
    var productSelect = document.getElementById('hselect');
    var linkInput = document.getElementById('hlink');

    // Tentukan elemen-elemen yang akan ditampilkan berdasarkan tipe banner yang dipilih
    var elementsToShow = [imageInput];

    if (bannerType === '1') {
        elementsToShow.push(productSelect);
        // Sembunyikan elemen productSelect jika tipe banner adalah 1
        productSelect.style.display = 'block';
        linkInput.style.display = 'none';
    } else {
        // Tampilkan elemen productSelect jika tipe banner adalah 2 atau 3
        elementsToShow.push(linkInput);
        linkInput.style.display = 'block';
    }

    // Dapatkan semua elemen form
    var allFormElements = [imageInput, productSelect, linkInput];

    // Sembunyikan elemen-elemen yang tidak termasuk dalam elementsToShow
    var elementsToHide = Array.from(allFormElements).filter(element => !elementsToShow.includes(element));

    // Terapkan gaya untuk menyembunyikan elemen-elemen yang tidak diperlukan
    elementsToHide.forEach(element => {
        element.style.display = 'none';
    });

    // Tampilkan elemen-elemen yang diperlukan
    elementsToShow.forEach(element => {
        element.style.display = 'block';
    });
}
</script>

@endsection
