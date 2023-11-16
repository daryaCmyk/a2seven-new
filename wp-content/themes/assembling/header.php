<?php
	global $idContactPage;
	global $idPrivatePage;
?>

<!DOCTYPE html>
<html lang="<?php echo qtranxf_getLanguage(); ?>" data-lang-code="<?php echo get_locale();?>" data-lang-order="<?=array_search(qtranxf_getLanguage(), qtranxf_getSortedLanguages());?>">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title(); ?></title>
	<?php the_field('header_script', 'option'); ?>

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

	<?php wp_head(); ?>
</head>
<body class="<?php if(wp_is_mobile()) echo 'is_mobile'; ?>">
	<div class="cookies">
		<p class="cookies__text"><?php the_field('сookie-text', 'option'); ?></p>
		<a class="cookies__accept cookies__btn btn-yellow" href="#"><?php the_field('сookie-btn', 'option'); ?></a>
		<a class="cookies__link" href="<?php echo get_permalink($idPrivatePage);?>" target="_blank"><?php the_field('сookie-link', 'option'); ?></a>
	</div>
	<!-- Mobile menu -->
	<nav class="mobile-menu">
		<ul class="mobile-menu__wrapper">
			<?php wp_nav_menu( array('menu'=>'header_menu', 'container' => false, 'items_wrap' => '%3$s') ); ?>
		</ul>
		<?php if(get_field('btn-feedback', 'option')): ?>
			<a class="header-btn" href="<?php echo get_permalink($idContactPage); ?>"><?php the_field('btn-feedback', 'option'); ?></a>
		<?php endif;?>
	</nav>
	<!-- /Mobile menu -->

	<div class="page-wrapper page-<?php echo qtranxf_getLanguage(); ?> <?php if(is_front_page( )) echo 'index-page '; if(wp_is_mobile( )) echo 'is_mobile';?>">
		<main>
			<header class="header">
				<div class="header__wrapper">
					<a href="/" class="logo">
						<img src="<?php bloginfo('template_url'); ?>/static/images/logo.svg" alt="" class="logo__img">
					</a>

					<nav class="header-menu">
						<ul class="header-menu-list">
							<?php wp_nav_menu( array('menu'=>'header_menu', 'container' => false, 'items_wrap' => '%3$s') ); ?>
						</ul>
					</nav>

					<?php if(get_field('btn-feedback', 'option')): ?>
						<a class="header-btn" href="<?php echo get_permalink($idContactPage); ?>"><?php the_field('btn-feedback', 'option'); ?></a>
					<?php endif;?>
					<a href="#" class="mobile-menu-open">
						<div class="mobile-menu-open__wrap">
							<span class="mobile-menu-open__button"></span>
						</div>
					</a>
				</div>
				<!-- <script>
				 document.addEventListener("DOMContentLoaded", function(event) {
					 setTimeout(() => {
						 $('.autoplay-video .video-preview').click();
						 console.log('xxxx');
					 }, 500);
				});
			 </script> -->
			</header>
