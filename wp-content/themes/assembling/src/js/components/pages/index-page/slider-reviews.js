let autoplayOpt = false;
if(document.querySelector('.slider-reviews') && document.querySelector('.slider-reviews').classList.contains('slider-reviews--auto')) {
    autoplayOpt = {
        delay: 10000,
        disableOnInteraction: false,
    }
}
// Инициализация слайдера отзывов
const swiperReviews = new Swiper('.slider-reviews', {
    loop: true,
    speed: 800,
    autoHeight: true,
    spaceBetween: 40,
    pagination: {
        el: '.slider-reviews__pagination',
        clickable: true,
    },

    autoplay: autoplayOpt
});