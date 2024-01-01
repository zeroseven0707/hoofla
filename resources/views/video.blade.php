    @extends('layouts.admin.template')
    @section('content')
    <style>
        .video-card {
            margin-bottom: 20px;
        }
        iframe {
            width: 100%;
            height: 100%;
        }
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
                <form action="{{ route('videos.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="link_satu" class="form-label">Link Satu</label>
                        <input type="url" class="form-control" id="link_satu" name="link_satu" placeholder="Masukkan Link Satu" >
                    </div>
                    <div class="mb-3">
                        <label for="link_dua" class="form-label">Link Dua</label>
                        <input type="url" class="form-control" id="link_dua" name="link_dua" placeholder="Masukkan Link Dua" >
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>
{{-- <table class="table table-striped table-bordered mt-4">
    <thead class="thead-inverse">
        <tr class="text-center bg-gray">
            <th>Image</th>
            <th>Link</th>
            <th colspan="2">Action</th>
        </tr>
        </thead>
        <tbody>
            <div class="container mt-5">
                <div class="row">
                    @foreach ($videos as $key => $item)
                    <div class="col-md-6">
                        <div class="card video-card">
                            <div class="card-body">
                                <h5 class="card-title">Video {{ $key+1 }}</h5>
                                <!-- Ganti 'YOUR_YOUTUBE_EMBED_LINK_2' dengan tautan sembed YouTube video kedua -->
                                <iframe width="560" height="315" src="{{ $item['link'] }}" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </tbody>
</table> --}}
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body" data-bs-toggle="modal" data-bs-target="#modalLink1">
                    <h5 class="card-title">Card 1</h5>
                    <div class="embed-responsive embed-responsive-16by9">
                        {{-- <iframe src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe> --}}
                        {{-- <iframe src="https://www.youtube.com/watch?v=6pcQjBUuERA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe> --}}
                        {{-- <iframe class="embed-responsive-item" src="https://www.youtube.com/watch?v=Xh4NFhOvtkw" allowfullscreen></iframe> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body" data-bs-toggle="modal" data-bs-target="#modalLink2">
                    <h5 class="card-title">Card 2</h5>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/watch?v=Xh4NFhOvtkw" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Link 1 -->
<div class="modal fade" id="modalLink1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Link 1</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('videos.store') }}" method="post">@csrf
            <div class="modal-body">
                <input type="text" class="form-control" name="link_satu" placeholder="Masukkan Link 1">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
        </div>
    </div>
</div>

<!-- Modal Link 2 -->
<div class="modal fade" id="modalLink2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Link 2</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('videos.store') }}" method="post">@csrf
            <div class="modal-body">
                <input type="text" class="form-control" name="link_dua" placeholder="Masukkan Link 2">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
