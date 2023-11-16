import {serializeObject, requestsArticle} from './components/common/filter-service'

let paged = 1;
let tag = '';
let idCat = document.querySelector('.blog-page').dataset.cat;

var productsList = document.querySelector('.blog__wrap .blog-row');
let postCount = productsList.querySelectorAll('.blog-item__wrap')
var buttonLoadShow=document.querySelector('.blog-btn-load');

var data = {
    'action' : 'get_blogs',
    'page' : '',
    'tag' : '',
    'cat' : idCat,
    'postCount' : '',
    'lang' : document.querySelector('html').lang
}


const btnLoad=()=>{
    if(buttonLoadShow) {
        buttonLoadShow.addEventListener("click", function() {
            paged++;
            postCount = productsList.querySelectorAll('.blog-item__wrap')
            blShow.classList.add('load');
            document.querySelector('body').classList.add('loading')

            data.tag = tag;
            data.page = paged;
            data.postCount = postCount.length;

            requestsArticle(serializeObject(data), 'scroll', productsList);
        })
    }
}
btnLoad();

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
                postCount = 0;

                if(buttonLoadShow) {
                    buttonLoadShow.classList.add('load');
                }

                data.tag = tag;
                data.page = paged;
                data.postCount = postCount.length;
                
                document.querySelector('body').classList.add('loading')

                requestsArticle(serializeObject(data), 'list', productsList);
            }
        })
    });
}