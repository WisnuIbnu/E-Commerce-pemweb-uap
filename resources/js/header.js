// Mobile Menu Toggle
const hamburgerBtn = document.getElementById('hamburgerBtn');
const mobileMenu = document.getElementById('mobileMenu');
const mobileOverlay = document.getElementById('mobileOverlay');
const closeMenuBtn = document.getElementById('closeMenuBtn');

function openMobileMenu() {
    mobileMenu.classList.add('active');
    mobileOverlay.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeMobileMenu() {
    mobileMenu.classList.remove('active');
    mobileOverlay.classList.remove('active');
    document.body.style.overflow = '';
}

hamburgerBtn.addEventListener('click', openMobileMenu);
closeMenuBtn.addEventListener('click', closeMobileMenu);
mobileOverlay.addEventListener('click', closeMobileMenu);

// Mobile Dropdown Toggle
const dropdownItems = document.querySelectorAll('[data-dropdown]');

dropdownItems.forEach(item => {
    const link = item.querySelector('.mobile-nav-link');
    link.addEventListener('click', (e) => {
        e.preventDefault();
        item.classList.toggle('active');
    });
});
