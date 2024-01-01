    @extends('layouts.admin.template')
    @section('content')
    <style>
        .button-display button {
    margin-right: 5px;
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
                    <div class="form-check">
                        <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="type" id="" value="1">
                        bqnner Tipe 1
                      </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="type" id="" value="2">
                        Banner Tipe 2
                      </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="type" id="" value="3">
                        Untuk di body
                      </label>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image Upload</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label for="text_1" class="form-label">Text 1</label>
                        <input type="text" class="form-control" id="text_1" name="text_1">
                    </div>
                    <div class="mb-3">
                        <label for="text_2" class="form-label">Text 2</label>
                        <input type="text" class="form-control" id="text_2" name="text_2">
                    </div>
                    <div class="mb-3">
                        <label for="text_3" class="form-label">Text 3</label>
                        <input type="text" class="form-control" id="text_3" name="text_3">
                    </div>

                    <div class="mb-3">
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
                                    <div class="form-check">
                                        <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="type" id="" value="1" {{ ($item['type'] == 1)?'checked':'' }}>
                                        Tipe 1
                                      </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="type" id="" value="2" {{ ($item['type'] == 2)?'checked':'' }}>
                                        Tipe 2
                                      </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="type" id="" value="3" {{ ($item['type'] == 3)?'checked':'' }}>
                                        Tipe 3
                                      </label>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Image Upload</label>
                                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                    </div>
                                    <div class="mb-3">
                                        <label for="text_1" class="form-label">Text 1</label>
                                        <input type="text" class="form-control" id="text_1" name="text_1" value="{{ $item['text_1'] }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="text_2" class="form-label">Text 2</label>
                                        <input type="text" class="form-control" id="text_2" name="text_2" value="{{ $item['text_2'] }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="text_3" class="form-label">Text 3</label>
                                        <input type="text" class="form-control" id="text_3" name="text_3" value="{{ $item['text_3'] }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="link" class="form-label">Link</label>
                                        <input type="text" class="form-control" id="link" value="{{ $item['link'] }}" name="link" placeholder="https://example.com">
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
                </td>
            </tr>
            @endforeach
        </tbody>
</table>
@endsection
