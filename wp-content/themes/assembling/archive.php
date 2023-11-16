<?php get_header(); 

$idCurrentCategory = get_query_var('cat'); 
$reqTag = $_GET['tag'];
?>

<?php if( is_category($idPortfolioCategory) ): ?>
	<section class="page portfolio-page text-page">
		<div class="container">
			<h1 class="page-title"><?php echo get_cat_name(get_queried_object_id()); ?></h1>
			<ul class="project__tags">
				<li class="project__tags-item<?=(!$reqTag ? ' tags-item--active' : '')?>" data-tag=""><?php echo get_field('all-cat', 'option'); ?></li>
				<?php   
					$tags = get_tags_in_cat($idCurrentCategory);
					if(count($tags) > 1) {
						foreach ($tags as $tag_slug => $tag_name) {
							echo '<li class="project__tags-item'.($reqTag && $reqTag == $tag_slug ? ' tags-item--active' : '').'" data-tag="' . $tag_slug . '">' . $tag_name . '</li>';
						}
					}
				?>
			</ul>
			<div class="project__wrap">
				<?php
					$arg = [
						'post_type' => 'post',
						'cat' => $idCurrentCategory,
						'post_status' => 'publish',
						'posts_per_page' => $portfolioPostsPerPage,
						'paged' =>  1,
						'orderby' => 'date',
					];
				
					if ($reqTag) $arg['tag'] = $reqTag;

					$pages = ceil($news_query->post_count / $portfolioPostsPerPage);

					$news_query = get_posts($arg);

					if($news_query) {
						$news_array = array_chunk($news_query, $portfolioPostsPerLine);
						foreach ($news_array as $news) {
							echo '<div class="project-grid">';
								foreach ($news as $news_item) {
									$img = get_the_post_thumbnail_url($news_item->ID);
									$title = $news_item->post_title;
									$link = get_permalink($news_item->ID);
									if(!$img) {
										$img = get_bloginfo('template_url') . '/static/images/project-plug.jpg';
									}
									$cat = get_the_category($news_item->ID);
									$tags = get_the_tags($news_item->ID);

									echo '<a href="' . $link . '" class="project-item">
										<div class="project-item__img" style="background-image: url(' . $img . '); ">';
											if( $tags ){
												echo '<div class="project-item__tag-wrap">';
													foreach( $tags as $tag ){
														echo '<span class="project-item__tag">' . $tag->name . '</span>';;
													}
												echo '</div>';
											}
										echo '</div>
										<h4 class="project-item__title">' . $title . '</h4>
									</a>';
								}
							echo '</div>';
						}
						wp_reset_postdata();
					}
				?>
			</div>
		</div>
	</section>
