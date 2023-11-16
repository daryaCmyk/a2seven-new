$(".footer-btn-languages > ul > li.menu-item-has-children > a").each(function(e) {
	$(this).append('<svg role="img"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="'+ window.templateUrl +'/static/images/sprite.svg#menu"></use></svg>');
})

$(".footer-btn-languages > ul li:not(.menu-item-has-children) a").each(function(e) {
    $(this).wrapInner('<span></span>') 
});

let btnLang = $(".footer-btn-languages > ul > li.menu-item-has-children > a");
let submenu = $(".footer-btn-languages > ul > li.menu-item-has-children > .sub-menu");

btnLang.on("click", function (evt) {
    evt.preventDefault();
    submenu.toggleClass('sub-menu--open');
});

$(document).click(function (e) {
    if (!btnLang.is(e.target) && !submenu.is(e.target) && submenu.has(e.target).length === 0) {
        submenu.removeClass("sub-menu--open");
    };
});