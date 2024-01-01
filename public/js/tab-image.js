document.addEventListener("DOMContentLoaded", function () {
    // Inisialisasi Swiper untuk image tabs
    const tabSwiper = new Swiper('.image-product-tab', {
        slidesPerView: 4,
        spaceBetween: 10,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });

    if (tabSwiper && tabSwiper.slideTo) {
        const tabButtons = document.querySelectorAll(".image-product-tab-box");
        const images = document.querySelectorAll(".image-product-page-main img");

        tabButtons.forEach((button, index) => {
            button.addEventListener("click", () => {
                // Set active class based on the clicked tab
                tabButtons.forEach(btn => btn.classList.remove("activeTabImage"));
                button.classList.add("activeTabImage");

                // Hide/show images in image-product-page-main
                images.forEach((image, imageIndex) => {
                    image.classList.toggle("hidden-image", imageIndex !== index);
                });

                // Hide/show images in image-product-tab
                tabButtons.forEach((tabImage, tabIndex) => {
                    tabImage.classList.toggle("hidden-image", tabIndex !== index);
                });

                // Slide to the corresponding tab on tabSwiper
                tabSwiper.slideTo(index);
            });
        });
    } else {
        console.error("Swiper initialization failed");
    }
    console.log(tabSwiper);
});



function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
  }
  
  // Get the element with id="defaultOpen" and click on it
  document.getElementById("defaultOpen").click();