@extends('layouts.admin.navfootbar')
@section('content')
<div class="container">
    <div class="heading heading-page">
        Riwayat Pesanan
    </div>

    <div class="pesanan-layout-top">
        <div class="pesanan-layout-top__box">
            <div class="search-box-page">
                <input type="text" placeholder="Cari Pelanggan">
                <iconify-icon icon="ic:round-search"></iconify-icon>
            </div>
            <!-- script js = js/date.js -->
            <div class="date-layout">
                <button id="dateRangeButton" class="dynamic-button">Pilih Rentang Tanggal</button>
                <div id="dateRangePopup" class="popup-date">
                    <ul>
                        <li id="todayOption">Hari Ini</li>
                        <li id="yesterdayOption">Kemarin</li>
                        <li id="last7daysOption">7 Hari Terakhir</li>
                        <li id="thisMonthOption">Bulan Ini</li>
                        <li id="lastMonthOption">Bulan Kemarin</li>
                    </ul>
                </div>
            </div>
            <!-- script js = js/date.js -->
        </div>
        <div class="pesanan-layout-top__box">
            <div class="sort-category">
                <label>Atur Berdasarkan : </label>
                <div class="select-style-product">
                    <select name="" id="sortDropdown" onChange="handleCategorySortChange()">
                    <option value="nama-pelanggan">Nama Pelanggan</option>
                        <option value="nomor-po">Nomor PO</option>
                        <option value="nomor-resi">Nomor Resi</option>
                    </select>
                    <iconify-icon icon="octicon:chevron-down-12"></iconify-icon>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-riwayat">
        <button class="tablinksRiwayat" onclick="openRiwayat(event, 'belum-bayar')" id="defaultOpen">Belum di bayar</button>
        <button class="tablinksRiwayat" onclick="openRiwayat(event, 'menunggu-konfirmasi')">Menunggu Konfirmasi</button>
        <button class="tablinksRiwayat" onclick="openRiwayat(event, 'dikonfirmasi')">Dikonfirmasi</button>
        <button class="tablinksRiwayat" onclick="openRiwayat(event, 'dalam-perjalanan')">Dalam Perjalanan</button>
        <button class="tablinksRiwayat" onclick="openRiwayat(event, 'diterima')">Diterima</button>
        <button class="tablinksRiwayat" onclick="openRiwayat(event, 'dibatalkan')">Dibatalkan</button>
    </div>

    <div class="tab-riwayat-content">
        <div id="belum-bayar" class="tabcontentRiwayat">
            @foreach ($pending as $pending)
            <div class="pesanan-container">
            @foreach ($pending['detran'] as $detrans)
                <div class="cart-product-box-pesanan">
                    <div class="cart-product-detail">
                        <div class="cart-product-image">
                            @foreach ($detrans->product['images'] as $key => $images)
                            @if ($key==1)
                            <img src="{{ asset('/storage'.'/'.$images['path']) }}" alt="">
                            @endif
                            @endforeach
                        </div>
                        <div class="cart-product-name">
                            <h3>{{ $detrans->product->item_group_name }}</h3>
                            <p>{{ $detrans->variations->warna }}</p>
                            <div class="quantity-mobile">
                                <input type="text" value="1">
                            </div>
                            <div class="price-mobile">
                                <span>Rp.{{ number_format($detrans->variations->reseller_price) }} ,-</span>
                            </div>
                            {{-- <a href="remove-cart/0"><button>Hapus</button></a> --}}
                        </div>
                    </div>
                    <div class="cart-product-quantity">
                        <div class='qty-layout'>
                            <input type="text" value="{{ $detrans['qty'] }}" id="qty"/>
                        </div>
                    </div>
                    <div class="product-layout-price">
                        @if ($pending->type == 'reseller')
                        <span>Rp. {{ number_format($detrans->variations->reseller_price) }} ,-</span>
                        @elseif($pending->type == 'agen')
                        <span>Rp. {{ number_format($detrans->variations->agen_price) }} ,-</span>
                        @elseif($pending->type == 'distributor')
                        <span>Rp. {{ number_format($detrans->variations->distributor_price) }} ,-</span>
                        @else
                        <span>Rp. {{ number_format($detrans->variations->dropshipper_price) }} ,-</span>
                        @endif
                    </div>
                    <div class="product-layout-price">
                        <span>Rp. {{ number_format($detrans['total']) }} ,-</span>
                    </div>
                </div>
                @endforeach
                <div class="cart-product-box-pesanan-second">
                    <div class="cart-product-detail-pesanan cart-product-detail">
                        <div class="cart-product-image">
                        </div>
                        <div class="expedition-name cart-product-name">
                            <h3>{{ $pending['shipping_method'] }}</h3>
                        </div>
                    </div>
                    <div class="product-layout-price-pesanan product-layout-price">
                        <span class="heading-pesanan-mobile">Berat :</span>
                        <span>{{ number_format($detrans->variations->product->package_weight) }} kg</span>
                        {{-- <span>0.236 Kg</span> --}}
                    </div>
                    <div class="product-layout-price-pesanan product-layout-price">
                        <span class="heading-pesanan-mobile">Ongkos Kirim :</span>
                        <span>Rp. {{ number_format($pending['cost']) }} ,-</span>
                    </div>
                    <div class="product-layout-price-pesanan product-layout-price">
                        <span class="heading-pesanan-mobile">Total :</span>
                        <span>Rp. {{ number_format($pending['cost']+$pending['total_bayar']) }} ,-</span>
                    </div>
                </div>
                <div class="cart-product-box-pesanan-third">
                    <div class="form-box">
                        <label for="">Nama Pelanggan</label>
                        <input type="text" value="{{ $pending['penerima'] }}" readonly>
                    </div>
                    <div class="form-box">
                        <label for="">Status Pembayaran</label>
                        <input type="text" value="Belum Bayar" class="bg-red" readonly>
                    </div>
                    <div class="form-box">
                        <label for="">Nomor Resi</label>
                        <input type="text" value="-" readonly>
                    </div>
                </div>
                <div class="cart-product-box-pesanan-four">
                    <span class="order-detail">
                    {{ $pending->code_inv }}
                    {{-- -  Selasa, 7 November 2023 --}}
                    </span>
                    {{-- <a href="">
                        <div class="send-to">
                            <iconify-icon icon="ion:open"></iconify-icon>
                            <span>Lihat Detail Pesanan</span>
                        </div>
                    </a> --}}
                </div>
            </div>
            @endforeach
        </div>

        <div id="menunggu-konfirmasi" class="tabcontentRiwayat">
            @foreach ($paid as $paid)
            <div class="pesanan-container">
                @foreach ($paid['detran'] as $detrans)
                    <div class="cart-product-box-pesanan">
                        <div class="cart-product-detail">
                            <div class="cart-product-image">
                                @foreach ($detrans->product['images'] as $key => $images)
                                @if ($key==1)
                                <img src="{{ asset('/storage'.'/'.$images['path']) }}" alt="">
                                @endif
                                @endforeach
                            </div>
                            <div class="cart-product-name">
                                <h3>{{ $detrans->product->item_group_name }}</h3>
                                <p>{{ $detrans->variations->warna }}</p>
                                <div class="quantity-mobile">
                                    <input type="text" value="1">
                                </div>
                                <div class="price-mobile">
                                    <span>Rp.{{ number_format($detrans->variations->reseller_price) }} ,-</span>
                                </div>
                                {{-- <a href="remove-cart/0"><button>Hapus</button></a> --}}
                            </div>
                        </div>
                        <div class="cart-product-quantity">
                            <div class='qty-layout'>
                                <input type="text" value="{{ $detrans['qty'] }}" id="qty"/>
                            </div>
                        </div>
                        <div class="product-layout-price">
                            @if ($paid->type == 'reseller')
                            <span>Rp. {{ number_format($detrans->variations->reseller_price) }} ,-</span>
                            @elseif($paid->type == 'agen')
                            <span>Rp. {{ number_format($detrans->variations->agen_price) }} ,-</span>
                            @elseif($paid->type == 'distributor')
                            <span>Rp. {{ number_format($detrans->variations->distributor_price) }} ,-</span>
                            @else
                            <span>Rp. {{ number_format($detrans->variations->dropshipper_price) }} ,-</span>
                            @endif
                        </div>
                        <div class="product-layout-price">
                            <span>Rp. {{ number_format($detrans['total']) }} ,-</span>
                        </div>
                    </div>
                @endforeach
                <div class="cart-product-box-pesanan-second">
                    <div class="cart-product-detail-pesanan cart-product-detail">
                        <div class="cart-product-image">
                        </div>
                        <div class="expedition-name cart-product-name">
                            <h3>{{ $paid['shipping_method'] }}</h3>
                        </div>
                    </div>
                    <div class="product-layout-price-pesanan product-layout-price">
                        <span class="heading-pesanan-mobile">Berat :</span>
                        <span>{{ number_format($detrans->variations->product->package_weight) }} kg</span>
                        {{-- <span>0.236 Kg</span> --}}
                    </div>
                    <div class="product-layout-price-pesanan product-layout-price">
                        <span class="heading-pesanan-mobile">Ongkos Kirim :</span>
                        <span>Rp. {{ number_format($paid['cost']) }} ,-</span>
                    </div>
                    <div class="product-layout-price-pesanan product-layout-price">
                        <span class="heading-pesanan-mobile">Total :</span>
                        <span>Rp. {{ number_format($paid['cost']+$paid['total_bayar']) }} ,-</span>
                    </div>
                </div>
                <div class="cart-product-box-pesanan-third">
                    <div class="form-box">
                        <label for="">Nama Pelanggan</label>
                        <input type="text" value="{{ $paid['penerima'] }}" readonly>
                    </div>
                    <div class="form-box">
                        <label for="">Status Pembayaran</label>
                        <input type="text" value="Lunas" class="bg-green" readonly>
                    </div>
                    <div class="form-box">
                        <label for="">Nomor Resi</label>
                        <input type="text" value="-" readonly>
                    </div>
                </div>
                <div class="cart-product-box-pesanan-four">
                    <span class="order-detail">
                    {{ $paid->code_inv }}
                    {{-- -  Selasa, 7 November 2023 --}}
                    </span>
                    {{-- <a href="">
                        <div class="send-to">
                            <iconify-icon icon="ion:open"></iconify-icon>
                            <span>Lihat Detail Pesanan</span>
                        </div>
                    </a> --}}
                </div>
            </div>
        @endforeach
        </div>

        <div id="dikonfirmasi" class="tabcontentRiwayat">
            <div class="pesanan-container">
                <div class="cart-product-box-pesanan">
                    <div class="cart-product-detail">
                        <div class="cart-product-image">
                            <img src="images/1.jpg" alt="">
                        </div>
                        <div class="cart-product-name">
                            <h3>Sabina One Seat</h3>
                            <p>Pink - Tosca</p>
                            <div class="quantity-mobile">
                                <input type="text" value="1">
                            </div>
                            <div class="price-mobile">
                                <span>Rp. 121.000 ,-</span>
                            </div>
                            <a href="remove-cart/0"><button>Hapus</button></a>
                        </div>
                    </div>
                    <div class="cart-product-quantity">
                        <div class='qty-layout'>
                            <input type="text" value="1" id="qty"/>
                        </div>
                    </div>
                    <div class="product-layout-price">
                        <span>Rp. 121.000 ,-</span>
                    </div>
                    <div class="product-layout-price">
                        <span>Rp. 121.000 ,-</span>
                    </div>
                </div>
                <div class="cart-product-box-pesanan-second">
                    <div class="cart-product-detail-pesanan cart-product-detail">
                        <div class="cart-product-image">
                        </div>
                        <div class="expedition-name cart-product-name">
                            <h3>SiCepat - REGULAR</h3>
                        </div>
                    </div>
                    <div class="product-layout-price-pesanan product-layout-price">
                        <span class="heading-pesanan-mobile">Berat :</span>
                        <span>0.236 Kg</span>
                    </div>
                    <div class="product-layout-price-pesanan product-layout-price">
                        <span class="heading-pesanan-mobile">Ongkos Kirim :</span>
                        <span>Rp. 16.000 ,-</span>
                    </div>
                    <div class="product-layout-price-pesanan product-layout-price">
                        <span class="heading-pesanan-mobile">Total :</span>
                        <span>Rp. 137.000 ,-</span>
                    </div>
                </div>
                <div class="cart-product-box-pesanan-third">
                    <div class="form-box">
                        <label for="">Nama Pelanggan</label>
                        <input type="text" value="Muhamad Rafli">
                    </div>
                    <div class="form-box">
                        <label for="">Status Pembayaran</label>
                        <input type="text" value="Lunas" class="bg-green">
                    </div>
                    <div class="form-box">
                        <label for="">Nomor Resi</label>
                        <input type="text" value="-">
                    </div>
                </div>
                <div class="cart-product-box-pesanan-four">
                    <span class="order-detail">
                    Order #206871  -  Selasa, 7 November 2023
                    </span>
                    <a href="">
                        <div class="send-to">
                            <iconify-icon icon="ion:open"></iconify-icon>
                            <span>Lihat Detail Pesanan</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div id="dalam-perjalanan" class="tabcontentRiwayat">
            <div class="pesanan-container">
                <div class="cart-product-box-pesanan">
                    <div class="cart-product-detail">
                        <div class="cart-product-image">
                            <img src="images/1.jpg" alt="">
                        </div>
                        <div class="cart-product-name">
                            <h3>Sabina One Seat</h3>
                            <p>Pink - Tosca</p>
                            <div class="quantity-mobile">
                                <input type="text" value="1">
                            </div>
                            <div class="price-mobile">
                                <span>Rp. 121.000 ,-</span>
                            </div>
                            <a href="remove-cart/0"><button>Hapus</button></a>
                        </div>
                    </div>
                    <div class="cart-product-quantity">
                        <div class='qty-layout'>
                            <input type="text" value="1" id="qty"/>
                        </div>
                    </div>
                    <div class="product-layout-price">
                        <span>Rp. 121.000 ,-</span>
                    </div>
                    <div class="product-layout-price">
                        <span>Rp. 121.000 ,-</span>
                    </div>
                </div>
                <div class="cart-product-box-pesanan-second">
                    <div class="cart-product-detail-pesanan cart-product-detail">
                        <div class="cart-product-image">
                        </div>
                        <div class="expedition-name cart-product-name">
                            <h3>SiCepat - REGULAR</h3>
                        </div>
                    </div>
                    <div class="product-layout-price-pesanan product-layout-price">
                        <span class="heading-pesanan-mobile">Berat :</span>
                        <span>0.236 Kg</span>
                    </div>
                    <div class="product-layout-price-pesanan product-layout-price">
                        <span class="heading-pesanan-mobile">Ongkos Kirim :</span>
                        <span>Rp. 16.000 ,-</span>
                    </div>
                    <div class="product-layout-price-pesanan product-layout-price">
                        <span class="heading-pesanan-mobile">Total :</span>
                        <span>Rp. 137.000 ,-</span>
                    </div>
                </div>
                <div class="cart-product-box-pesanan-third">
                    <div class="form-box">
                        <label for="">Nama Pelanggan</label>
                        <input type="text" value="Muhamad Rafli">
                    </div>
                    <div class="form-box">
                        <label for="">Status Pembayaran</label>
                        <input type="text" value="Lunas" class="bg-green">
                    </div>
                    <div class="form-box">
                        <label for="">Nomor Resi</label>
                        <input type="text" value="-">
                    </div>
                </div>
                <div class="cart-product-box-pesanan-four">
                    <span class="order-detail">
                    Order #206871  -  Selasa, 7 November 2023
                    </span>
                    <a href="">
                        <div class="send-to">
                            <iconify-icon icon="ion:open"></iconify-icon>
                            <span>Lihat Detail Pesanan</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div id="diterima" class="tabcontentRiwayat">
            <div class="pesanan-container">
                <div class="cart-product-box-pesanan">
                    <div class="cart-product-detail">
                        <div class="cart-product-image">
                            <img src="images/1.jpg" alt="">
                        </div>
                        <div class="cart-product-name">
                            <h3>Sabina One Seat</h3>
                            <p>Pink - Tosca</p>
                            <div class="quantity-mobile">
                                <input type="text" value="1">
                            </div>
                            <div class="price-mobile">
                                <span>Rp. 121.000 ,-</span>
                            </div>
                            <a href="remove-cart/0"><button>Hapus</button></a>
                        </div>
                    </div>
                    <div class="cart-product-quantity">
                        <div class='qty-layout'>
                            <input type="text" value="1" id="qty"/>
                        </div>
                    </div>
                    <div class="product-layout-price">
                        <span>Rp. 121.000 ,-</span>
                    </div>
                    <div class="product-layout-price">
                        <span>Rp. 121.000 ,-</span>
                    </div>
                </div>
                <div class="cart-product-box-pesanan-second">
                    <div class="cart-product-detail-pesanan cart-product-detail">
                        <div class="cart-product-image">
                        </div>
                        <div class="expedition-name cart-product-name">
                            <h3>SiCepat - REGULAR</h3>
                        </div>
                    </div>
                    <div class="product-layout-price-pesanan product-layout-price">
                        <span class="heading-pesanan-mobile">Berat :</span>
                        <span>0.236 Kg</span>
                    </div>
                    <div class="product-layout-price-pesanan product-layout-price">
                        <span class="heading-pesanan-mobile">Ongkos Kirim :</span>
                        <span>Rp. 16.000 ,-</span>
                    </div>
                    <div class="product-layout-price-pesanan product-layout-price">
                        <span class="heading-pesanan-mobile">Total :</span>
                        <span>Rp. 137.000 ,-</span>
                    </div>
                </div>
                <div class="cart-product-box-pesanan-third">
                    <div class="form-box">
                        <label for="">Nama Pelanggan</label>
                        <input type="text" value="Muhamad Rafli">
                    </div>
                    <div class="form-box">
                        <label for="">Status Pembayaran</label>
                        <input type="text" value="Lunas" class="bg-green">
                    </div>
                    <div class="form-box">
                        <label for="">Nomor Resi</label>
                        <input type="text" value="-">
                    </div>
                </div>
                <div class="cart-product-box-pesanan-four">
                    <span class="order-detail">
                    Order #206871  -  Selasa, 7 November 2023
                    </span>
                    <a href="">
                        <div class="send-to">
                            <iconify-icon icon="ion:open"></iconify-icon>
                            <span>Lihat Detail Pesanan</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div id="dibatalkan" class="tabcontentRiwayat">
            <div class="pesanan-container">
                <div class="cart-product-box-pesanan">
                    <div class="cart-product-detail">
                        <div class="cart-product-image">
                            <img src="images/1.jpg" alt="">
                        </div>
                        <div class="cart-product-name">
                            <h3>Sabina One Seat</h3>
                            <p>Pink - Tosca</p>
                            <div class="quantity-mobile">
                                <input type="text" value="1">
                            </div>
                            <div class="price-mobile">
                                <span>Rp. 121.000 ,-</span>
                            </div>
                            <a href="remove-cart/0"><button>Hapus</button></a>
                        </div>
                    </div>
                    <div class="cart-product-quantity">
                        <div class='qty-layout'>
                            <input type="text" value="1" id="qty"/>
                        </div>
                    </div>
                    <div class="product-layout-price">
                        <span>Rp. 121.000 ,-</span>
                    </div>
                    <div class="product-layout-price">
                        <span>Rp. 121.000 ,-</span>
                    </div>
                </div>
                <div class="cart-product-box-pesanan-second">
                    <div class="cart-product-detail-pesanan cart-product-detail">
                        <div class="cart-product-image">
                        </div>
                        <div class="expedition-name cart-product-name">
                            <h3>SiCepat - REGULAR</h3>
                        </div>
                    </div>
                    <div class="product-layout-price-pesanan product-layout-price">
                        <span class="heading-pesanan-mobile">Berat :</span>
                        <span>0.236 Kg</span>
                    </div>
                    <div class="product-layout-price-pesanan product-layout-price">
                        <span class="heading-pesanan-mobile">Ongkos Kirim :</span>
                        <span>Rp. 16.000 ,-</span>
                    </div>
                    <div class="product-layout-price-pesanan product-layout-price">
                        <span class="heading-pesanan-mobile">Total :</span>
                        <span>Rp. 137.000 ,-</span>
                    </div>
                </div>
                <div class="cart-product-box-pesanan-third">
                    <div class="form-box">
                        <label for="">Nama Pelanggan</label>
                        <input type="text" value="Muhamad Rafli">
                    </div>
                    <div class="form-box">
                        <label for="">Status Pembayaran</label>
                        <input type="text" value="Lunas" class="bg-green">
                    </div>
                    <div class="form-box">
                        <label for="">Nomor Resi</label>
                        <input type="text" value="-">
                    </div>
                </div>
                <div class="cart-product-box-pesanan-four">
                    <span class="order-detail">
                    Order #206871  -  Selasa, 7 November 2023
                    </span>
                    <a href="">
                        <div class="send-to">
                            <iconify-icon icon="ion:open"></iconify-icon>
                            <span>Lihat Detail Pesanan</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openRiwayat(evt, TabName) {
  var i, tabcontentriwayat, tablinksRiwayat;
  tabcontentriwayat = document.getElementsByClassName("tabcontentRiwayat");
  for (i = 0; i < tabcontentriwayat.length; i++) {
    tabcontentriwayat[i].style.display = "none";
  }
  tablinksRiwayat = document.getElementsByClassName("tablinksRiwayat");
  for (i = 0; i < tablinksRiwayat.length; i++) {
    tablinksRiwayat[i].className = tablinksRiwayat[i].className.replace("active-riwayat", "");
  }
  document.getElementById(TabName).style.display = "block";
  evt.currentTarget.className += " active-riwayat";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>
@endsection
