@extends('layouts.admin.navfootbar')
@section('content')
    <div class="container">
        <div class="heading heading-page">
            Kontak Kami
        </div>
        <div class="form-contact">
            <div class="form-contact-layout">
                <div class="form-box">
                    <label for="">Nama Lengkap</label>
                    <input type="text" placeholder="Nama Lengkap Kamu">
                </div>
                <div class="form-box">
                    <label for="">Email</label>
                    <input type="email" placeholder="Email Kamu">
                </div>
                <div class="form-box">
                    <label for="">Nomor Telepon</label>
                    <input type="email" placeholder="Nomor Telepon Kamu">
                </div>
            </div>
            <div class="form-contact-message">
                <div class="form-box">
                    <label for="">Pesan</label>
                    <textarea name="" id="" rows="4" placeholder="Pesan Kamu"></textarea>
                </div>
            </div>
            <button>Kirim Pesan</button>
        </div>
        <div class="social-media-contact">
            <div class="box-social-media-contact">
                <div class="box-icon-social-media-contact">
                    <img src="images/instagram.png" alt="">
                </div>
                <p>@hooflakidswear</p>
            </div>
            <div class="box-social-media-contact">
                <div class="box-icon-social-media-contact">
                    <img src="images/tiktok.png" alt="">
                </div>
                <p>hooflaofficial</p>
            </div>
            <div class="box-social-media-contact">
                <div class="box-icon-social-media-contact">
                    <img src="images/shopee.png" alt="">
                </div>
                <p>hooflakidsclothing</p>
            </div>
            <div class="box-social-media-contact">
                <div class="box-icon-social-media-contact" onclick="togglePopup('whatsappPopup')">
                    <img src="images/whatsapp.png" alt="">
                </div>
                <button onclick="togglePopup('whatsappPopup')">Klik Whatsapp Disini</button>
            </div>
        </div>
    </div>

    <div class="popup hide-popup" id="whatsappPopup">
        <div class="main-popup">
            <div class="overlay-popup" onclick="togglePopup('whatsappPopup')"></div>
            <div class="layout-popup layout-popup-short">
                <div class="popup-form-box">
                    <div class="heading-popup">
                        <h3>Pelayanan Pelanggan</h3>
                        <iconify-icon icon="mingcute:close-line" onclick="togglePopup('whatsappPopup')"></iconify-icon>
                    </div>
                    <div class="content-popup">
                        <div class="layout-whatsapp">
                            <a href="">
                                <div class="box-popup-whatsapp">
                                    <iconify-icon icon="logos:whatsapp-icon"></iconify-icon>
                                    <span>Customer Service 1</span>
                                </div>
                            </a>
                            <a href="">
                                <div class="box-popup-whatsapp">
                                    <iconify-icon icon="logos:whatsapp-icon"></iconify-icon>
                                    <span>Customer Service 2</span>
                                </div>
                            </a>
                            <a href="">
                                <div class="box-popup-whatsapp">
                                    <iconify-icon icon="logos:whatsapp-icon"></iconify-icon>
                                    <span>Customer Service 2</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
