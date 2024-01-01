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
</style>
</head>
<body>

<div class="container mt-5">
<div class="row row-cols-1 row-cols-md-4 g-4">
    @foreach ($product as $item)
    <div class="col-md-3">
        <div class="card custom-card">
            <div class="dropdown">
                <button class="btn btn-secondary upload-btn" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    ...
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="#">Upload</a></li>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
