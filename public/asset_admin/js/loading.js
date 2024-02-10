document.onreadystatechange = function () {
    if (document.readyState === "complete") {
        // Semua sumber daya telah dimuat, sembunyikan elemen loading
        document.getElementById('loading-overlay').style.display = 'none';
    }
};
