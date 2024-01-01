<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hooflakids</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert/sweetalert.css') }}">
</head>
<body>
    @if(session('error'))
    <script>
        Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '{{ session()->get("error") }}',
        footer: ''
        })
    </script>
    @endif
    @if(session('success'))
    <script>
           Swal.fire(
                'Good job!',
                '{{ session()->get("success") }}',
                'success'
                )
    </script>
    @endif
<header class="header">
    <div class="top-menu">
        <div class="container top-menu-layout">
            <div class="top-menu-layout-box">
                <!-- SETELAH USER LOGIN MAKA TAMPILKAN YANG DIBAWAH INI -->
                <!-- <div class="menu-reseller">
                    <ul>
                        <li><a href="#"><iconify-icon icon="material-symbols-light:book-outline"></iconify-icon> Pemesanan</a></li>
                        <li><a href="#"><iconify-icon icon="ph:wallet-light"></iconify-icon> Saldo</a></li>
                        <li><a href="#"><iconify-icon icon="ph:note-thin"></iconify-icon> Transaksi</a></li>
                        <li><a href="#"><iconify-icon icon="ph:user-circle-thin"></iconify-icon> Pelanggan</a></li>
                    </ul>
                </div> -->
                <!-- SETELAH USER LOGIN MAKA TAMPILKAN YANG DIATAS INI -->
            </div>
            <div class="top-menu-layout-box top-menu-layout-box-2">
                <!-- SETELAH USER LOGIN MAKA TAMPILKAN YANG DIBAWAH INI -->
                @auth
                <div class="login-user-layout">
                    <button class="user-btn-login" id="toggleButtonUser">
                        <iconify-icon icon="mingcute:user-4-fill"></iconify-icon>
                        <p>{{ auth()->user()->first_name }}<span>(Reseller)</span></p>
                    </button>
                    <div class="popup-user" id="userPopup">
                        <ul>
                            <li><a href="{{ url('/transaction-reseller') }}">Dashboard</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" id="logoutForm" class="side-menu__item has-link">
                                    @csrf
                                    {{-- <x-responsive-nav-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();" side-menu__icon>
                                        {{ __('Log Out') }}
                                    </x-responsive-nav-link> --}}
                                    <button type="submit" style="border: none; background: none;">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                @else
                <div class="btn-login">
                        <a href="/login">
                            <button class="font-17">Masuk</button>
                        </a>
                        |
                        <a href="/daftar">
                            <button class="font-17">Daftar</button>
                        </a>
                </div>
                @endauth
                <!-- SETELAH USER LOGIN MAKA TAMPILKAN YANG DIATAS INI -->

                <!-- Ketika user sudah login maka div di bawah ini di hilangkan -->
                <!-- Ketika user sudah login maka div di atas ini di hilangkan -->

                <div class="social-media">
                    <a href="">
                        <div class="social-media-box">
                            <iconify-icon icon="uil:facebook"></iconify-icon>
                        </div>
                    </a>
                    <a href="">
                        <div class="social-media-box">
                            <iconify-icon icon="mdi:instagram"></iconify-icon>
                        </div>
                    </a>
                    <a href="">
                        <div class="social-media-box">
                        <iconify-icon icon="entypo-social:youtube"></iconify-icon>
                        </div>
                    </a>
                    <a href="">
                        <div class="social-media-box">
                            <iconify-icon icon="ri:whatsapp-fill"></iconify-icon>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
   <div class="menuLayout" id="navbar">
        <div class="header-main container" >
           <div class="logo">
              <a href="{{ url('/') }}"><img src="{{ asset('storage'.'/'.logo()) }}" alt=""></a>
           </div>
           <div class="menu-overlay">
           </div>
           <!-- navigation menu start -->
           <nav class="nav-menu">
             <ul class="menu">
                <li class="close-menu">
                    <a class="close-nav-menu"><iconify-icon icon="carbon:close"></iconify-icon></a>
                </li>
                <li class="menu-item">
                   <a href="{{ url('/') }}">Beranda</a>
                </li>
                <li class="menu-item menu-item-has-children">
                   <a href="{{ url('/katalog') }}" data-toggle="sub-menu">Katalog
                    {{-- <iconify-icon icon="octicon:chevron-down-12"></iconify-icon> --}}
                </a>
                   {{-- <ul class="sub-menu">
                    @foreach (category() as $categories)
                    <li class="menu-item"><a href="{{ url('/kategori'.'/'.$categories['name']) }}">{{ $categories['name'] }}</a></li>
                    @endforeach
                   </ul> --}}
                </li>
                <li class="menu-item">
                    <a href="/gabung-reseller">Gabung Kemitraan</a>
                </li>
                <li class="menu-item">
                    <a href="/tentang-kami">Tentang Kami</a>
                </li>
                <li class="menu-item">
                    <a href="/contact">Kontak</a>
                </li>
                <!-- Setelah user login maka di bawah ini di hilangkan -->
                <li class="menu-item menu-login-mobile">
                    <div class="login-mobile">
                        <a href="#">
                            <button>Masuk</button>
                        </a>
                        <a href="#">
                            <button>Daftar</button>
                        </a>
                    </div>
                </li>
                <!-- Setelah user login maka di atas ini di hilangkan -->

                <!-- SETELAH USER LOGIN TAMPILKAN YANG DIBAWAH INI -->
                <!-- <li class="menu-item menu-item-has-children account-mobile">
                    <a href="#" data-toggle="sub-menu">
                        <iconify-icon icon="mingcute:user-4-fill"></iconify-icon>
                        Muhamad Rafli(Reseller)
                    </a>
                    <ul class="sub-menu">
                        <li class="menu-item">
                            <a href="">Profil</a>
                        </li>
                        <li class="menu-item">
                            <a href="">Keluar</a>
                        </li>
                    </ul>
                </li> -->
                <!-- SETELAH USER LOGIN TAMPILKAN YANG DIATAS INI -->

             </ul>
           </nav>
           <div class="btn-menu">

                <button class="btn-search" onclick="togglePopup('searchPopup')" style="cursor:pointer;">
                    <iconify-icon icon="mdi:search"></iconify-icon>
                </button>
                <a href="{{ url('/cart') }}">
                    <button class="cart-menu">
                        <iconify-icon icon="ph:shopping-cart-simple-light"></iconify-icon>
                        <!-- <iconify-icon icon="mdi:cart"></iconify-icon> -->
                        <div class="cart-amount-menu">
                            @if (session('cart'))
                                <span>{{ count(session('cart')) }}</span>
                                @else
                                <span>0</span>
                            @endif
                        </div>
                    </button>
                </a>
                <div class="open-nav-menu hamburger-menu">
                    <iconify-icon icon="ci:hamburger-lg"></iconify-icon>
                </div>
            </div>

           <!-- navigation menu end -->
        </div>
    </div>

    <div class="popup hide-popup" id="searchPopup">
        <div class="main-popup">
            <div class="overlay-popup" onclick="togglePopup('searchPopup')"></div>
            <div class="search-box">
                <input type="text" placeholder="Cari disini...">
                <iconify-icon icon="gala:search"></iconify-icon>
            </div>
        </div>
    </div>
  </header>

