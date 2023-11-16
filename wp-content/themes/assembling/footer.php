				<?php
				global $idContactPage;
				global $idVacancyPage;
				if(!is_page($idContactPage) && !is_404()):
					wp_reset_postdata();
					$params = [ 'id' => get_the_ID()];
					if(get_field('form-footer', get_the_ID()) == 'vacancy'): ?>
						<?php get_template_part('includes/form-vacancy', null, $params); ?>
						<script>
							<?php $form1Group = get_field('vacancy__send-ok-group', 'option'); ?>

							window.formTitle = '<?php echo $form1Group['send-ok__form-title']; ?>';
							window.formTitle2 = '<?php echo $form1Group['send-ok__title']; ?>';
							window.formText = '<?php echo $form1Group['send-ok__text']; ?>';
						</script>
					<?php else: ?>
						<section class="section-form">
							<div class="container">
								<div class="row">
									<div class="col-md-8">
										<?php get_template_part('includes/form-consultation', null, $params); ?>
									</div>
								</div>
							</div>
						</section>
						<script>
							<?php $form1Group = get_field('send-ok-group', 'option'); ?>

							window.formTitle = '<?php echo $form1Group['send-ok__form-title']; ?>';
							window.formTitle2 = '<?php echo $form1Group['send-ok__title']; ?>';
							window.formText = '<?php echo $form1Group['send-ok__text']; ?>';

						</script>

					<?php endif; ?>
				<?php elseif(is_page($idContactPage)): ?>
					<script>
						<?php $form1Group = get_field('send-ok-group', 'option'); ?>

						window.formTitle = '<?php echo $form1Group['send-ok__form-title']; ?>';
						window.formTitle2 = '<?php echo $form1Group['send-ok__title']; ?>';
						window.formText = '<?php echo $form1Group['send-ok__text']; ?>';
					</script>
				<?php  endif; ?>
			</main>

			<footer class="footer">
				<div class="container">
					<div class="footer__wrap">
						<p class="footer__text">© 2009-<?php echo date('Y'); ?> <?php the_field('company-name', 'option'); ?>. <?php the_field('word-rights', 'option'); ?>.</p>
						<div class="footer__contact">
							<?php if(get_field('facebook-link', 'option')): ?>
								<a class="footer__contact-item" href="<?php the_field('facebook-link', 'option'); ?>" target="_blank">
									<svg role="img">
										<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?php bloginfo('template_url'); ?>/static/images/sprite.svg#facebook-svg"></use>
									</svg>
								</a>
							<?php endif; ?>
							<?php if(get_field('insta-link', 'option')): ?>
								<a class="footer__contact-item" href="<?php the_field('insta-link', 'option'); ?>" target="_blank">
									<svg role="img">
										<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?php bloginfo('template_url'); ?>/static/images/sprite.svg#instagram-svg"></use>
									</svg>
								</a>
							<?php endif; ?>
							<?php if(get_field('vk-link', 'option')): ?>
								<a class="footer__contact-item" href="<?php the_field('vk-link', 'option'); ?>" target="_blank">
									<svg role="img">
										<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?php bloginfo('template_url'); ?>/static/images/sprite.svg#vk-svg"></use>
									</svg>
								</a>
							<?php endif; ?>
							<?php if(get_field('youtube-link', 'option')): ?>
								<a class="footer__contact-item" href="<?php the_field('youtube-link', 'option'); ?>" target="_blank">
									<svg role="img">
										<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?php bloginfo('template_url'); ?>/static/images/sprite.svg#youtube-svg"></use>
									</svg>
								</a>
							<?php endif; ?>
							<?php if(get_field('behance-link', 'option')): ?>
								<a class="footer__contact-item" href="<?php the_field('behance-link', 'option'); ?>" target="_blank">
									<svg role="img">
										<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?php bloginfo('template_url'); ?>/static/images/sprite.svg#behance-svg"></use>
									</svg>
								</a>
							<?php endif; ?>
						</div>
						<?/*<nav class="footer__lang dropdown footer-btn-languages">
							<ul>
								<?php wp_nav_menu( array('menu'=>'choose-language', 'container' => false, 'items_wrap' => '%3$s') );?>
							</ul>
						</nav>*/?>
					</div>
				</div>
			</footer>
		</div>
