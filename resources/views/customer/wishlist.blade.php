@extends('layouts.admin.navfootbar')
@section('content')
<div class="cart-page container">
    <div class="heading heading-page">
        Favorit Saya
    </div>
    <div class="cart-product-wrapper">
        <div class="cart-product-body-heading">
            <h3>Rincian Produk</h3>
            <h3>Kuantitas</h3>
            <h3>Harga</h3>
            <h3>Total</h3>
        </div>
        <div class="cart-product-box">
            <div class="cart-product-detail">
                <div class="cart-product-image">
                    <img src="images/1.jpg" alt="">
                </div>
                <div class="cart-product-name">
                    <h3>Sabina One Seat</h3>
                    <p>Pink - Tosca</p>
                    <div class="quantity-mobile">
                        <input type="text" value="1">
                        <button class="add-cart"><iconify-icon icon="mdi:cart" style="color:#363B5B;"></iconify-icon></button>
                    </div>
                    <div class="price-mobile">
                        <span>Rp. 121.000 ,-</span>
                    </div>

                    <a href="remove-cart/0"><button>Hapus</button></a>
                </div>
            </div>
            <div class="product-layout-price">
                <span>Stok Tersedia</span>
            </div>
            <div class="product-layout-price">
                <span>Rp. 121.000 ,-</span>
            </div>
            <div class="product-layout-price">
                <button class="add-cart"><iconify-icon icon="mdi:cart"></iconify-icon></button>
            </div>
        </div>
    </div>
    <a href="/katalog" >
        <button class="back-buy container">
            <iconify-icon icon="mdi:cart"></iconify-icon>
            Lanjutkan Belanja
        </button>
    </a>
</div>
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
