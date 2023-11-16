import {serializeObject, requestsArticle} from './components/common/filter-service'

let tag = '';

var productsList = document.querySelector('.vacancy-wrap');

let data = {
    'action' : 'get_jobs',
    'tag' : '',
    'lang' : document.querySelector('html').lang
}

var tags = document.querySelectorAll('.vacancy-tags__item');
if(tags) {
    let activeTag = document.querySelector('.tags-item--active');
    tags.forEach(element => {
        element.addEventListener("click", function(evt) {
            if(activeTag !== evt.currentTaget) {
                activeTag.classList.remove('tags-item--active');
                activeTag = element;
                activeTag.classList.add('tags-item--active');

                tag = element.dataset.vacancy;
                data.tag = tag;

                requestsArticle(serializeObject(data), null, productsList);
            }
        })
    });
}