<!--        <script src="/wp-content/themes/assembling/static/js/ajax-form.js"></script>-->
		<script>
			window.ajaxUrl = '<?php echo site_url() ?>/wp-admin/admin-ajax.php';
			window.templateUrl = '<?php bloginfo('template_url'); ?>';
		</script>

		<?php the_field('footer_script', 'option'); ?>

		<?php do_action('wp_footer'); ?>

		<!-- Cookies -->
		<script>
			/*! js-cookie v3.0.0-rc.1 | MIT */
			!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?module.exports=t():"function"==typeof define&&define.amd?define(t):(e=e||self,function(){var n=e.Cookies,r=e.Cookies=t();r.noConflict=function(){return e.Cookies=n,r}}())}(this,function(){"use strict";function e(e){for(var t=1;t<arguments.length;t++){var n=arguments[t];for(var r in n)e[r]=n[r]}return e}var t={read:function(e){return e.replace(/(%[\dA-F]{2})+/gi,decodeURIComponent)},write:function(e){return encodeURIComponent(e).replace(/%(2[346BF]|3[AC-F]|40|5[BDE]|60|7[BCD])/g,decodeURIComponent)}};return function n(r,o){function i(t,n,i){if("undefined"!=typeof document){"number"==typeof(i=e({},o,i)).expires&&(i.expires=new Date(Date.now()+864e5*i.expires)),i.expires&&(i.expires=i.expires.toUTCString()),t=encodeURIComponent(t).replace(/%(2[346B]|5E|60|7C)/g,decodeURIComponent).replace(/[()]/g,escape),n=r.write(n,t);var c="";for(var u in i)i[u]&&(c+="; "+u,!0!==i[u]&&(c+="="+i[u].split(";")[0]));return document.cookie=t+"="+n+c}}return Object.create({set:i,get:function(e){if("undefined"!=typeof document&&(!arguments.length||e)){for(var n=document.cookie?document.cookie.split("; "):[],o={},i=0;i<n.length;i++){var c=n[i].split("="),u=c.slice(1).join("=");'"'===u[0]&&(u=u.slice(1,-1));try{var f=t.read(c[0]);if(o[f]=r.read(u,f),e===f)break}catch(e){}}return e?o[e]:o}},remove:function(t,n){i(t,"",e({},n,{expires:-1}))},withAttributes:function(t){return n(this.converter,e({},this.attributes,t))},withConverter:function(t){return n(e({},this.converter,t),this.attributes)}},{attributes:{value:Object.freeze(o)},converter:{value:Object.freeze(r)}})}(t,{path:"/"})});

			async function getData(url) {
				let res = await fetch(url, {
					method: "GET"
				});

				return await res.text();
			}

			document.addEventListener('DOMContentLoaded', () => {
				let $cookies = $('.cookies');
				let $close = $('.cookies__accept');
				$close.click(function(e) {
					e.preventDefault();
					$cookies.slideUp();
					let inMinutes = new Date(new Date().getTime() + 40000 * 60 * 1000);
					Cookies.set('top_ban', true, {expires: inMinutes});
				})

				if ( !Cookies.get('top_ban') ) {
					$cookies.slideDown();
				}

				// added by Anton R.
				const images = $('.project-item__img');
				images.css({
					transition: "all .4s ease-in-out"
				});

				images
					.mouseenter((el) => {
						$(el.currentTarget).css({
							transform: "scale(1.05)"
						});
					})
					.mouseleave((el) => {
						$(el.currentTarget).css({
							transform: "scale(1)"
						});
					});

				try {
					const headerDesk = document.querySelectorAll('.header-menu-list .menu-item'),
						  headerMobile = document.querySelectorAll('.mobile-menu__wrapper .menu-item');

					headerDesk.forEach(item => {
						if ((item.classList.contains('menu-item-264') || item.classList.contains('menu-item-263')) && !item.querySelector('.sub-menu')) {
							let cat = item.classList.contains('menu-item-264') ? 1 : 13,
								slug = item.classList.contains('menu-item-264') ? 'cases' : 'blog';

							getData('/wp-admin/admin-ajax.php?action=submenu_tags&cat='+cat+'&cat-slug='+slug+'&type=desk&lang=<?=qtranxf_getLanguage()?>')
							.then((res) => {
								item.classList.add('menu-item-has-children');
								item.innerHTML += res;
							});
						}
					});
					headerMobile.forEach(item => {
						if ((item.classList.contains('menu-item-264') || item.classList.contains('menu-item-263')) && !item.querySelector('.sub-menu')) {
							let cat = item.classList.contains('menu-item-264') ? 1 : 13,
								slug = item.classList.contains('menu-item-264') ? 'cases' : 'blog';

							getData('/wp-admin/admin-ajax.php?action=submenu_tags&cat='+cat+'&cat-slug='+slug+'&type=mobile&lang=<?=qtranxf_getLanguage()?>')
							.then((res) => {
								item.classList.add('menu-item-has-children');

								let name = item.querySelector('a').textContent.trim();

								item.innerHTML = `<a class="collapsed"><span>${name}</span><svg role="img"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="http://a2seven.com.srv10.place-start.ru/wp-content/themes/assembling/static/images/sprite.svg#plus"></use></svg></a>`;
								item.innerHTML += res;
							});
						}
					});
				} catch (e) {
					console.log(e.stack);
				}
			})
		</script>
	</body>
</html>
