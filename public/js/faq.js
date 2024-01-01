var acc = document.getElementsByClassName("faq-accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    var isActive = this.classList.contains("faq-active");
    
    // Menutup semua accordion yang sedang terbuka
    for (var j = 0; j < acc.length; j++) {
      acc[j].classList.remove("faq-active");
      acc[j].nextElementSibling.style.maxHeight = null;
    }
    
    // Membuka accordion yang diklik jika belum terbuka
    if (!isActive) {
      this.classList.add("faq-active");
      var panel = this.nextElementSibling;
      panel.style.maxHeight = panel.scrollHeight + "px";
    }
  });
}