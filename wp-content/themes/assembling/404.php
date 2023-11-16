<?php get_header(); ?>

	<section class="page page-404">
		<div class="container">
			<div class="page-404__wrap">
				<?php if(get_field('title-404', 'option')) echo '<h1 class="page-title">' . get_field('title-404', 'option') . '</h1>';
				if(get_field('text-404', 'option')) echo '<p class="page-404__text">' . get_field('text-404', 'option') . '</p>';
				if(get_field('btn-404', 'option')) echo '<a class="btn-black page-404__button" href="/">' . get_field('btn-404', 'option') . '</a>'; ?>		
			</div>
		</div>
	</section>

<?php get_footer(); ?>
