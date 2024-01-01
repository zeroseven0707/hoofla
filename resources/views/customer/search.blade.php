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
                    <select name="" id="categoryDropdown" onChange="handleCategoryChange()">
                        <option value="">Aksesoris</option>
                        <option value="">Alat Sholat</option>
                        <option value="">Bloom Series</option>
                        <option value="">Cookies</option>
                        <option value="">Fashion Anak dan Remaja</option>
                        <option value="">Fashion Bayi dan Anak</option>
                        <option value="">Fashion Dewasa</option>
                        <option value="">Fashion Sarimbit</option>
                        <option value="">Pasti Hemat</option>
                    </select>
                    <iconify-icon icon="octicon:chevron-down-12"></iconify-icon>
                </div>
                <!-- <button type="submit">Cari</button> -->
            </div>
            <div class="sort-amount-results">
                <label>(5) Produk</label>
            </div>
        </div>
        <div class="sort-category">
            <label>Atur Berdasarkan : </label>
            <div class="select-style-product">
                <select name="" id="sortDropdown" onChange="handleCategorySortChange()">
                    <option value="">Semua</option>
                    <option value="">Harga</option>
                    <option value="">A - Z</option>
                    <option value="">Z - A</option>
                </select>
                <iconify-icon icon="octicon:chevron-down-12"></iconify-icon>
            </div>
        </div>
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
                    <a href="product.php">
                        <img src="images/product.png" alt="">
                    </a>
                </div>
                <div class="content-product">
                    <a href="product.php">
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
