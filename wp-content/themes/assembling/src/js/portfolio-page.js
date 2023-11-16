import {serializeObject, requestsArticle} from './components/common/filter-service'

let paged = 1;
let stopFlag = false;
let tag = 'all';

var productsList = document.querySelector('.project__wrap');

let data = {
    'action' : 'get_articles',
    'page' : '',
    'tag' : '',
    'lang' : document.querySelector('html').lang
}

const scrollToSecScr=()=>{
    let footerShow=document.querySelector('.footer');
    if (document.documentElement.scrollTop>footerShow.getBoundingClientRect().top && !$('body').hasClass('loading') && !stopFlag) {
        paged++;

        data.page = paged;
        data.tag = tag;

        $('body').addClass('loading')
        requestsArticle(serializeObject(data), 'scroll', productsList);
    }
}
window.addEventListener('scroll',scrollToSecScr);

var tags = document.querySelectorAll('.project__tags-item');
if(tags) {
    let activeTag = document.querySelector('.tags-item--active');
    tags.forEach(element => {
        element.addEventListener("click", function(evt) {
            if(activeTag !== evt.currentTaget) {
                activeTag.classList.remove('tags-item--active');
                activeTag = element;
                activeTag.classList.add('tags-item--active');

                tag = element.dataset.tag;
                paged = 1;

                data.page = paged;
                data.tag = tag;

                requestsArticle(serializeObject(data), 'list', productsList);
            }
        })
    });
}