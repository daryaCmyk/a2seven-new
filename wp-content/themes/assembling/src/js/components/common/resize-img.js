 $(window).on('load', function(){
    resizeImg ();
 });
 export default function resizeImg () {
    let image = document.querySelectorAll('.gallery-item__image-wrap img');
    if(image) {
       image.forEach( function(element) {
          let WidthImage = element.scrollWidth;
          let HeightImage = WidthImage / 1;   
          element.style.height = HeightImage + 'px';
       });
    }
}