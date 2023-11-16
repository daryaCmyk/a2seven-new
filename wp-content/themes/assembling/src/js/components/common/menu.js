function menu() {
    $(".header-menu li > a").each(function(e) {
		$(this).wrapInner('<span></span>') 
	});
}
menu()

var header = document.querySelector('.header');
var last;
var bool = false;
var menuMobile = document.querySelector('.mobile-menu-open');

// $(document).bind('touchmove', function(e){
// 	var current = e.originalEvent.touches[0].clientY;
// 	if(current >= last){
// 		console.log('Движение пальцем вверх');
		
// 		if(menuMobile.classList.contains('active') === false) {
// 			header.classList.remove('hide');
// 			bool = false;
// 		} 
// 	} else if(current < last){
// 		console.log('Движение пальцем вниз');
// 		if(bool === false) {  
// 			if(menuMobile.classList.contains('active') === false) {
// 				header.classList.add('hide');
// 				bool = true;
// 			} 
// 		}
// 	}
// 	last = current;
// });

$(document).bind('scroll', function(e){
	var current =  window.pageYOffset || document.documentElement.scrollTop;
	if(current >= last){
		if(menuMobile.classList.contains('active') === false) {
			header.classList.add('hide');
			bool = true;
		} 
	} else if(current < last){
		if(menuMobile.classList.contains('active') === false) {
			header.classList.remove('hide');
			bool = false;
		} 
	}
	last = current;
});
