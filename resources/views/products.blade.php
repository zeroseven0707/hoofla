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
            <a class="nav-link active" id="inactive-tab" data-bs-toggle="tab" href="#local">Product Local</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="active-tab" data-bs-toggle="tab" href="#external">Product External</a>
        </li>
    </ul>
    <a href="/products-input" class="ms-auto">
        <button type="button" class="btn btn-primary">
            New Product
        </button>
    </a>
</div>

<div class="tab-content mt-4">
    <div class="tab-pane fade show active" id="local">
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
