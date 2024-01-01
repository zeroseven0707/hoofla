const saveButtons = document.querySelectorAll('.wishlist-card-button');

saveButtons.forEach(button => {
    button.addEventListener('click', () => {
        const isSaved = button.getAttribute('data-saved') === 'true';
        
        if (isSaved) {
            button.innerHTML = '<iconify-icon icon="mdi:heart-outline"></iconify-icon>';
            button.setAttribute('data-saved', 'false');
        } else {
            button.innerHTML = '<iconify-icon icon="mdi:heart"></iconify-icon>';
            button.setAttribute('data-saved', 'true');
        }
    });
});