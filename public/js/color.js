document.addEventListener("DOMContentLoaded", function () {
    const tabButtonsColor = document.querySelectorAll(".tab-button-color");

    tabButtonsColor.forEach(button => {
        button.addEventListener("click", () => {
            const tabId = button.getAttribute("data-tab-color");

            // Hide all tab contents
            document.querySelectorAll('.tab-content-color').forEach(content => content.classList.remove("active-color"));

            // Show the selected tab content
            document.getElementById(tabId).classList.add("active-color");

            // Reset Swiper to the first slide
            tabImageSwiper.slideTo(0);

            // Reset active class for tab buttons
            tabButtonsColor.forEach(btn => btn.classList.remove("active-color"));
            button.classList.add("active-color");
        });
    });
});
