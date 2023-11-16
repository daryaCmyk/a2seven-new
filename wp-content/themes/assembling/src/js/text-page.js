import resizeImg from './components/common/resize-img';
import './components/pages/index-page/company';
import './components/pages/index-page/slider-reviews';

// Обертка таблицы на текстовых
const wrapTable = function() {
    let contextTab = document.querySelectorAll('.content-text table');
    if(contextTab.length > 0) {
        document.querySelectorAll('.content-text table').forEach(el => {

        let prev = el.previousElementSibling;
        if(prev) {
            if( prev.tagName == 'H2' ) prev.classList.add('for-table');
        }  
 
        let table = document.createElement("div");
        table.className = "table";

        let wrapper = document.createElement("div");
        wrapper.className = "table__responsive";
        
        el.before(table);
        if(prev) {
            table.append(prev);
        }
        
        wrapper.append(el);
        table.append(wrapper);
        })
    }
}
wrapTable();


// Включение/выключение видео
let btnVideo = document.querySelectorAll('.video-preview');
if(btnVideo) {
    btnVideo.forEach(element => {
        element.addEventListener("click", function() {
            let videoWrap = element.parentElement;
            var player = videoWrap.querySelector(".video-item").contentWindow; // Moved here
            if(videoWrap.classList.contains('video-play')) {
                if(player) {
                    player.postMessage('{"event": "command", "func": "pauseVideo", "args": ""}', "*");
                }
            } else {
                if(player) {
                    player.postMessage('{"event": "command", "func": "playVideo", "args": ""}', "*");
                }
            }
            videoWrap.classList.toggle('video-play');
        })
    });
}

var galleryCountSlide = 1;
if(window.screen.width > 992) {
    galleryCountSlide = 3;
} else if(window.screen.width > 582) {
    galleryCountSlide = 2;
} else {
    galleryCountSlide = 1;
}

var swiperGallery;

var sliderArray = document.querySelectorAll('.gallery-wrap');
var swiperArr = [];
sliderArray.forEach(slider => {
    const countSliders = slider.querySelectorAll('.swiper-slide').length;
    swiperGallery = new Swiper(slider, {
        speed: 1200,
        allowTouchMove: true,
        loop: countSliders > galleryCountSlide,
        spaceBetween: 20,
        
        autoplay: {
            delay: 5000,
        },

        breakpoints: {
            320: {
                slidesPerView: 1,
            },
            582: {
                slidesPerView: 2
            },
            992: {
                slidesPerView: 3,
            }
        }
    });

    swiperArr.push(swiperGallery);
});

let body = document.querySelector('body');

let observer = new MutationObserver(function(mutations) {
    for (let mutation of mutations) {
        if (mutation.type === 'attributes') {
            if (body.classList.contains('fancybox-active')) {
                if(swiperArr.length > 0) {
                    swiperArr.forEach(slider => {
                        slider.autoplay.stop();
                    });
                }
            } else {
                if(swiperArr.length > 0) {
                    swiperArr.forEach(slider => {
                        slider.autoplay.start();
                    });
                }
            }
        }
    }
});

observer.observe(body, { attributes: true });

$(window).resize(function () {
    if(swiperArr.length > 0) {
        swiperArr.forEach(slider => {
            slider.autoplay.start();
        });
    }

    resizeImg ();
 }).resize();

// Галерея-слайдер
const swiperText = new Swiper('.swiper-gallery', {
    speed: 1200,
    allowTouchMove: true,
    spaceBetween: 20,
    pagination: {
        el: '.gallery-slider__pagination',
        clickable: true,
    },
});