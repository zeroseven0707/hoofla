@extends('layouts.admin.navfootbar')
@section('content')
<div class="cart-page container">
    <div class="heading heading-page">
        Keranjang Belanja
    </div>
    <div class="cart-product-wrapper">
        <div class="cart-product-body-heading">
            <h3>Rincian Produk</h3>
            <h3>Kuantitas</h3>
            <h3>Harga</h3>
            <h3>Total</h3>
        </div>
        @if (session('cart'))
        <?php
            $total = 0;
            ?>
        @foreach (session('cart') as $key => $cart)
        <div class="cart-product-box">
            <div class="cart-product-detail">
                <div class="cart-product-image">
                    <img src="images/1.jpg" alt="">
                </div>
                <div class="cart-product-name">
                    <h3>{{ $cart['nama'] }}</h3>
                    <p>{{ $cart['size'] }}</p>
                    <div class="quantity-mobile">
                        <input type="text" value="{{ $cart['qty'] }}">
                    </div>
                    <div class="price-mobile">
                        <span>Rp. {{ number_format($cart['price']) }} ,-</span>
                    </div>
                    <a href="remove-cart-{{ $key }}"><button>Hapus</button></a>
                </div>
            </div>
            <div class="cart-product-quantity">
                <div class='qty-layout'>
                    <input type="text" value="{{ $cart['qty'] }}" id="qty"/>
                </div>
            </div>
            <div class="product-layout-price">
                <span>Rp. {{ number_format($cart['price']) }} ,-</span>
            </div>
            <div class="product-layout-price">
                <span>Rp. {{ number_format($cart['price_total']) }} ,-</span>
            </div>
        </div>
        <?php
            $total += $cart['price_total']
        ?>
        @endforeach
        @else
        @endif
        <a href="{{ url('/katalog') }}" >
            <button class="back-buy container">
                <iconify-icon icon="mdi:cart"></iconify-icon>
                Lanjutkan Belanja
            </button>
        </a>
    </div>
</div>
@if (session('cart'))
<div class="checkout-button container">
    <div class="checkout-button-layout container">
        <a href="/remove-allcart">
        <button class="checkout-button__option">
        <iconify-icon icon="heroicons:trash-solid"></iconify-icon>
            Hapus Semua
        </button>
        </a>
        <a href="/wishlist_all">
            <button class="checkout-button__option">
                <iconify-icon icon="mdi:heart"></iconify-icon>
                Tambahkan ke Favorit Saya
            </button>
        </a>
        <div class="total-produk">
            <span>Total ({{ count(session('cart')) }} Produk):</span>
            <h3>Rp. {{ number_format($total) }} ,-</h3>
        </div>
        @auth
        <a href="{{ url('/checkout') }}">
            @else
        <a href="{{ url('/informasi') }}">
        @endauth
            <button class="checkout-button__next">
                Lanjut Proses
            </button>
        </a>
    </div>
</div>
@else
@endif
<div class="container">
    <div class="heading heading-page">
        Produk Lainnya
    </div>
    <div class="product-grid-main">

        <?php

        // Perulangan untuk membuat card product
        for ($i = 0; $i < 8; $i++) :
        ?>
            <div class="card-product">
                <div class="image-product">
                    <button class="stock-card-product">
                        462 Tersedia
                    </button>
                    <a href="#">
                        <img src="images/product.png" alt="">
                    </a>
                </div>
                <div class="content-product">
                    <a href="#">
                        <div class="detail-product">
                            <h4>Noura Set Blouse</h4>
                            <span>Rp. 121.000 ,-</span>
                        </div>
                    </a>
                    <button class="wishlist-card-button" data-saved="false">
                        <iconify-icon icon="mdi:heart-outline"></iconify-icon>
                    </button>
                </div>
            </div>
        <?php endfor; ?>

    </div>
</div>
@endsection
