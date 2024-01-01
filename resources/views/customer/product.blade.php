@extends('layouts.admin.navfootbar')
@section('content')
<style>
    .tabcontentnew{
        display:none;
    }
</style>

<div class="product container">
    <div>
        <div class="image-page-product">
            @if ($product->export == 1)
            <div class="image-product-page-main">
                    <img src="{{ $product['images']['path'] }}" class="show-image">
                {{-- <img src="images/2.jpg" alt="" class="hidden-image">
                <img src="images/3.jpg" alt="" class="hidden-image">
                <img src="images/4.jpg" alt="" class="hidden-image"> --}}
            </div>
            <div class="image-product-tab">
                <button class="image-product-tab-box active">
                    <img src="{{ $product['images']['path'] }}" alt="">
                </button>
            </div>
            @else
                <div class="image-product-page-main">
                    @foreach ($product['images'] as $index => $images)
                    @if ($index == 0)
                        <img src="{{ asset('/storage'.'/'.$images['path']) }}" class="show-image">
                    @else
                        <img src="{{ asset('/storage'.'/'.$images['path']) }}" class="hidden-image">
                    @endif
                    @endforeach
                    {{-- <img src="images/2.jpg" alt="" class="hidden-image">
                    <img src="images/3.jpg" alt="" class="hidden-image">
                    <img src="images/4.jpg" alt="" class="hidden-image"> --}}
                </div>
                <div class="image-product-tab">
                    @foreach ($product['images'] as $key => $images)
                    @if ($key == 0)
                    <button class="image-product-tab-box active">
                        @else
                        <button class="image-product-tab-box">
                    @endif
                        <img src="{{ asset('/storage'.'/'.$images['path']) }}" alt="">
                    </button>
                    @endforeach
                    {{-- <button class="image-product-tab-box">
                        <img src="images/2.jpg" alt="">
                    </button>
                    <button class="image-product-tab-box">
                        <img src="images/3.jpg" alt="">
                    </button>
                    <button class="image-product-tab-box">
                        <img src="images/4.jpg" alt="">
                    </button> --}}
                </div>
            @endif
        </div>
    </div>
    {{-- <div id="frappucino" class="tabcontent">
        <div class="image-page-product">
            <div class="image-product-page-main">
                <img src="images/5.jpg" class="show-image">
                <img src="images/6.jpg" alt="" class="hidden-image">
                <img src="images/4.jpg" alt="" class="hidden-image">
            </div>
            <div class="image-product-tab">
                <button class="image-product-tab-box active">
                    <img src="images/5.jpg" alt="">
                </button>
                <button class="image-product-tab-box">
                    <img src="images/6.jpg" alt="">
                </button>
                <button class="image-product-tab-box">
                    <img src="images/4.jpg" alt="">
                </button>
            </div>
        </div>
    </div>
    <div id="terracotta" class="tabcontent">
        <div class="image-page-product">
            <div class="image-product-page-main">
                <img src="images/7.jpg" class="show-image">
                <img src="images/8.jpg" alt="" class="hidden-image">
                <img src="images/4.jpg" alt="" class="hidden-image">
            </div>
            <div class="image-product-tab">
                <button class="image-product-tab-box active">
                    <img src="images/7.jpg" alt="">
                </button>
                <button class="image-product-tab-box">
                    <img src="images/8.jpg" alt="">
                </button>
                <button class="image-product-tab-box">
                    <img src="images/4.jpg" alt="">
                </button>
            </div>
        </div>
    </div> --}}
    <div class="content-page-product">
        <div class="product-name-price">
            <h1>{{ $product->item_group_name }}</h1>
            @auth
            <span>Rp. {{ number_format($product->reseller_sell_price) }} ,-</span>
            @else
            <span>Rp. {{ number_format($product->sell_price) }} ,-</span>
            @endauth
        </div>
        @auth
        <form action="/buy-now" method="post">@csrf
        @else
        <form action="/beli-sekarang" method="post">@csrf
        @endauth
        <div class="button-choose-layout">
            <span>Varian :</span>
            <div class="button-layout-mobile">
                <div class="button-layout">
                    @foreach ($colors as $color)
                        <button class="btn-product-style tablinks" data-color="{{ $color }}" type="button">{{ $color }}</button>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="button-choose-layout">
            <span>Ukuran :</span>
            {{-- @dd($variations    ) --}}
            @foreach ($colors as $colo)
            <div id="{{ $colo }}" class="tabcontent tab-content-size">
                <div class="button-layout-mobile">
                    <div class="size-button">
                        @foreach ($variation as $variations)
                        <div class="choose-size-box size-{{ $variations->warna }}">
                            <input type="checkbox" id="size-{{ $variations->size }}" value="{{ $variations->id }}" name="sizeId" onchange="updateCheckbox('size-{{ $variations->size }}')"/>
                            <div class="size-content">
                                <span>{{ $variations->size }}</span>
                            </div>
                        </div>
                        @endforeach
                        {{-- <div class="choose-size-box size-l">
                            <input type="checkbox" id="size-l" onchange="updateCheckbox('size-l')"/>
                            <div class="size-content">
                                <span>L (sabi 1)</span>
                            </div>
                        </div> --}}
                        {{-- <div class="choose-size-box size-xl">
                            <input type="checkbox" id="size-xl" onchange="updateCheckbox('size-xl')"/>
                            <div class="size-content">
                                <span>XL (sabi 1)</span>
                            </div>
                        </div>
                        <div class="choose-size-box size-xxl">
                            <input type="checkbox" id="size-xxl" onchange="updateCheckbox('size-xxl')"/>
                            <div class="size-content">
                                <span>XXL (sabi 1)</span>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <p class="stock-product-page"><span>20</span> Produk Tersedia</p>
        <div class="button-choose-layout">
            <span>Jumlah Produk :</span>
            <div class="layout-flex">
                <div class='qty-layout'>
                    <button onclick="decreaseQty()"><iconify-icon icon="fa6-solid:minus"></iconify-icon></button>
                    <input type="text" name="qty" value="1" id="qty"/>
                    <button onclick="increaseQty()"><iconify-icon icon="fa6-solid:plus"></iconify-icon></button>
                </div>
                <button type="button" class="add-cart" id="addToCartBtn"><iconify-icon icon="mdi:cart"></iconify-icon> Masukan Keranjang</button>
            </div>
        </div>
        <div class="colom-flex">
            <button class="button-buy green-old" type="submit">Beli Sekarang</button>
            <button class="button-buy green" type="button"><iconify-icon icon="ri:whatsapp-fill"></iconify-icon> Beli via Whatsapp</button>
        </div>
    </form>
        <div class="button-choose-layout">
            <span>Bagikan :</span>
            <div class="social-media-share">
                <div class="social-media-share-box">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=http://127.0.0.1:8000/product/{{ $product->id }}" target="_blank">
                        <iconify-icon icon="ri:facebook-fill"></iconify-icon>
                    </a>
                </div>
                <div class="social-media-share-box">
                    <a href="https://twitter.com/intent/tweet?text=http://127.0.0.1:8000/product/{{ $product->id }}" target="_blank">
                        <iconify-icon icon="pajamas:twitter"></iconify-icon>
                    </a>
                </div>
                <div class="social-media-share-box">
                    <a href="https://api.whatsapp.com/send?text=http://127.0.0.1:8000/product/{{ $product->id }}" target="_blank">
                        <iconify-icon icon="ri:whatsapp-fill"></iconify-icon>
                    </a>
                </div>
                <div class="social-media-share-box">
                    <a href="https://telegram.me/share/url?url=URLAnda&text=http://127.0.0.1:8000/product/{{ $product->id }}" target="_blank">
                        <iconify-icon icon="mingcute:telegram-fill"></iconify-icon>
                    </a>
                </div>
                <div class="social-media-share-box">
                    <a href="https://plus.google.com/share?url=http://127.0.0.1:8000/product/{{ $product->id }}" target="_blank">
                        <iconify-icon icon="fa-brands:google-plus-g"></iconify-icon>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="desc-product-layout container">
    <div class="heading-desc-product">
        <button class="tablinksnew" onclick="openDesc(event, 'Description')" id="defaultOpenNew">Deskripsi</button>
        <button class="tablinksnew" onclick="openDesc(event, 'Specification')">Spesifikasi</button>
    </div>
    <div class="content-desc-product">
        <div id="Description" class="tabcontentnew">
            <div class="desc-video">
                <iframe src="https://www.youtube.com/embed/djH_Yi9vz2I?si=ZVavviak2M1LooWY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
            <div class="product-name-desc">
                <h1>{{ $product->item_group_name }}</h1>
            </div>
            {{ $product->description }}
            {{-- <div class="list-desc">
                <h3>Detail</h3>
                <ul>
                    <li>Baju tidak terpisah</li>
                    <li>Perpaduan bahan waffle uniqlo dan piece dyed yang menyatu</li>
                    <li>Model kerah bulat</li>
                    <li>Kancing hidup di bagian belakang baju</li>
                    <li>Variasi jahitan lurus di bagian depan baju</li>
                    <li>Lengan kerut</li>
                    <li>Aksen kancing mati motif kayu di bagian bawah baju</li>
                    <li>Pinggang full karet</li>
                    <li>Saku celana di kanan dan kiri</li>
                    <li>Aksen kancing mati motif kayu di bagian saku celana</li>
                    <li>Variasi lipatan di bagian bawah celana</li>
                </ul>
            </div>
            <div class="list-desc">
                <h3>Kelebihan</h3>
                <ul>
                    <li>Memiliki tekstur seperti kulit jeruk</li>
                    <li>Bahan kain tidak kaku</li>
                    <li>Tidak panas saat dikenakan</li>
                    <li>Daya serap keringat yang baik</li>
                    <li>Lembut dan nyaman saat dipakai</li>
                </ul>
            </div> --}}
        </div>

        <div id="Specification" class="tabcontentnew">
            {{ $product->spesifikasi }}
            {{-- <div class="list-desc">
                <h3>Berat : 285</h3>
            </div>
            <div class="list-desc">
                <h3>Material :</h3>
                <ul>
                    <li>Bahan Baju : Waffle Uniqlo + Piece Dyed</li>
                    <li>Bahan Celana : Katun Davinci</li>
                </ul>
            </div>
            <div class="list-desc">
                <h3>Ukuran Baju :</h3>
                <ul>
                    <li>M : 5 - 6 tahun</li>
                    <li>L : 7 - 8 tahun</li>
                    <li>XL : 9 - 10 tahun</li>
                    <li>XXL : 11 - 12 tahun</li>
                </ul>
            </div>
            <div class="list-desc">
                <h3>Kode :</h3>
                <p>SABI 01 :</p>
                <p>Warna Baju : Tosca - Pink</p>
                <p>Warna Celana : Tosca</p>
            </div>
            <div class="list-desc">
                <p>SABI 02 :</p>
                <p>Warna Baju : Frappucinno - Navy</p>
                <p>Warna Celana : Brown</p>
            </div>
            <div class="list-desc">
                <p>SABI 03 :</p>
                <p>Warna Baju : Terracotta - Moss</p>
                <p>Warna Celana : Dark Brown</p>
            </div>
            <div class="list-desc">
                <h3>Note :</h3>
                <p>On Model size XL</p>
                <p>Usia 9 Tahun</p>
                <p>BB 30kg TB 143cm</p>
            </div> --}}
        </div>
    </div>
</div>
<div class="container">
    <div class="heading heading-page">
        Produk Lainnya
    </div>
    <div class="product-grid-main">

        @foreach ($lainya as $lainya)
        @if ($product->category_name == $lainya->category_name)
            @else
            <div class="swiper-slide">
                <div class="card-product">
                    <a href="{{ url('/product'.'/'.$lainya['id']) }}">
                    <div class="image-product">
                        <button class="stock-card-product">
                            462 Tersedia
                        </button>
                        @if ($lainya['export'] == 1)
                            <img src="{{ $lainya['images']['path'] }}" class="card-img-top" alt="...">
                        @else
                        @foreach ($lainya['images'] as $key => $images)
                        @if ($key == 1)
                        <img src="{{ asset('storage/'.$images['path']) }}" alt="">
                        @endif
                        @endforeach
                        @endif
                    </div>
                    </a>
                    <div class="content-product">
                        <div class="detail-product">
                            <a href="{{ url('/product'.'/'.$lainya['id']) }}">
                            <h4>{{ $lainya['item_group_name'] }}.</h4>
                            @auth
                            @if (auth()->user()->level == 'reseller')
                            <span>Rp. {{ number_format($lainya['reseller_sell_price']) }} ,-</span>
                            @else
                            <span>Rp. {{ number_format($lainya['sell_price']) }} ,-</span>
                            @endif
                            @else
                            <span>Rp. {{ number_format($lainya['sell_price']) }} ,-</span>
                            @endauth
                            </a>
                        </div>
                        <button class="wishlist-card-button" data-saved="false">
                            <iconify-icon icon="mdi:heart-outline"></iconify-icon>
                        </button>
                    </div>
                </div>
            </div>
        @endif
        @endforeach

    </div>
</div>


<!-- SCRIPT UNTUK TAB SPESIFIKASI -->
<script>
    function openDesc(evt, descName) {
  var i, tabcontentnew, tablinks;
  tabcontentnew = document.getElementsByClassName("tabcontentnew");
  for (i = 0; i < tabcontentnew.length; i++) {
    tabcontentnew[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinksnew");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(descName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpenNew").click();
</script>

<!-- SCRIPT UNTUK QUANTITY -->
<script>
    var qtyElement = document.getElementById("qty");
    var qty = 1;

    function increaseQty() {
        qty++;
        updateQty();
    }

    function decreaseQty() {
        if (qty > 1) {
            qty--;
            updateQty();
        }
    }

    function updateQty() {
        qtyElement.value = qty;
    }
</script>

<!-- SCRIPT UNTUK BUTTON PILIH UKURAN SIZE -->
<script>
    function updateCheckbox(checkboxId) {
      var checkboxes = document.querySelectorAll('.choose-size-box input[type="checkbox"]');
      checkboxes.forEach(function (checkbox) {
        var sizeContent = checkbox.nextElementSibling.querySelector("span");
        if (checkbox.id === checkboxId) {
          checkbox.checked = true;
          checkbox.parentNode.classList.add('active');
          sizeContent.style.opacity =1;
        } else {
          checkbox.checked = false;
          checkbox.parentNode.classList.remove('active');
          sizeContent.style.opacity = checkbox.disabled ? 0.3 : 1;
        }
      });
    }

  </script>

<!-- SCRIPT UNTUK MEMILIH WARNA DAN GAMBAR DIUBAH -->
<script>
    const tabContents = document.querySelectorAll(".tabcontent");
    const tabButtons = document.querySelectorAll(".tablinks");

    tabButtons.forEach((button, buttonIndex) => {
        button.addEventListener("click", () => {
            // Hide all tab contents
            tabContents.forEach(content => content.style.display = "none");

            // Show the selected tab content
            tabContents[buttonIndex].style.display = "block";

            // Update active class for tab buttons
            tabButtons.forEach(btn => btn.classList.remove("active"));
            button.classList.add("active");
        });
    });

    const tabImageContainers = document.querySelectorAll(".image-product-page-main");

    tabImageContainers.forEach((container, containerIndex) => {
        const images = container.querySelectorAll("img");
        const tabButtons = container.parentElement.querySelector(".image-product-tab").querySelectorAll(".image-product-tab-box");

        tabButtons.forEach((button, buttonIndex) => {
            button.addEventListener("click", () => {
                // Remove active class from all buttons in the current container
                tabButtons.forEach(btn => btn.classList.remove("active"));

                // Add active class to the clicked button
                button.classList.add("active");

                // Hide all images in the current container
                images.forEach(img => img.classList.add("hidden-image"));

                // Show the selected image in the current container
                images[buttonIndex].classList.remove("hidden-image");
            });
        });
    });

    const tabSizeContents = document.querySelectorAll(".tab-content-size");

    tabButtons.forEach((button, buttonIndex) => {
        button.addEventListener("click", () => {
            // Show the corresponding tab size content
            tabSizeContents[buttonIndex].style.display = "block";
        });
    });

    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    {{-- ADD TO CART DARI PAGE DETAIL PRODUCT --}}
    <script>
        function addToCart() {
        var selectedSizeId = $('input[name="sizeId"]:checked').val(); // Dapatkan id ukuran yang dipilih
        var qtyInput = document.querySelector('input[name="qty"]');
        var qtyValue = qtyInput.value;

        if (selectedSizeId && qtyValue) {
            // Mengambil token CSRF dari meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'POST',
                url: '/add-to-cart',
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Sertakan token CSRF di header
                },
                data: {
                    sizeId: selectedSizeId,
                    qty: qtyValue,
                },
                success: function(response) {
                    // console.log(response.message);
                    Swal.fire(
                    'Good job!',
                    'product added to cart',
                    'success'
                    )
                    // Lakukan sesuatu setelah produk ditambahkan ke keranjang
                },
                error: function(err) {
                    console.error('Error:', err);
                }
            });
            } else {
                console.error('Pilih ukuran dan warna sebelum menambahkan ke keranjang.');
            }
        }
        document.getElementById('addToCartBtn').addEventListener('click', function() {
        addToCart(); // Memanggil fungsi addToCart() saat tombol "ADD" ditekan
        });
    </script>
@endsection