@yield('content')

<div class="footer">
    <div class="footer-layout container">
      <div class="menu-footer-item-first menu-footer-item ">
        <div class="logo-footer">
          <img src="images/logo-white.png" alt="">
        </div>
        <p>Jl Patrakomala no.49 Merdeka, Kec. Sumur Bandung, Kota Bandung, Jawa Barat 40113</p>
        <span>cs@hooflakids.com</span>
      </div>
      <div class="menu-footer-item">
        <h3>Informasi</h3>
        <ul>
          <li><a href="contact.php">Kontak Kami</a></li>
          <li><a href="faq.php">FAQ</a></li>
          <li><a href="gabung-reseller.php">Cara Gabung Kemitraan</a></li>
        </ul>
      </div>
      <div class="menu-footer-item">
        <h3>Kategori</h3>
        <ul>
          <?php for ($i = 0; $i < 5; $i++) : ?>
            <li><a href="">Aksesoris</a></li>
          <?php endfor; ?>
        </ul>
      </div>
      <div class="menu-footer-item">
        <h3>Media Sosial</h3>
        <ul>
          <li><a href=""><iconify-icon icon="uil:facebook"></iconify-icon> Hooflakids</a></li>
          <li><a href=""><iconify-icon icon="ri:instagram-line"></iconify-icon> @hooflakidswear</a></li>
          <li><a href=""><iconify-icon icon="mdi:youtube"></iconify-icon> hooflakidswear</a></li>
          <li><a href=""><iconify-icon icon="ic:baseline-tiktok"></iconify-icon> hooflaofficial</a></li>
        </ul>
      </div>
    </div>
    <div class="copyright container">
      <span>Copyright © HOOFLAKIDS. All rights reserved</span>
    </div>
  </div>

  <script src="js/tab-image.js"></script>
  <script src="js/menu.js"></script>
  <script src="js/toggle.js"></script>
  <script src="js/wishlist-btn-card.js"></script>
  <script src="js/sort-category.js"></script>
  <script src="js/faq.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <!-- SCRIPT UNTUK POPUP -->
  <script>
      function togglePopup(popupId) {
              const popupElement = document.getElementById(popupId);

              popupElement.classList.toggle("show-popup");
              popupElement.classList.toggle("hide-popup");
          }
  </script>

  <!-- SCRIPT UNTUK SELECT PELANGGAN/CUSTOMER KE FORM RESELLER-->
  <script>
      const customerSelect = document.getElementById("customerSelect");
      const penerimaInput = document.getElementById("penerimaInput");
      const formCustomer = document.querySelector(".form-customer");

      customerSelect.addEventListener("change", function() {
          formCustomer.style.display = this.value ? "block" : "none";
      });
  </script>
  <!-- SCRIPT HANYA UNTUK MERUBAH WARNA -->
  <script>
  // Optionally, you can use JavaScript to add more dynamic behavior
  // Optionally, you can use JavaScript to add more dynamic behavior
  const textInputs = document.querySelectorAll(".input-focus");

  textInputs.forEach(textInput => {
      textInput.addEventListener("focus", function() {
          this.style.backgroundColor = "#25D366";
          this.style.color = "white";
      });

      textInput.addEventListener("blur", function() {
          if (!this.value) {
              this.style.backgroundColor = "";
              this.style.color = "";
          }
      });
  });
  </script>
  <script>
    var buttonAddCart = document.getElementsByClassName("add-cart");

  // Menambahkan event listener untuk setiap elemen dengan kelas 'btn-product-style'
  for (var b = 0; b < buttonAddCart.length; b++) {
      buttonAddCart[b].addEventListener("click", function() {
          // Toggle kelas 'active' pada elemen yang diklik
          this.classList.toggle("active-btn-cart");
      });
  }
  </script>
  <!-- <script>
    function adjustSelectWidth() {
              var select = document.getElementById('selectStyle');
              var options = select.options;
              var maxWidth = 0;

              for (var i = 0; i < options.length; i++) {
                  var textWidth = getTextWidth(options[i].text, select.style.font);
                  maxWidth = Math.max(maxWidth, textWidth);
              }

              select.style.width = maxWidth + 'px';
          }

          function getTextWidth(text, font) {
              var canvas = document.createElement("canvas");
              var context = canvas.getContext("2d");
              context.font = font;
              var metrics = context.measureText(text);
              return metrics.width;
          }

          // Setel lebar awal saat halaman dimuat
          adjustSelectWidth();
  </script> -->
  <script>
      var bannerSlide = new Swiper(".myBanner", {
          loop: true,
          effect: "fade",
          lazy: true,
          autoHeight: true,
          pagination: {
              el: ".swiper-pagination",
              clickable: true,
          },
      });
    </script>
    <script>
      var productSlide = new Swiper(".myProduct", {
        slidesPerView: 2,
        spaceBetween: 10,
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
        breakpoints: {
          360: {
            slidesPerView: 2,
            spaceBetween: 10,
          },
          768: {
            slidesPerView: 3,
            spaceBetween: 15,
          },
          1024: {
            slidesPerView: 4,
            spaceBetween: 20,
          },
          1191: {
            slidesPerView: 4,
            spaceBetween: 20,
          },
        },
      });
    </script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#logoutForm').on('submit', function (e) {
                    e.preventDefault(); // Menghentikan pengiriman form

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You will log out now!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Logout!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Jika pengguna mengonfirmasi, kirimkan form
                            $('#logoutForm').off('submit'); // Matikan event handler agar tidak ada konfirmasi tambahan
                            $('#logoutForm').submit(); // Kirim form logout setelah konfirmasi
                        }
                    });
                });
            });
        </script>
  </body>
  </html>
