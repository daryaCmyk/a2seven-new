function openMobileMenu(event) {
	event.preventDefault();

	if( this.classList.contains('active') ) {
		this.classList.remove('active')

		Array.prototype.slice.call(document.querySelectorAll('.sub-menu')).forEach(function(el) {
			el.classList.remove('active')
		})

		document.querySelector('.mobile-menu').classList.remove('opened')
		document.querySelector('body').classList.remove('opened')
	} else {
		this.classList.add('active')
		document.querySelector('.mobile-menu').classList.add('opened')
		document.querySelector('body').classList.add('opened')
	}
}
document.querySelector('.mobile-menu-open').onclick = openMobileMenu



function mobileMenu() {
	$(".mobile-menu li.menu-item-has-children > a").each(function(e) {
		$(this).wrapInner('<span></span>')
		$(this).append('<svg role="img"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="'+ window.templateUrl +'/static/images/sprite.svg#plus"></use></svg>');
		$(this).addClass('collapsed');
	});

	$(".mobile-menu li.menu-item-has-children > .sub-menu").each(function(e) {
		$(this).addClass('is-collapsed');
	});
}
mobileMenu()

let spoilers = document.querySelectorAll('.collapsed');
function delegate(eventName, elementSelector, handler,listener=document){
	if (!listener)
		return false;
		
	listener.addEventListener(eventName, function(e){
		if(e.target.classList.contains('collapsed') || e.target.parentNode.classList.contains('collapsed')) {
			e.preventDefault();
		}
		for (var target = e.target; target && target != this; target = target.parentNode) {
			if (target.matches(elementSelector)) {
				handler.call(target, e, target);
				break;
			}
		}
	});
}

function onSchedule(fn) {
	requestAnimationFrame(function() {
		requestAnimationFrame(function() {
		  fn();
		});
	});
}

function isCollapsed(element) {
	return element.classList.contains('is-collapsed');
}

function slideOpen(element, toggle=false){
	if (toggle){
		toggle.classList.add('toggle-active')
	}
	element.style.height = `${element.scrollHeight}px`;
	onSchedule(function(){
		element.classList.remove('is-collapsed');
		element.addEventListener("transitionend", function onTransitionEnd() {
			element.removeEventListener("transitionend", onTransitionEnd);
			element.style.height = "";
		});  
	})
}

function slideClose(element, toggle=false){
	if (toggle){
		toggle.classList.remove('toggle-active')
	}
	element.style.height = `${element.scrollHeight}px`;
	onSchedule(function() {
		element.classList.add('is-collapsed');
		element.style.height = "";
	});
}

function slideToggle(element, toggle=false){
	isCollapsed(element) ? slideOpen(element, toggle) : slideClose(element, toggle);
}

delegate('click', '.collapsed', (event, btn) => {
    slideToggle(btn.nextElementSibling)
    btn.parentNode.classList.toggle('spoiler--active')
})
