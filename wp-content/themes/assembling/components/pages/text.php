<section class="page text-page">
    <div class="container">
        <?php if(get_field('h1') == true): ?>
			<h1 class="page-title"><?=get_the_title();?></h1>
		<?php endif; ?>
    </div>
    <?php new Content(); ?>
</section>