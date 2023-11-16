// Определение максимальной высоты слайдера
function getMaxOfArray(numArray) {
    return Math.max.apply(null, numArray);
}

window.addEventListener('load', function () {
    const aboutSlider = document.querySelector('.slider-main .swiper-wrapper');
    const aboutSlides = document.querySelectorAll('.slider-main__slide');
    const aboutContent = document.querySelectorAll('.slider-main__slide-content');
    if (aboutSlider && aboutSlides.length > 0 && aboutContent.length > 0) {
        var heights = []
        aboutContent.forEach(element => {
          let height = element.offsetHeight
          heights.push(height)
        });
        if(window.screen.width > 1600) {
            aboutSlider.style.height = getMaxOfArray(heights) + 'px';
        }
    }
    
    // Инициализация слайдеров
    const swiper = new Swiper('.slider-titles', {
        loop: true,
        speed: 1200,
        allowTouchMove: false,
    });

    const swiperMain = new Swiper('.slider-main', {
        loop: true,
        speed: 1200,
        allowTouchMove: true,
        spaceBetween: 20,
        pagination: {
            el: '.slider-main__pagination',
            clickable: true,
        },
        thumbs: {
            swiper: swiper
        },

        autoplay: {
            delay: 12000,
            disableOnInteraction: false,
        },

        breakpoints: {
            993: {
                direction: "vertical",
                spaceBetween: 40,
                allowTouchMove: false,
            }
        },

        on: {
            slideChange: ()=> {
                document.querySelector('.slider-content__line').classList.remove('active');
                setTimeout(() => {
                    document.querySelector('.slider-content__line').classList.add('active');
                }, 50);
            },
        },
    });

    // Переключение слайдеров
    var activeSlide = document.querySelector('.slider-thumbs__item-active');
    var activeIndex = activeSlide.dataset.slide;
    var sliderNumber = document.querySelector('.slider-content__number');

    $('.slider-thumbs__item').click(function(el){
        if(activeIndex != el.currentTarget.dataset.slide) {
            $('.slider-thumbs__item').removeClass('slider-thumbs__item-active');
            activeIndex = el.currentTarget.dataset.slide;
            $(el.currentTarget).addClass('slider-thumbs__item-active')
            swiperMain.slideTo(activeIndex);
            sliderNumber.textContent =  activeIndex.padStart(2, '0');
        }
    });

    swiperMain.on('slideChange', function () {
        if(activeIndex != swiperMain.activeIndex) {
            $('.slider-thumbs__item').removeClass('slider-thumbs__item-active');
            activeIndex = swiperMain.activeIndex;
            realIndex = swiperMain.realIndex + 1;
            $(`.slider-thumbs__item[data-slide='${realIndex}']`).addClass('slider-thumbs__item-active')
            sliderNumber.textContent = String(realIndex).padStart(2, '0');
        }
    });
});


$(window).resize(function () {
    let sliderPagination = document.querySelector('.slider-main__pagination');
    if(window.screen.width > 993) {
        if(sliderPagination) {
            if(sliderPagination.classList.contains('swiper-pagination-vertical') === false) {
                sliderPagination.classList.add('swiper-pagination-vertical');
            }

            if(sliderPagination.classList.contains('swiper-pagination-horizontal') === true) {
                sliderPagination.classList.remove('swiper-pagination-horizontal');
            }
        }
    } else {
        if(sliderPagination) {
            if(sliderPagination.classList.contains('swiper-pagination-vertical') === true) {
                sliderPagination.classList.remove('swiper-pagination-vertical');
            }

            if(sliderPagination.classList.contains('swiper-pagination-horizontal') === false) {
                sliderPagination.classList.add('swiper-pagination-horizontal');
            }
        }
    }
 }).resize();