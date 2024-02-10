@extends('layouts.admin.navfootbar')
@section('content')
<div>
    <div class="heading heading-page">
        Konfirmasi Pembelian
    </div>
    <div class="information-layout container">
        <div class="login-box-layout">
            <form action="" method="post">
                <div class="form-box">
                    <label for="no-telp">Nama Penerima</label>
                    <input type="text" value="{{ session('user')['name'] }}" required>
                </div>
                <div class="form-box">
                    <label for="alamat">Pengiriman Ke Alamat</label>
                    <textarea name="alamat_lengkap" rows="3" required>{{ session('user')['alamat_lengkap'] }}</textarea>
                </div>
                <div class="form-box">
                    <label for="no-telp">Metode Pengiriman</label>
                    <input type="text" value="{{ $transaksi->shipping_method }}" required>
                </div>
                <div class="informasi-layout-button__form informasi-layout-button__form-shipping">
                    <a href="{{ url('information') }}"><button class="back__btn">Kembali ke Pengiriman</button></a>
                    <button type="button" id="pay-button">Bayar Sekarang</button>
                </div>
            </form>
        </div>
        <div class="sidebar-informasi-layout">
            <div class="sidebar-informasi-overflow">
                <?php $total = 0; ?>
                @foreach ($carts as $cart)
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
                    <span>0.45kg</span>
                </div>
            </div>
            <div class="sidebar-informasi__total">
                <div class="sidebar-informasi__total-box">
                    <span>Ongkir</span>
                    <span>Rp. {{ number_format($cost) }} ,-</span>
                </div>
                {{-- <div class="sidebar-informasi__total-box">
                    <span>Diskon</span>
                    <span>-</span>
                </div> --}}
            </div>
            {{-- <div class="sidebar-informasi__total">
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
            </div> --}}
            <div class="sidebar-informasi__total sidebar-informasi__total-main">
                <div class="sidebar-informasi__total-box">
                    <span>Total</span>
                    <span>Rp. {{ number_format($total + $cost) }} ,-</span>
                </div>
            </div>
        </div>
    </div>
</div>
<html>
    <head>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
      <script type="text/javascript"
        {{-- src="https://app.midtrans.com/snap/snap.js" --}}
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
      <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
    </head>

    <body>

      <script type="text/javascript">
        // For example trigger on button clicked, or any time you need
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
          // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
          window.snap.pay('{{ $snap_token }}', {
            onSuccess: function(result){
              /* You may add your own implementation here */
              alert("payment success!"); console.log(result);
            },
            onPending: function(result){
              /* You may add your own implementation here */
              alert("wating your payment!"); console.log(result);
            },
            onError: function(result){
              /* You may add your own implementation here */
              alert("payment failed!"); console.log(result);
            },
            onClose: function(){
              /* You may add your own implementation here */
              alert('you closed the popup without finishing the payment');
            }
          })
        });
      </script>
    </body>
  </html>
@endsection