<?php else: ?>
	<section class="page blog-page text-page" data-cat="<?php echo get_queried_object_id(); ?>">
		<div class="container">
			<h1 class="page-title"><?php echo get_cat_name(get_queried_object_id()); ?></h1>

			<ul class="project__tags">
				<li class="project__tags-item<?=(!$reqTag ? ' tags-item--active' : '')?>" data-tag=""><?php echo get_field('all-cat', 'option'); ?></li>
				<?php 
					$tags = get_tags_in_cat($idCurrentCategory);
					if(count($tags) > 1) {
						foreach ($tags as $tag_slug => $tag_name) {
							echo '<li class="project__tags-item'.($reqTag && $reqTag == $tag_slug ? ' tags-item--active' : '').'" data-tag="' . $tag_slug . '">' . $tag_name . '</li>';
						}
						wp_reset_postdata();
					}
				?>
			</ul>
		</div>
		<div class="container-large">
			<div class="blog__wrap">
				<?php
					$mainArg = [
						'post_type' => 'post',
						'cat' => get_queried_object_id(),
						'post_status' => 'publish',
						'posts_per_page' => $blogPostsPerPage,
						'paged' =>  1,
						'orderby' => 'date',
					];
				
					if ($reqTag) $mainArg['tag'] = $reqTag;
				
					$news_query = new WP_Query($mainArg);

					$news_queryAll = new WP_Query([
						'post_type' => 'post',
						'cat' => get_queried_object_id(),
						'post_status' => 'publish',
						'posts_per_page' => -1,
						'orderby' => 'date',
					]);
					
					if($news_query->have_posts()) {
						echo '<div class="row blog-row">';
							while( $news_query->have_posts() ) {
								$news_query->the_post();
								$img = get_the_post_thumbnail_url(get_the_ID());
								$title = get_the_title();
								if (!$title) {
									continue;
								}
								$link = get_permalink();

								if(!$img) 
									$img = get_bloginfo('template_url') . '/static/images/blog-plug.jpg';

								$cat = get_the_category(get_the_ID());
								$tags = get_the_tags(get_the_ID());
								$articleSource = get_field('article-original');
								if(!$articleSource) 
									$articleSource = '';

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
						$pages = ceil($news_queryAll->found_posts / $blogPostsPerPage);
						if($pages > 1) {
							echo '<div class="btn-black blog-btn-load">' . get_field('load-more', 'option') . '</div>';
						}
					}
				?>
			</div>
		</div>
		<?php 
			$events_query = new WP_Query([
				'post_type' => 'post',
				'cat' => $idEventCategory,
				'post_status' => 'publish',
				'posts_per_page' => $eventpostsPerPage ,
				'paged' =>  1,
				'orderby' => 'date',
			]);
			$pagesEvents = ceil(get_category($idEventCategory)->category_count / $eventpostsPerPage );
			if($events_query->have_posts()) {
				echo '<div class="events-wrap">';
					echo '<div class="container">
						<h2 class="section-title">' . get_cat_name($idEventCategory) . '</h2>';
						if(category_description($idEventCategory)) echo '<div class="section-text">' . category_description($idEventCategory) . '</div>';
					echo '</div>';
					echo '<div class="container-large">
						<div class="blog__wrap">';
						echo '<div class="row blog-row">';
							while( $events_query->have_posts() ) {
								$events_query->the_post();
								$img = get_the_post_thumbnail_url(get_the_ID(), 'large');
								$title = get_the_title();
								$link = get_permalink();

								if(!$img) {
									$img = get_bloginfo('template_url') . '/static/images/blog-plug.jpg';
								}

								$cat = get_the_category(get_the_ID());

								$tagsEvent = get_field('event-tags');
								$info = get_field('event-info');
								$articleStatus = get_field('event-date');

								echo '<div class="blog-item__wrap col-md-4">
									<a href="' . $link . '" class="blog-item">
										<div class="blog-item__bg"><img src="' . $img . '" alt="' . $title . '" /></div>';
										if($tagsEvent) echo '<p class="blog-item__source">' . $tagsEvent . '</p>';
										
										echo '<h4 class="blog-item__title">' . $title . '</h4>';
										if($info) echo '<span class="event-info">' . $info . '</span>';
										if($articleStatus === true) echo '<span class="event-status">' . get_field('word-article-close', 'option') . '</span>';
									echo '</a>
								</div>';
							}
							wp_reset_postdata();
						echo '</div>';
						echo '</div>
					</div>';
				echo '</div>';
			}
		?>
		<div class="container">
			<h2 class="section-title"><?php echo get_field('title-social', 'option'); ?></h2>
			<div class="social-wrap">
				<?php 
					$vk = 'VKontakte';
					if(qtranxf_getLanguage() == 'ru') {
						$vk = 'ВКонтакте';
					}
					if(get_field('facebook-link', 'option')) echo '<a href="' . get_field('facebook-link', 'option') . '" target="_blank" class="link-title">Facebook</a>';
					if(get_field('linkedin-link', 'option')) echo '<a href="' . get_field('linkedin-link', 'option') . '" target="_blank" class="link-title">Linkedin</a>';
					if(get_field('insta-link', 'option')) echo '<a href="' . get_field('insta-link', 'option') . '" target="_blank" class="link-title">Instagram</a>';
					if(get_field('vk-link', 'option')) echo '<a href="' . get_field('vk-link', 'option') . '" target="_blank" class="link-title">' . $vk . '</a>';
					if(get_field('youtube-link', 'option')) echo '<a href="' . get_field('youtube-link', 'option') . '" target="_blank" class="link-title">YouTube</a>';
				?>
			</div>
		</div>
	</section>
<?php endif; ?>
	
<?php get_footer(); ?>
