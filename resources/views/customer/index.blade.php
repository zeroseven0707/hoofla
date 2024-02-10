@extends('layouts.admin.navfootbar')
@section('content')
<div class="swiper myBanner">
    <div class="swiper-wrapper">

      <!-- BANNER YANG TEXT, GAMBAR, BUTTON DLL DAPAT DIUBAH -->
      @foreach ($banner as $item)
      @if ($item['type'] == 1)
      <div class="swiper-slide">
        <div class="banner container">
            <div class="banner-layout">
                <div class="banner-content">
                    <span>{{ $item['text_1'] }}</span>
                    <h1>{{ $item['text_2'] }}</h1>
                    <p>Rp. {{ number_format($item['text_3']) }} ,-</p>
                    <div class="banner-content-button">
                        <a href="#">
                            <button>Jelajahi</button>
                        </a>
                        <a href="{{ $item['link'] }}">
                            <button class="outline-button">Belanja</button>
                        </a>
                    </div>
                </div>
                <div class="banner-image">
                    <img src="{{ asset('storage/'.$item['image']) }}" alt="">
                </div>
            </div>
        </div>
      </div>
      @elseif($item['type'] == 2)
      <div class="swiper-slide">
        <div class="banner container">
            <div class="banner-only-image-layout">
                <img class="banner-only-image" src="{{ asset('storage/'.$item['image']) }}" alt="">
            </div>
        </div>
      </div>
      @endif
      @endforeach

    </div>
    <div class="swiper-pagination"></div>
</div>

<div class="section-2">
    <h1 class="heading container">
        Produk Terlaris
    </h1>
    <div class="swiper myProduct container-product">
        <div class="swiper-wrapper">
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
                                @elseif (auth()->user()->level == 'distributor')
                                <span>Rp. {{ number_format($item['distributor_sell_price']) }} ,-</span>
                                @elseif (auth()->user()->level == 'agen')
                                <span>Rp. {{ number_format($item['agen_sell_price']) }} ,-</span>
                                @elseif(auth()->user()->level == 'sub agen')
                                <span>Rp. {{ number_format($item->sub_agen_sell_price) }} ,-</span>
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
        <div class="swiper-pagination"></div>
    </div>
</div>

<div class="section-3">
    <div class="promo-layout container">
        @foreach ($content as $contents)
        @if($contents['type'] == 3)
        <div class="promo-box">
            <a href="{{ $contents['link'] }}">
                <img src="{{ asset('storage/'.$contents['image']) }}" alt="">
            </a>
        </div>
        @endif
        @endforeach
    </div>
    <div class="promo-layout container">
        @foreach ($video as $videos)
        <div class="promo-box-video">
            <iframe src="{{ $videos['link'] }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>
        @endforeach
    </div>
</div>

<div class="section-2">
    <h1 class="heading container">
        Rekomendasi Produk
    </h1>
    <div class="swiper myProduct container-product">
        <div class="swiper-wrapper">
            @foreach ($rekomedasi as $item)
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
        <div class="swiper-pagination"></div>
    </div>
</div>
@auth
@else
<div class="section-cta container">
    <h1>Jadilah Reseller produk kami</h1>
    <p>Bergabunglah dengan program reseller kami dan nikmati peluang untuk mendapatkan penghasilan tambahan dengan menjual produk berkualitas kami</p>
    <a href="{{ url('/register') }}"><button>Gabung Sekarang</button></a>
    <img src="images/dompet.svg" alt="" class="icon-cta-1">
    <img src="images/bag.svg" alt="" class="icon-cta-2">
</div>
@endauth

@endsection
