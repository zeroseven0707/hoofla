@extends('layouts.admin.navfootbar')
@section('content')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<div class="cart-page container">
    <div class="heading heading-page">
        Pesanan Saya
    </div>

    <div class="cart-product-body-heading">
        <h3>Rincian Produk</h3>
        <h3>Kuantitas</h3>
        <h3>Harga</h3>
        <h3>Total</h3>
    </div>
    @foreach ($transaction as $item)
    <div class="pesanan-container">
        @foreach ($item['detran'] as $detrans)
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
                    @if ($item->type == 'reseller')
                    <span>Rp. {{ number_format($detrans->variations->reseller_price) }} ,-</span>
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
                    <h3>{{ $item['shipping_method'] }}</h3>
                </div>
            </div>
            <div class="product-layout-price-pesanan product-layout-price">
                <span class="heading-pesanan-mobile">Berat :</span>
                <span>{{ number_format($detrans->variations->product->package_weight) }} Kg</span>
            </div>
            <div class="product-layout-price-pesanan product-layout-price">
                <span class="heading-pesanan-mobile">Ongkos Kirim :</span>
                <span>Rp. {{ number_format($item['cost']) }} ,-</span>
            </div>
            <div class="product-layout-price-pesanan product-layout-price">
                <span class="heading-pesanan-mobile">Total :</span>
                <span>Rp. {{ number_format($item['cost']+$item['total_bayar']) }} ,-</span>
            </div>
        </div>
        <div class="cart-product-box-pesanan-third">
            <div class="form-box">
                <label for="">Nama Penerima</label>
                <input type="text" value="{{ $item['penerima'] }}">
            </div>
            <div class="form-box">
                <label for="">Nomor Telepon</label>
                {{-- <input type="text" value="{{ $item->pelanggan->no_telp }}"> --}}
            </div>
            <div class="form-box">
                <label for="">Alamat Penerima</label>
                <input type="text" value="{{ $item['alamat_lengkap'] }}">
            </div>
        </div>
        <div class="cart-product-box-pesanan-four">
            <div>
                <label class="remind">
                    {{-- <input type="checkbox" name="code_inv[]" value="{{ $item['code_inv'] }}" required>
                    <span class="checkmark"></span> --}}
                     {{  $item['code_inv']  }}
                </label>
            </div>
            {{-- <span>Komisi Rp {{ number_format($item['commission']) }} -,</span> --}}
            <div class="send-to">
                <iconify-icon icon="mdi:truck"></iconify-icon>
                {{-- <span>{{ $item->pelanggan->name }}</span> --}}
            </div>

        </div>
    </div>
    @endforeach
</div>
<div class="checkout-button-pesanan checkout-button container">
    <div class="checkout-button-layout container">
        {{-- <div>
            <label class="remind">
                <input type="checkbox" name="semua" id="selectAllCheckbox" required>
                <span class="checkmark"></span>
                Pilih Semua
            </label>
        </div> --}}
        {{-- <button class="checkout-button__option">
            1 Pesanan dipilih
        </button> --}}
        <div class="total-produk-pesanan total-produk">
            <span>Total ({{$count}} Transaksi):</span>
            <h3>Rp. {{ number_format($payment->total) }},-</h3>
        </div>
        <div class="button-checkout-pesanan">
            <a href="">
                <button class="checkout-button_shop">
                    Lanjut Belanja
                </button>
            </a>
            <button class="checkout-button__next" id="pay-button">
                Bayar Sekarang
            </button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        // Handle "Pilih Semua" checkbox change event
        $('#selectAllCheckbox').change(function () {
            // Get the state of the "Pilih Semua" checkbox
            var isChecked = $(this).prop('checked');

            // Set the state of all checkboxes in pesanan-container
            $('.pesanan-container input[type="checkbox"]').prop('checked', isChecked);
        });

        // Handle individual pesanan-container checkbox change event
        $('.pesanan-container input[type="checkbox"]').change(function () {
            // Uncheck all other checkboxes
            $('.pesanan-container input[type="checkbox"]').not(this).prop('checked', false);

            // Update the state of the "Pilih Semua" checkbox based on individual checkboxes
            var allChecked = $('.pesanan-container input[type="checkbox"]:checked').length === $('.pesanan-container input[type="checkbox"]').length;
            $('#selectAllCheckbox').prop('checked', allChecked);
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var checkboxes = document.querySelectorAll('input[name="semua"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                // Dapatkan nilai checkbox
                var isChecked = this.checked;
                // var codeInv = this.value;

                // Dapatkan token CSRF dari meta tag
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Kirim permintaan AJAX ke server
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/payment-reseller', true);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken); // Setel token CSRF
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Tangani respons dari server jika diperlukan
                        console.log(xhr.responseText);
                    }
                };
                xhr.send(JSON.stringify({ codeInv: codeInv, isChecked: isChecked }));
            });
        });
    });
</script>

@endsection
