<?php get_header(); ?>

<section class="page page-text">
	<div class="container">
		<div class="back-btn">
			<?php $cat = get_the_category(get_the_ID()); 
			$linkCat = $cat[0]->term_id;
			if($cat[0]->term_id == $idEventCategory) $linkCat = $idBlogCategory; ?>
            <a href="<?php echo get_category_link($linkCat); ?>">
                <svg role="img">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?php bloginfo('template_url'); ?>/static/images/sprite.svg#arr-back"></use> 
                </svg>
                <?php the_field('word-back', 'option'); ?>
            </a>
        </div>
		<?php if(get_field('h1') == true): ?>
			<h1 class="page-title post-title"><?php the_title(); ?></h1>
		<?php endif; ?>
		<div class="post-info">
			<div class="post-info__left">
				<?php 
				if(get_field('project-link')) {
					echo '<div class="page-link">
						<a href="' . get_field('project-link') . '" target="_blank" class="project-link" >
							<svg role="img">
								<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="' . get_bloginfo('template_url') . '/static/images/sprite.svg#link-svg"></use> 
							</svg>' . get_field('see-project', 'option'); 
						echo '</a>
					</div>';
				}
				$tags = get_the_tags(get_the_ID()); 
				$tagsArray = [];
				if( $tags ) {
					$currentTag = 0;
					foreach ($tags as $tag ) {
						$tagsArray[] = $tag->term_id;
						if($currentTag < $previewCountTags ) {
							echo '<p class="blog-item__tag">' . $tag->name . '</p>';
						}
						$i++;
					}
				} ?>
				<?php if($cat[0]->term_id == $idBlogCategory || $cat[0]->term_id == $idEventCategory) {
					echo '<p class="post-time">' . get_field('time-read', 'option') . ': <span class="time"></span></p>';
				}  ?>
				
			</div>
			<div class="post-info__right">
				
				<p><?php echo get_field('publish', 'option') . '  '; echo get_the_date( 'j F Y'); ?></p>
			</div>
		</div>
	</div>

	<?php if(get_the_post_thumbnail_url()) {
		echo '<div class="container-large"><img src="' . get_the_post_thumbnail_url() . '" alt="' . get_the_title() . '" class="post-image" /></div>';
	} ?>

<?php if($cat[0]->term_id == $idBlogCategory || $cat[0]->term_id == $idEventCategory): ?>
	<div class="container">
		<div class="row">
			<?php $classContent = 'col-12';
			if(get_field('sidebar') == true) $classContent = 'col-lg-8'; ?>
			<div class="<?php echo $classContent; ?>">
				<div class="content">
					<?php 
						while( have_rows('article-content') ) {
							the_row();
							if( get_row_layout() == 'article-text' ) {
								echo '<div class="content-text">' . get_sub_field('text') . '</div>';
							}
							elseif( get_row_layout() == 'article-quote' ) {
								echo '<div class="content-quote">
									<div class="quote-separator">
										<svg role="img" class="quote-separator__svg">
											<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="' . get_bloginfo('template_url') . '/static/images/sprite.svg#review-separate"></use> 
										</svg>
									</div>
									<div class="quote-wrap">
										<div class="quote-text">' . get_sub_field('quote') . '</div>';
										if(get_sub_field('quote-author')) {
											$id = get_sub_field('quote-author');
											$title = get_the_title($id);
											$post = get_field('staff-post', $id);
											$img = get_the_post_thumbnail_url($id);

											echo '<div class="quote-author">';
												if($img) {
													echo '<div class="quote-author__img-wrap"><img src="' . $img . '" alt="' . $title . '" class="quote-author__img" /></div>';
												}
												echo '<div class="quote-author__info">
													<p class="quote-author__name">' . $title . '</p>';
													if($post) echo '<p class="quote-author__post">' . $post . '</p>';
												echo '</div>';
											echo '</div>';
										}
									echo '</div>
								</div>';
							}
						}
						wp_reset_postdata();
					?>
					<?php if(get_field('article-original__link')) {
						$articleSource = get_field('article-original');
						$linkText = '';
						if($articleSource) {
							$linkText = get_field('article-orig2', 'option') . ' <span class="link-source">&nbsp' . $articleSource . '</span>';
						} else {
							$linkText = get_field('article-orig', 'option');
						}
						echo '<div class="post-link">
							<a href="' . get_field('article-original__link') . '" target="_blank">
								<svg role="img">
									<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="' . get_bloginfo('template_url') . '/static/images/sprite.svg#link-svg"></use> 
								</svg>' . $linkText;
							echo '</a>
						</div>';
					} ?>
				</div>
			</div>
			<?php if(get_field('sidebar') == true) {
				echo '<div class="col-lg-3 sidebar-wrap">
					<div class="post__sidebar-wrap">
						<h4 class="sidebar-title">' . get_field('word-content', 'option') . '</h4>
						<ul class="post__sidebar sidebar"></ul>
					</div>
				</div>';
			} ?>
		</div>

		<?php 
			if($cat[0]->term_id == $idBlogCategory) {
				$news_query = new WP_Query([
					'post_type' => 'post',
					'cat' => $cat[0]->term_id,
					'post_status' => 'publish',
					'posts_per_page' => $eventpostsPerPage,
					'tag__in' => $tagsArray,
					'orderby' => 'date',
					'post__not_in' => array(get_the_ID())
				]);
	
				if($news_query->have_posts()) {
					echo '<h2 class="section-title">' . get_field('other-article', 'option') . '</h2>
						</div>
					</section>';
				} else {
					echo '</div>
				</section>';
				}

	
				if($news_query) {
					echo '<div class="container-large post-blog">';
					echo '<div class="row blog-row">';
					while( $news_query->have_posts() ) {
						$news_query->the_post();
						$img = get_the_post_thumbnail_url(get_the_ID());
						$title = get_the_title();
						$link = get_permalink();
	
						if(!$img) {
							$img = get_bloginfo('template_url') . '/static/images/blog-plug.jpg';
						}
	
						$cat = get_the_category(get_the_ID());
						$tags = get_the_tags(get_the_ID());
						$articleSource = get_field('article-original');
						if(!$articleSource) {
							$articleSource = '';
						}
	
						echo '<div class="blog-item__wrap col-lg-4">
							<a href="' . $link . '" class="blog-item">
								<div class="blog-item__bg"><img src="' . $img . '" alt="' . $title . '" /></div>';
								echo '<p class="blog-item__source">' . get_field('apticle', 'option') . ' <span class="blog-item__source-title">' . $articleSource . '</span></p>';
								echo '<h4 class="blog-item__title">' . $title . '</h4>';
								if( $tags ){
									echo '<div class="blog-item__tag-wrap">';
										$i = 0;
										foreach( $tags as $tag ) {
											if($i < $previewCountTags) {
												echo '<span class="blog-item__tag">' . $tag->name . '</span>';
											} else {
												$countTags = count($tags) - $previewCountTags;
												echo '<span class="blog-item__tag">+' . $countTags . '</span>';
												break;
											}
											$i++;
										}
									echo '</div>';
								}
							echo '</a>
						</div>';
					}
					wp_reset_postdata();
				echo '</div>';
					echo '</div>';
				}	
			}
		?>
	</div>
<?php else: new Content(); ?>
<?php endif; ?>
<template class="template-sidebar-item">
	<li class="sidebar__item">
		<a href="" class="sidebar__link"></a>
	</li>
</template>

<?php get_footer(); ?>