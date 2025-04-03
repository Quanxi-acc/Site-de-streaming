let currentIndex = 0;

const carouselContainer = document.querySelector('.carousel-container');
const items = document.querySelectorAll('.carousel-item');
const totalItems = items.length;

// Boutons pour navigation
document.querySelector('.next').addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % totalItems; // Repart à 0 après la dernière image
    updateCarousel();
});

document.querySelector('.prev').addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + totalItems) % totalItems; // Repart à la fin après la première image
    updateCarousel();
});

function updateCarousel() {
    carouselContainer.style.transition = 'transform 0.5s ease-in-out';
    carouselContainer.style.transform = `translateX(-${currentIndex * (100 / 3)}%)`;
}
