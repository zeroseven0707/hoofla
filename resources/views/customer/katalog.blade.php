@extends('layouts.admin.navfootbar')
@section('content')
<div class="container">
    <div class="heading heading-page">
        Katalog Hooflakids
    </div>
    <div class="sort-by-element">
        <div class="filter-category">
            <div class="filter-category-main">
                <label>Kategori Produk : </label>
                <div class="select-style">
                    <select name="category" id="categoryDropdown" onChange="handleCategoryChange()">
                        <option value="">Pilih Katgeori</option>
                    @foreach (category() as $categories)
                        <option value="{{ $categories['name'] }}">{{ $categories['name'] }}</option>
                    @endforeach
                    </select>
                    <iconify-icon icon="octicon:chevron-down-12"></iconify-icon>
                </div>
                <!-- <button type="submit">Cari</button> -->
            </div>
            <div class="sort-amount-results">
                <label>({{ count($product) }}) Produk</label>
            </div>
        </div>
        <div class="sort-category">
            <label>Atur Berdasarkan : </label>
            <div class="select-style-product">
                <select name="shortBy" id="sortDropdown" onChange="handleCategorySortChange()">
                    <option value="all">Semua</option>
                    <option value="sell_price">Harga</option>
                    <option value="asc">A - Z</option>
                    <option value="desc">Z - A</option>
                </select>
                <iconify-icon icon="octicon:chevron-down-12"></iconify-icon>
            </div>
        </div>
    </div>
    <div class="product-grid-main">

        @foreach ($product as $item)
        <div class="swiper-slide">
            <div class="card-product">
                <a href="{{ url('/product'.'/'.$item['id']) }}">
                <div class="image-product">
                    <button class="stock-card-product">
                        462 Tersedia
                    </button>
                    @if ($item['export'] == 1)
                        <img src="{{ $item['images']['path'] }}" class="card-img-top" alt="...">
                    @else
                    @foreach ($item['images'] as $key => $images)
                    @if ($key == 1)
                    <img src="{{ asset('storage/'.$images['path']) }}" alt="">
                    @endif
                    @endforeach
                    @endif
                </div>
                </a>
                <div class="content-product">
                    <div class="detail-product">
                        <a href="{{ url('/product'.'/'.$item['id']) }}">
                        <h4>{{ $item['item_group_name'] }}.</h4>
                        @auth
                        @if (auth()->user()->level == 'reseller')
                        <span>Rp. {{ number_format($item['reseller_sell_price']) }} ,-</span>
                        @else
                        <span>Rp. {{ number_format($item['sell_price']) }} ,-</span>
                        @endif
                        @else
                        <span>Rp. {{ number_format($item['sell_price']) }} ,-</span>
                        @endauth
                        </a>
                    </div>
                    <button class="wishlist-card-button" data-saved="false">
                        <iconify-icon icon="mdi:heart-outline"></iconify-icon>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
