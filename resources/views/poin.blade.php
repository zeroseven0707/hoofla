
@extends('layouts.admin.navfootbar')
@section('content')
<div class="container container-small">
    {{-- <div class="heading heading-page">
        POIN
    </div> --}}
    {{--
        <div class="saldo-detail">
            <div class="saldo-form">
                <label for="saldo">Poin Kamu</label>
                <input type="text" value="Rp. 350.000 ,-" class="input-black">
            </div>
            <div class="saldo-form">
                <label for="dapat-ditarik">Dapat ditarik</label>
                <input type="text" value="Rp. 0 ,-" class="input-green">
            </div>
            <div class="saldo-form">
                <label for="tertahan">Tertahan</label>
                <input type="text" value="Rp. 0 ,-" class="input-yellow">
            </div>
        </div> --}}

    <div class="tab-riwayat tab-riwayat-pelanggan">
        <button class="tablinksRiwayat" onclick="openRiwayat(event, 'isi-saldo')" id="defaultOpen">Poin</button>
        <button class="tablinksRiwayat" onclick="openRiwayat(event, 'riwayat-pembayaran')" >Riwayat</button>
        {{-- <button class="tablinksRiwayat" onclick="openRiwayat(event, 'tarik-saldo')" id="defaultOpen">Tarik Saldo</button> --}}
    </div>

    <div class="tab-riwayat-content">
        <div id="isi-saldo" class="tabcontentRiwayat">
            <div class="topup-saldo">
                <div class="form-topup-saldo">
                    <label for="">Poin mu</label>
                    <input type="number" value="10" readonly>
                    <br>
                    <span>
                        <p>Kami senang mempersembahkan kepada Anda Program Poin yang memberikan Anda keuntungan setiap kali Anda berbelanja dengan kami. Dalam sistem ini, setiap kali Anda melakukan pembelian di toko kami, Anda akan menerima satu poin untuk setiap Rp 100.000 yang Anda belanjakan.</p><br>
                        <p>Ini berarti bahwa setiap poin yang Anda dapatkan setara dengan Rp 100.000 dalam pembelian Anda berikutnya. Jadi, semakin banyak Anda berbelanja, semakin banyak pula poin yang Anda kumpulkan, dan semakin besar juga keuntungan yang Anda dapatkan!</p><br>
                        <p>Kami berharap Anda menikmati manfaat dari Program Poin ini dan terus berbelanja dengan kami untuk mendapatkan lebih banyak poin dan keuntungan. Jika Anda memiliki pertanyaan lebih lanjut tentang Program Poin kami, jangan ragu untuk menghubungi layanan pelanggan kami.</p><br>
                        <p>Terima kasih atas dukungan Anda!</p>
                    </span>
                </div>
                <div class="btn-topup">
                    {{-- <a href="#"><button>Isi Ulang Saldo</button></a> --}}
                    {{-- <span>Biaya Admin: Rp. 2.500</span> --}}
                </div>
            </div>
        </div>
        <div id="riwayat-pembayaran" class="tabcontentRiwayat">
            <div class="pesanan-layout-top pesanan-layout-top-pelanggan">
                <div class="pesanan-layout-top__box">
                    <div class="search-box-page search-box-page-pelanggan">
                        <input type="text" placeholder="Cari Riwayat">
                        <iconify-icon icon="ic:round-search"></iconify-icon>
                    </div>
                </div>
                <div class="pesanan-layout-top__box">
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
            </div>

            <div class="table-layout table-layout-five-col">
                <table>
                    <tr>
                        <th>No</th>
                        <th>Nominal</th>
                        <th>Deskripsi</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Rp. 124.000 ,-</td>
                        <td>Pembelian pakaian sabina one set</td>
                        <td>26 - 09 - 2023</td>
                        <td><button class="btn-edit bg-green" onclick="togglePopup('editCustomer')">Lunas</button></td>
                    </tr>
                </table>
            </div>
        </div>
        {{-- <div id="tarik-saldo" class="tabcontentRiwayat">
            <div class="topup-saldo">
                <div class="form-topup-saldo">
                    <label for="">Jumlah Penarikan Dana</label>
                    <input type="number" id="withdraw-amount" placeholder="Masukkan disini" oninput="calculateTotal()">
                </div>
                <div class="form-withdraw-layout">
                    <div class="form-withdraw">
                        <label for="nama-bank">Nama Bank Tujuan</label>
                        <div class="select-style-saldo">
                            <select name="">
                                <option default>Pilih Bank</option>
                                <option value="bank-sinarmas">Bank Sinarmas</option>
                                <option value="bank-syariah-mandiri">Bank Syariah Mandiri</option>
                                <option value="bank-mandiri">Bank Mandiri</option>
                            </select>
                            <iconify-icon icon="octicon:chevron-down-12"></iconify-icon>
                        </div>
                    </div>
                    <div class="form-withdraw">
                        <label for="nomor-rekening">Nomor Rekening</label>
                        <input type="number">
                    </div>
                    <div class="form-withdraw">
                        <label for="nama-rekening">Nama Pemilik Rekening</label>
                        <input type="text">
                    </div>
                </div>
                <div class="btn-topup">
                    <div class="withdraw-content">
                        <h5>Total + Fee</h5>
                        <h2 id="total-amount">Rp. 0,-</h2>
                    </div>
                    <a href="#"><button>Tarik Dana</button></a>
                </div>
            </div>
        </div> --}}
    </div>

</div>

<script>
    function calculateTotal() {
        // Get the withdrawal amount
        var withdrawalAmount = $("#withdraw-amount").val();

        // Check if withdrawalAmount is empty or not a number
        if (withdrawalAmount === "" || isNaN(withdrawalAmount)) {
            // If empty or not a number, set total amount to 0
            $("#total-amount").text("Rp. 0,-");
        } else {
            // Convert withdrawal amount to integer
            withdrawalAmount = parseInt(withdrawalAmount);

            // You can adjust the fee calculation as per your requirements
            var fee = 2500; // Example fee amount

            // Calculate the total amount including fee
            var totalAmount = withdrawalAmount + fee;

            // Update the total amount in the UI
            $("#total-amount").text("Rp. " + totalAmount.toLocaleString() + ",-");
        }
    }
</script>

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
