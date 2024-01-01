

document.addEventListener("DOMContentLoaded", function () {
    const popupMenuMobileVar = document.getElementById('userPopup');
    const toggleButton = document.getElementById('toggleButtonUser');

    // Tambahkan event listener untuk toggle popup saat tombol diklik
    toggleButton.addEventListener('click', function () {
        popupMenuMobileVar.classList.toggle('active-userPopup');
    });

    // Tambahkan event listener untuk menutup popup saat scroll
    window.addEventListener('scroll', function () {
        // Periksa apakah popup sedang terbuka sebelum menutupnya
        if (popupMenuMobileVar.classList.contains('active-userPopup')) {
            popupMenuMobileVar.classList.remove('active-userPopup');
        }
    });

    // Tambahkan event listener untuk menutup popup saat mengklik di luar popup
    document.addEventListener('click', function (event) {
        // Periksa apakah yang diklik berada di luar popup
        if (!popupMenuMobileVar.contains(event.target) && !toggleButton.contains(event.target)) {
            // Tutup popup jika sedang terbuka
            if (popupMenuMobileVar.classList.contains('active-userPopup')) {
                popupMenuMobileVar.classList.remove('active-userPopup');
            }
        }
    });
});
