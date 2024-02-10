@extends('layouts.admin.template')
@section('content')
    <style>
        /* Custom CSS styles can be added here */
        .custom-card {
            position: relative;
        }

        .upload-btn {
            position: absolute;
            top: 0;
            right: 0;
            cursor: pointer;
        }
            /* Warna latar belakang untuk tab yang aktif */
        #myTabs .nav-item .nav-link.active {
            background-color: #3ded86; /* Ganti dengan warna primary yang diinginkan */
        }

        /* Warna hover untuk tab */
        #myTabs .nav-item .nav-link:hover {
            zoom: 110%;
            background-color: #b0d1bd; /* Ganti dengan warna danger yang diinginkan */
        }
    </style>
{{-- <a name="" id="" class="btn btn-primary" href="/products-input" role="button">New</a> --}}
<div class="btn-group mt-4 w-100">
    <ul class="nav nav-tabs" id="myTabs">
        <li class="nav-item">
            <a class="nav-link active" id="active-tab" data-bs-toggle="tab" href="#publish">Product Sudah di Publish</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="inactive-tab" data-bs-toggle="tab" href="#nopublish">Product belum di Publish</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="inactive-tab" data-bs-toggle="tab" href="#local">Semua Product</a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link" id="inactive-tab" data-bs-toggle="tab" href="#external">Product External</a>
        </li> --}}
        <li class="nav-item">
            <a class="nav-link icon nav-link-bg" href="/sync">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41m-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9"/>
                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5 5 0 0 0 8 3M3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9z"/>
                  </svg>
                  Resynchron
            </a>
        </li>
    </ul>
    {{-- <a href="/products-input" class="ms-auto">
        <button type="button" class="btn btn-primary">
            New Product
        </button>
    </a> --}}
</div>

<div class="tab-content mt-4">
    <div class="tab-pane fade show active" id="publish">
        <div class="row row-cols-1 row-cols-md-4 g-4">
            @foreach ($publish as $publish)
            <div class="col-md-3">
                <div class="card custom-card">
                    <div class="dropdown">
                        <button class="btn btn-secondary upload-btn" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            ...
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @if ($publish['is_active'] == 0)
                        <li><a class="dropdown-item" href="/upload/{{ $publish->id }}">Publish</a></li>
                        @else
                        <li><a class="dropdown-item" href="/upload/{{ $publish->id }}">Non Active kan</a></li>
                        @endif       <!-- Add more dropdown items if needed -->
                        </ul>
                    </div>
                    @if ($publish['export'] == 0)
                        @foreach ($publish['images'] as $key => $images)
                            @if ($key == 1)
                                <img src="{{ asset('storage/'.$images['path']) }}" class="card-img-top" alt="...">
                            @endif
                        @endforeach
                    @elseif ($publish['export'] == 1)
                            <img src="{{ $publish['images']['path'] }}" class="card-img-top" alt="...">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ Str::substr($publish['item_group_name'], 0, 20) }}...</h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="tab-pane fade" id="nopublish">
        <div class="row row-cols-1 row-cols-md-4 g-4">
            @foreach ($nopublish as $nopublish)
            <div class="col-md-3">
                <div class="card custom-card">
                    <div class="dropdown">
                        <button class="btn btn-secondary upload-btn" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            ...
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @if ($nopublish['is_active'] == 0)
                        <li><a class="dropdown-item" href="/upload/{{ $nopublish->id }}">Publish</a></li>
                        @else
                        <li><a class="dropdown-item" href="/upload/{{ $nopublish->id }}">Non Active kan</a></li>
                        @endif       <!-- Add more dropdown items if needed -->
                        </ul>
                    </div>
                    @if ($nopublish['export'] == 0)
                        @foreach ($nopublish['images'] as $key => $images)
                            @if ($key == 1)
                                <img src="{{ asset('storage/'.$images['path']) }}" class="card-img-top" alt="...">
                            @endif
                        @endforeach
                    @elseif ($nopublish['export'] == 1)
                            <img src="{{ $nopublish['images']['path'] }}" class="card-img-top" alt="...">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ Str::substr($nopublish['item_group_name'], 0, 20) }}...</h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="tab-pane fade" id="local">
        <div class="row row-cols-1 row-cols-md-4 g-4">
            @foreach ($products as $products)
            <div class="col-md-3">
                <div class="card custom-card">
                    <div class="dropdown">
                        <button class="btn btn-secondary upload-btn" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            ...
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @if ($products['is_active'] == 0)
                        <li><a class="dropdown-item" href="/upload/{{ $products->id }}">Publish</a></li>
                        @else
                        <li><a class="dropdown-item" href="/upload/{{ $products->id }}">Non Active kan</a></li>
                        @endif       <!-- Add more dropdown items if needed -->
                        </ul>
                    </div>
                    @if ($products['export'] == 0)
                        @foreach ($products['images'] as $key => $images)
                            @if ($key == 1)
                                <img src="{{ asset('storage/'.$images['path']) }}" class="card-img-top" alt="...">
                            @endif
                        @endforeach
                    @elseif ($products['export'] == 1)
                            <img src="{{ $products['images']['path'] }}" class="card-img-top" alt="...">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ Str::substr($products['item_group_name'], 0, 20) }}...</h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="tab-pane fade" id="external">
        <div class="row row-cols-1 row-cols-md-4 g-4">
            @foreach ($product as $item)
            <div class="col-md-3">
                <div class="card custom-card">
                    <div class="dropdown">
                        <button class="btn btn-secondary upload-btn" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            ...
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="{{ url('/publish'.'/'.$item['item_group_id']) }}">Export</a></li>
                            {{-- <li><a class="dropdown-item" href="{{ url('/export'.'/'.$item['item_group_id']) }}">Export</a></li> --}}
                            <!-- Add more dropdown items if needed -->
                        </ul>
                    </div>
                    @if ($item['thumbnail'] == null)
                    <img src="{{ asset('images/default.png') }}" class="card-img-top" alt="...">
                    @else
                    <img src="{{ $item['thumbnail'] }}" class="card-img-top" alt="...">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ Str::substr($item['item_name'], 0, 20) }}...</h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
