@extends('layouts.admin.navfootbar')

@section('content')
    <div class="container">
        <div class="heading heading-page">
            Hasil Pencarian Produk
        </div>
        <div class="product-grid-main">
            @forelse ($product as $item)
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
            @empty
                <p>Tidak ada hasil pencarian.</p>
            @endforelse
        </div>
    </div>
@endsection
