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
                        <select name="category" id="categoryDropdown" onChange="handleFilterChange()">
                            <option value="">Pilih Kategori</option>
                            @foreach (category() as $categories)
                                <option value="{{ $categories['id'] }}">{{ $categories['name'] }}</option>
                            @endforeach
                        </select>
                        <iconify-icon icon="octicon:chevron-down-12"></iconify-icon>
                    </div>
                </div>
                <div class="sort-amount-results">
                    <label id="productCountLabel">({{ $jmlprdk }}) Produk</label>
                </div>
            </div>
            <div class="sort-category">
                <label>Atur Berdasarkan : </label>
                <div class="select-style-product">
                    <select name="shortBy" id="sortDropdown" onChange="handleFilterChange()">
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
    <script>
        // Panggil fungsi untuk menampilkan produk pertama kali saat halaman dimuat
        handleFilterChange();

        // Fungsi untuk menangani perubahan pada elemen filter kategori dan sort
        function handleFilterChange() {
            var category = $('#categoryDropdown').val();
            var sort = $('#sortDropdown').val();

            $.ajax({
                url: '{{ route('katalog.filter') }}',
                type: 'get',
                data: {
                    category: category,
                    sort: sort
                },
                success: function (response) {
                    displayProducts(response.products);
                },
                error: function (error) {
                    console.error('Error fetching products:', error);
                }
            });
        }

        // Fungsi untuk menampilkan produk ke dalam grid
        function displayProducts(products) {
            var productGrid = $('.product-grid-main');
            productGrid.empty();

            // Tambahkan produk dari daftar ke dalam grid
            if (products.length > 0) {
                $.each(products, function (index, item) {
                    var productElement = '<div class="swiper-slide">';
                    productElement += '<div class="card-product">';
                    productElement += '<a href="' + item.url + '">';
                    productElement += '<div class="image-product">';
                    productElement += '<button class="stock-card-product">462 Tersedia</button>';

                    if (item.export == 1) {
                        productElement += '<img src="' + item.images.path + '" class="card-img-top" alt="...">';
                    } else {
                        $.each(item.images, function (key, image) {
                            if (key == 1) {
                                productElement += '<img src="' + image.path + '" alt="">';
                            }
                        });
                    }

                    productElement += '</div></a>';
                    productElement += '<div class="content-product">';
                    productElement += '<div class="detail-product">';
                    productElement += '<a href="' + item.url + '">';
                    productElement += '<h4>' + item.item_group_name + '.</h4>';

                    // Sesuaikan dengan logika harga berdasarkan level user
                    var sellPrice = (item.export == 1) ? item.sell_price : (authUserLevel == 'reseller' ? item.reseller_sell_price : item.sell_price);
                    productElement += '<span>Rp. ' + formatNumber(sellPrice) + ',-</span>';

                    productElement += '</a></div>';
                    productElement += '<button class="wishlist-card-button" data-saved="false">';
                    productElement += '<iconify-icon icon="mdi:heart-outline"></iconify-icon>';
                    productElement += '</button></div></div></div>';

                    productGrid.append(productElement);
                });
            } else {
                productGrid.append('<p>Tidak ada produk yang sesuai.</p>');
            }

            // Perbarui label jumlah produk
            $('#productCountLabel').text('(' + products.length + ') Produk');
        }

        // Fungsi untuk memformat angka menjadi format mata uang
        function formatNumber(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>

@endsection
