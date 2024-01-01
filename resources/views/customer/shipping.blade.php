@extends('layouts.admin.navfootbar')
@section('content')
<div>
    <div class="heading heading-page">
        Opsi Pengiriman
    </div>
    <div class="information-layout container">
        <div class="login-box-layout">
            <form action="{{ url('/confirmation') }}" method="post">@csrf
                <label for="" class="label-single">Pilih Ekspedisi</label>
                <div class="form-box__shipping">
                    @foreach ($ongkos as $item)
                    @foreach ($item['costs'] as $detail)
                    <label class="shipping-radio">
                        <input type="radio" name="cost" value="{{ $detail['service'] }}" checked/>
                        <span>
                            <div class="heading-shipping-method">
                                <h3>JNE -  {{ $detail['service'] }} ({{ $detail['description'] }})</h3>
                                @foreach ($detail['cost'] as $harga)
                                <p>{{ $harga['etd'] }} Days</p>
                                <p class="price-mobile-sidebar">Rp. {{ number_format($harga['value']) }} ,-</p>
                            </div>
                            <div class="price-shipping">
                                <h5>Rp. {{ number_format($harga['value']) }} ,-</h5>
                            </div>
                            @endforeach
                        </span>
                    </label>
                    @endforeach
                    @endforeach
                </div>
                <div class="form-box">
                    <label for="alamat">Pengiriman Ke Alamat</label>
                    <textarea name="alamat_lengkap" rows="3" placeholder="Isi Alamat Pengiriman Kamu" required></textarea>
                </div>
                <div>
                    {{-- <label class="remind">
                        <input type="checkbox" required>
                        <span class="checkmark"></span>
                        Simpan data ini untuk nanti
                    </label> --}}
                </div>
                <div class="informasi-layout-button__form informasi-layout-button__form-shipping">
                    <a href="{{ url('/informasi') }}"><button class="back__btn">Kembali ke Informasi</button></a>
                    <button type="submit">Lanjutkan Pembayaran</button>
                </div>
            </form>
        </div>
        <div class="sidebar-informasi-layout">
            <div class="sidebar-informasi-overflow">
                <?php $total = 0; ?>
                @foreach (session('cart') as $cart)
                <div class="sidebar-informasi-box">
                    <div class="sidebar-informasi__image">
                        <img src="images/1.jpg" alt="">
                    </div>
                    <div class="sidebar-informasi__desc">
                        <h4>{{ $cart['nama'] }}</h4>
                        <span>{{ $cart['size'] }} {{ $cart['color'] }}</span>
                        <span>{{ $cart['qty'] }} Pcs</span>
                        <span class="price-mobile-sidebar">Rp. {{ number_format($cart['price']) }} ,-</span>
                    </div>
                    <div class="sidebar-informasi__price">
                        <span>Rp. {{ number_format($cart['price']) }} ,-</span>
                    </div>
                </div>
                <?php $total += $cart['price_total'] ?>
                @endforeach
            </div>
            <div class="sidebar-informasi__total">
                <div class="sidebar-informasi__total-box">
                    <span>Berat</span>
                    <span>{{ $cart['package_weight'] }} Kg</span>
                </div>
            </div>
            {{-- <div class="sidebar-informasi__total">
                <div class="sidebar-informasi__total-box">
                    <span>Ongkir</span>
                    <span>Rp. 0.0 ,-</span>
                </div>
                <div class="sidebar-informasi__total-box">
                    <span>Diskon</span>
                    <span>-</span>
                </div>
            </div> --}}
            <div class="sidebar-informasi__total">
                <div class="sidebar-informasi__total-box">
                    <span>Kode Kupon</span>
                    <input type="text" class="input-focus">
                </div>
            </div>
            <div class="sidebar-informasi__total">
                <div class="sidebar-informasi__total-box">
                    <span>Kode Referal</span>
                    <input type="text" class="input-focus">
                </div>
            </div>
            <div class="sidebar-informasi__total sidebar-informasi__total-main">
                <div class="sidebar-informasi__total-box">
                    <span>Total</span>
                    <span>Rp. {{ number_format($total) }} ,-</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
