<?php

class Content {
	public function __construct() {
		echo '<div class="content">';
		if(get_field('page-description'))  echo '<div class="container container-description"><div class="page-description">' . get_field('page-description') . '</div></div>';
		$i = 0;
		while( have_rows('content') ) {
			the_row();
			if( get_row_layout() == 'content-text' ) $this->text();
			elseif( get_row_layout() == 'content-quote' ) $this->quote();
			elseif( get_row_layout() == 'content-advantages-number' ) $this->advantages();
			elseif( get_row_layout() == 'content-video' ) $this->video();
			elseif( get_row_layout() == 'content-gallery-type1' ) $this->gallery($i);
			elseif( get_row_layout() == 'content-advantages-icon' ) $this->advantagesIcon();
			elseif( get_row_layout() == 'content-vacancy' ) $this->vacancy();
			elseif( get_row_layout() == 'content-text-quote' ) $this->textQuote();
			elseif( get_row_layout() == 'content-gallery-slider' ) $this->gallerySlider($i);
			elseif( get_row_layout() == 'content-hr' ) $this->hr();
			elseif( get_row_layout() == 'content-number' ) $this->number();
			elseif( get_row_layout() == 'content-partners' ) $this->partners();
			elseif( get_row_layout() == 'content-large-image' ) $this->largeImage();
			elseif( get_row_layout() == 'content-service' ) $this->service();
			elseif( get_row_layout() == 'content-reviews' ) $this->reviews();
			elseif( get_row_layout() == 'content-project' ) $this->project();
			elseif( get_row_layout() == 'content-card-column' ) $this->card();
			elseif( get_row_layout() == 'content-stack' ) $this->stack();
			elseif( get_row_layout() == 'content-banner-link' ) $this->banner();
			elseif( get_row_layout() == 'content-list-icon' ) $this->listIcon();

			$i++;
		}
		echo '</div>';
	}


	// Обычный текст
	private function text() {
		echo '<div class="content-text"><div class="container">'.get_sub_field('text').'</div></div>';
	}

	// Цитата
	private function quote() {
		$type = get_sub_field('quote-type');
		if($type == 'type1') {
			echo '<div class="container-quote">
				<div class="container">
					<div class="content-quote">
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
					</div>
				</div>
			</div>';
		} else {
			$quote = get_sub_field('quote_editor');
			$image = get_sub_field('quote-author__image');
			echo '<div class="container-quote quote-type2">
				<div class="quote-type2__wrap">
					<div class="container">
						<div class="row">';
							if($quote) {
								echo '<div class="col-xl-7">
									<div class="quote__text-wrap">
										<div class="quote__separator">
											<svg role="img" class="quote__separator-svg">
												<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="' . get_bloginfo('template_url') . '/static/images/sprite.svg#review-separate"></use> 
											</svg>
										</div>
										<div class="content-text">' . $quote;
										if(get_sub_field('quote-author')) {
											$id = get_sub_field('quote-author');
											$title = get_the_title($id);
											$post = get_field('staff-post', $id);
			
											echo '<div class="quote-author">';
												echo '<div class="quote-author__info">
													<p class="quote-author__name">' . $title . '</p>';
													if($post) echo '<p class="quote-author__post">' . $post . '</p>';
												echo '</div>';
											echo '</div>';
										}
									echo '</div></div>
								</div>';
							}
							if($image['url']) {
								echo '<div class="col-xl-5">
									<div class="quote__image-wrap">
										<img class="quote__image" src="' . $image['url'] . '" alt="' . $image['caption'] . '" />
									</div>
								</div>';
							}
						echo '</div>
					</div>
				</div>
			</div>';
		}
	}

	// Нумерованный список (преимущества/этапы)
	private function advantages() {
		$title = get_sub_field('content-section-title');
		$subtitle = get_sub_field('content-section-text');
		$advantages = get_sub_field('advantages-repeater');
		$type = get_sub_field('advantages-type');

		echo '<div class="content-advantages-number">';
			if($title || $subtitle)  {
				echo '<div class="container">';
					if($title) echo '<h2 class="section-title">' . $title . '</h2>';
					if($subtitle) echo '<div class="section-subtitle">' . $subtitle . '</div>';
				echo '</div>';
			}

			if($advantages) {
				$i = 1;
				foreach ($advantages as $advantage) {
					$advantageTitle = $advantage['advantages-title'];
					$advantageText = $advantage['advantages-text'];
					$advantageImage = $advantage['advantages-image'];
					$num = str_pad($i, 2, '0', STR_PAD_LEFT);
					$class = '';
					if($advantageImage['url']) $class='advantages-with-image';

					echo '<div class="advantages-wrap item-' . $i . ' ' .  $class . '">
						<div class="container">
							<div class="row">
								<div class="col-lg-5">
									<div class="advantages-text">';
									if($type != 'type2') echo '<span class="advantages-number">' . $num . '</span>';
										
										echo '<h4 class="advantages-title">' . $advantageTitle . '</h4>
									</div>
								</div>
								<div class="col-lg-7">';
									if($type != 'type2') echo '<span class="advantages-number">' . $num . '</span>';
									echo '<div class="content-text">' . $advantageText . '</div>
								</div>
							</div>
						</div>';
						if($advantageImage['url']) {
							echo '<div class="container-large">
								<img src="' . $advantageImage['url'] . '" alt="' . $advantageTitle . '" class="advantages-image"/>
							</div>';
						}
					echo '</div>';

					$i++;
				}
				wp_reset_postdata();
			}
		echo '</div>';
		
	}

	// Видео
	private function video() {
		$title = get_sub_field('content-section-title');
		$video = get_sub_field('video-link');
		$preview = get_sub_field('video-preview');
		if (strpos($video, 'watch?v=') != false) {
			$video = str_replace('watch?v=', 'embed/', $video);
		}
		if($video) {
			echo '
			<div class="content-video">
				<div class="container">';
					if($title) echo '<h2 class="section-title">' . $title . '</h2>';
					echo '<div class="video-wrap">
						<div class="video-preview" style="background-image: url(' . $preview . '); background-size: cover;">
							<a href="javascript:void(0)" class="video__button-play">' . get_field('watch', 'option') . '</a></div>
						<iframe class="video-item" style="width: 100%;" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen
							src="' . $video . '">
						</iframe>
					</div>
				</div>
			</div>';
		}
	}

	// Галерея (с подписями к фотографиям)
	private function gallery($i) {
		$title = get_sub_field('content-section-title');
		$gallery = get_sub_field('gallery');
		echo '<div class="content-gallery">';
			if($title) echo '<div class="container"><h2 class="section-title">' . $title . '</h2></div>';
			if($gallery) {
				echo '<div class="container-large">
				<div class="swiper gallery-wrap">
					<div class="swiper-wrapper">';
						foreach ($gallery as $image) {
							echo '<div class="swiper-slide gallery-item">';
								$caption = $image['title'];
								$captionImg = "";
								if($image['caption']) {
									$caption = $image['caption'];
									$captionImg = $image['caption'];
									$captionImg = strip_tags($captionImg);
								} ?>
									<a href="<?php echo $image['url']; ?>" class="gallery-item__image" data-fancybox="gallery-<?php echo $i; ?>" data-caption="<?php echo $captionImg; ?>" data-options='{"touch" : false, "backFocus" : false, "loop" : true}'>
										<div class="gallery-item__image-wrap">
											<img src="<?php echo $image['sizes'][ 'large' ]; ?>" alt="<?php echo $captionImg; ?>">
										</div>
										<?php 
										if($image['caption']) {
											echo '<p class="gallery-caption">' . $caption . '</p>';
										}
									echo '</a>';

							echo '</div>';
						}
						wp_reset_postdata();
					echo '</div>
				</div>
				</div>';
			}
		echo '</div>';
	}

	// Преимущества с иконками
	private function advantagesIcon() {
		$title = get_sub_field('content-section-title');
		$advantages = get_sub_field('advantages-repeater');

		echo '<div class="content-advantages">
			<div class="container">';
				if($title) echo '<h2 class="section-title">' . $title . '</h2>';

				if($advantages) {
					echo '<div class="row row-47">';
						foreach ($advantages as $advantage) {
							$icon = $advantage['advantages-icon'];
							$title = $advantage['advantages-text'];
							
							echo '<div class="col-md-4 col-p-47 col-sm-6 advantage-item">';
								if($icon['url']) {
									echo '<div class="advantage__image-wrap">
										<img src="' . $icon['url'] . '" alt="' . $title . '" class="advantage__image" />
									</div>';
									if($title) echo '<p class="advantage__title">' . $title . '</p>';
								}
								
							echo '</div>';
						}
						wp_reset_postdata();
					echo '</div>';
				}
			echo '</div>
		</div>';
	}

	// Вакансии
	private function vacancy() {
		global $idVacancyPage;

		$title = get_sub_field('content-section-title');
		$vacancy = get_sub_field('vacancy');
		$titleBlock = $title;
		if(!$title) {
			$titleBlock = 'Горящие вакансии';
		}

		echo '<div class="content-vacancy">
			<div class="container">
				<div class="vacancy-head">
					<h2 class="section-title">' . $titleBlock . '</h2>
					<a href="' . get_permalink($idVacancyPage) . '" class="vacancy-all">' . get_field('all-vacansies', 'option') . '</a>
				</div>';
				if($vacancy) {
					echo '<div class="vacancy-wrap">';
					foreach ($vacancy as $vacancyValue) {
						$officeErevan = get_field('office-erevan', $vacancyValue);
						$officeTaganrog = get_field('office-taganrog', $vacancyValue);
						$officeDistance = get_field('office-distance', $vacancyValue); 
						$officeArr = []; 
						if($officeTaganrog == true) $officeArr[] = get_field('word-taganrog', 'option');
                        if($officeErevan == true) $officeArr[] = get_field('word-erevan', 'option');
                        if($officeDistance == true) $officeArr[] = get_field('word-remotely', 'option'); 
						

						echo '<a href="' . get_permalink($vacancyValue) . '" class="vacancy-item">
							<h2 class="vacancy-title">' . get_the_title($vacancyValue) . '</h2>';
							if(count($officeArr) > 0) echo '<div class="vacancy-tag">' . implode('/', $officeArr) . '</div>';	
						echo '</a>';
					} 
					wp_reset_postdata();
					echo '</div>';
				} else {
					$args = array(
						'post_type'      => 'page',
						'posts_per_page' => -1,
						'post_parent'    => $idVacancyPage,
						'order'          => 'ASC',
						'orderby'        => 'menu_order',
						'post_status' => 'publish',
						'meta_query' => [ [
							'key' => 'vacancy-hot',
							'value' => true,
							'compare' => 'LIKE'
						]]
					);
		
					$parent = new WP_Query( $args );
		
					if ( $parent->have_posts() ) : ?>
						<div class="vacancy-wrap">
							<?php while ( $parent->have_posts() ) : $parent->the_post(); 
								$officeErevan = get_field('office-erevan', get_the_ID());
								$officeTaganrog = get_field('office-taganrog', get_the_ID());
								$officeDistance = get_field('office-distance', get_the_ID()); 
								$officeArr = []; 
								if($officeTaganrog == true) $officeArr[] = 'Таганрог';
								if($officeErevan == true) $officeArr[] = 'Ереван';
								if($officeDistance == true) $officeArr[] = 'Удаленно'; ?>
								<a href="<?php the_permalink(); ?>" class="vacancy-item">
									<h2 class="vacancy-title"><?php the_title(); ?></h2>
									<?php if(count($officeArr) > 0) echo '<div class="vacancy-tag">' . implode('/', $officeArr) . '</div>'; ?>
									
								</a>
							<?php endwhile; ?>
						</div>
					<?php endif; 
				}
			echo '</div>
		</div>';
	}

	// Текстовый блок с цитатой и изображением
	private function textQuote() {
		$text = get_sub_field('text');
		$quote = get_sub_field('quote-group');
		$guoteText = $quote['quote-text'];
		$guoteAuthor = $quote['quote-author'];
		$image = get_sub_field('image');
		$btn = get_sub_field('btn-group');
		$btnText = $btn['btn-text'];
		$btnLink = $btn['btn-link'];

		echo '<div class="content-text-quote">
			<div class="content-text-quote__wrap">
				<div class="container-large">
					<div class="text-quote__wrap">
						<div class="text-quote__text-wrap">';
							if($text) echo '<div class="content-text">' . $text . '</div>';
							if($guoteText || $guoteAuthor) {
								echo '<div class="text-quote__quote">';
									if($guoteText) echo '<div class="text-quote__quote-text">' . $guoteText . '</div>';
									if($guoteAuthor) {
										$title = get_the_title($guoteAuthor);
										$post = get_field('staff-post', $guoteAuthor);
										$img = get_the_post_thumbnail_url($guoteAuthor);

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
								echo '</div>';
							}
							if($btnText && $btnLink) echo '<a href="' . $btnLink . '" class="btn-yellow text-quote__btn">' . $btnText . '</a>';
						echo '</div>';
						if($image['url']) {
							$alt = $image['title'];
							if($image['alt']) $alt = $image['alt']; 
							echo '<div class="text-quote__image-wrap">
								<img src="' . $image['url'] . '" alt="' . $alt . '" class="text-quote__image"/>
							</div>';
						}
					echo '</div>
				</div>
			</div>
		</div>';
	}

	// Галерея-слайдер
	private function gallerySlider($i) {
		$title = get_sub_field('content-section-title');
		$text = get_sub_field('content-section-subtitle');
		$gallery = get_sub_field('gallery');

		echo '<div class="content-gallery-slider">
			<div class="container">';
				if($title) echo '<h2 class="section-title">' . $title . '</h2>';
				if($text) echo '<div class="section-text">' . $text . '</div>';
				if($gallery) {
					echo '
					<div class="swiper swiper-gallery gallery-slider">
					  <div class="swiper-wrapper">';
						foreach ($gallery as $image) {
							$caption = $image['title'];
							$captionImg = "";
							if($image['caption']) {
								$caption = $image['caption'];
								$captionImg = $image['caption'];
								$captionImg = strip_tags($captionImg);
							} 
							echo '<div class="swiper-slide"><a href="' . $image['url'] . '" class="gallery-slider__image" data-fancybox="gallery-slide-' . $i .'" data-caption="' . $captionImg . '">
								<div class="gallery-slider__image-wrap">
									<img src="' . $image['url'] . '" alt="' . $captionImg . '" class="gallery-slider__image">
								</div>
							</a></div>';
						}
						wp_reset_postdata();
					  echo '</div>
					</div>
					<div class="swiper-pagination gallery-slider__pagination"></div>';
				}
			echo '</div>
		</div>';
	}

	// Блок с рекрутером
	private function hr() {
		$text = get_sub_field('text');
		$social = get_sub_field('social-group');
		$socialText = $social['social-text'];
		$socialRepeater = $social['social-repeater'];
		$image = get_sub_field('image');

		echo '<div class="content-hr">
			<div class="content-hr__wrap">
				<div class="container-large">
					<div class="hr__wrap">
						<div class="hr__text-wrap">';
							if($text) {
								echo '<div class="content-text">' . $text . '</div>';
							}
							if($socialText || $socialRepeater) {
								echo '<div class="hr__social-wrap">';
									if($socialText) echo '<p class="hr__social-text">' . $socialText . '</p>';
									if($socialRepeater) {
										echo '<div class="hr__social-list">';
											foreach ($socialRepeater as $social) {
												if($social['social-name'] && $social['social-link']) {
													echo '<a href="' . $social['social-link'] . '" class="hr__social-item" target="_blank">' . $social['social-name'] . '</a>';
												}
											}
											wp_reset_postdata();
										echo '</div>';
									}
								echo '</div>';
							}
						echo '</div>';
						if($image['url']) {
							echo '<div class="hr__image-wrap">
								<img src="' . $image['url'] . '" alt="' . $image['caption'] . '" class="hr__image"/>
							</div>';
						}
					echo '</div>
				</div>
			</div>
		</div>';
	}

	// Текст с числовыми показателями
	private function number() {
		$title = get_sub_field('content-section-title');
		$text = get_sub_field('text');
		$indicators = get_sub_field('indicators-repeater');
		echo '<div class="content-number">
			<div class="container">';
				if($title) echo '<h2 class="section-title">' . $title . '</h2>';
				echo '<div class="number__row">';
					if($text) {
						echo '<div class="number__text-wrap">
							<div class="content-text">' . $text . '</div>
						</div>';
					}
					if($indicators) {
						echo '<div class="number__grid-list">';
						foreach ($indicators as $indicator) {
							$indicatorsNumber = $indicator['indicators-number'];
							$indicatorsText = $indicator['indicators-text'];
							echo '<div class="number__grid-item">
								<span class="number__grid-item__number">' . $indicatorsNumber . '</span>
								<p class="number__grid-item__text">' . $indicatorsText . '</p>
							</div>';
						}
						wp_reset_postdata();
						echo '</div>';
					}
				echo '</div>
			</div>
		</div>';
	}

	// Партнеры
	private function partners() {
		echo '<div class="content-partners section-company">
			<div class="container">';
				$title = get_field('company-title', 'option');
				if(get_sub_field('content-section-title')) {
					$title = get_sub_field('content-section-title');
				}
				if($title) {
					echo '<h2 class="section-title">' . $title . '</h2>';
				} 
				$companyRepeater = get_field('company-repeater', 'option');
				if(get_field('company-repeater', 'option')) {
					echo '<div class="another-marquee">
						<div class="marquee-wrapper">
							<div class="marquee">';
							foreach ($companyRepeater as $value) {
								echo '<div class="marquee-item">
									<div class="marquee-wrap">
										<img src="' . $value['company-logo']['url'] . '" alt="' . $value['company-logo']['alt'] . '" data-src=""/>
									</div>
								</div>';
							}
							wp_reset_postdata();
						echo '</div>
						</div>
					</div>';
				}
			echo '</div>
		</div>';
	}

	// Широкое изображение
	private function largeImage() {
		$title = get_sub_field('content-section-title');
		$image = get_sub_field('image');
		$imageRu = get_sub_field('image-ru');
		$text = get_sub_field('text');

		echo '<div class="content-image">';
			if($title)  {
				echo '<div class="container">
					<h2 class="section-title">' . $title . '</h2>
				</div>';
			}

			if(qtranxf_getLanguage() == 'ru' && $imageRu['url']) {
				echo '<div class="container-large">
					<div class="image__wrap">
						<img class="image__item" src="' . $imageRu['url'] . '" alt="' . $imageRu['caption'] . '"/>
					</div>
				</div>';
			} else {
				if($image['url']) {
					echo '<div class="container-large">
						<div class="image__wrap">
							<img class="image__item" src="' . $image['url'] . '" alt="' . $image['caption'] . '"/>
						</div>
					</div>';
				}
			}
		echo '</div>';
	}

	// Услуги
	private function service() {
		$title = get_sub_field('content-section-title');
		$type = get_sub_field('service-type');
		$service = get_sub_field('service-repeater');

		echo '<div class="content-service">
			<div class="container">';
				if($title) echo '<h2 class="section-title">' . $title . '</h2>';
				if($service) {
					if($type == 'type3') {
						echo '<div class="row type-' . $type . '">';
							foreach ($service as $serviceItem) {
								$title = $serviceItem['service-title'];
								$text = $serviceItem['service-text'];
								$link = $serviceItem['service-link'];

								echo '<div class="col-md-6">
									<div class="service__item">';
										if($title) {
											if ($link) echo '<a href="'.$link.'" class="service__title link">' . $title . '</a>';
											else echo '<p class="service__title">' . $title . '</p>';
										}
										echo '<p class="service__text">' . $text . '</p>
									</div>
								</div>';
							}
							wp_reset_postdata();
						echo '</div>';
					} else {
						echo '<div class="row row-15 type-' . $type . '">';
							foreach ($service as $serviceItem) {
								$title = $serviceItem['service-title'];
								$text = $serviceItem['service-text'];
								$link = $serviceItem['service-link'];

								echo '<div class="col-md-6 col-p-15">
									<div class="service__item">';
										if($title) {
											if ($link) echo '<a href="'.$link.'" class="service__title link">' . $title . '</a>';
											else echo '<p class="service__title">' . $title . '</p>';
										}
										echo '<p class="service__text">' . $text . '</p>
									</div>
								</div>';
							}
							wp_reset_postdata();
						echo '</div>';
					}
				}
			echo '</div>
		</div>';
	}

	// Отзывы
	private function reviews() { 
		$title = get_sub_field('content-section-title');
		$reviews = get_sub_field('reviews');
		$auto = get_sub_field('slider-auto'); 
		global $reviewsPostsPerPage; ?>
		<div class="section-reviews content-reviews">
			<div class="container">
				<?php if($title) echo '<h2 class="section-title">' . $title . '</h2>'; ?>
				<div class="swiper slider-reviews <?if($auto == 'true') echo 'slider-reviews--auto'; ?>">
					<div class="swiper-wrapper">
						<?php 
							if(count($reviews) > 0 && $reviews) {
								$indexReviews = 0;
								foreach ($reviews as $review) {
									if($indexReviews < $reviewsPostsPerPage) {
										$userName = get_field('user-name', $review);
										$userPost = get_field('user-post', $review);
										$reviewPlatform = get_field('review-platform', $review);
										$reviewTitle = get_field('review-title', $review);
										$reviewText = get_field('review-text', $review);

										echo '<div class="swiper-slide reviews-slide">
											<div class="reviews-slide__content">
												<div class="reviews-slide__user">';
													if($userName) echo '<p class="reviews-slide__user-name">' . $userName . '</p>';
													if($userPost) echo '<p class="reviews-slide__user-post">' . $userPost . '</p>';
													if($reviewPlatform) {
														$logo = get_field('mini-logo', $reviewPlatform);
														$logo = $logo['url'];
														$star = get_field('count-star', $reviewPlatform);
														$countReviews = get_field('count-reviews', $reviewPlatform);
														$title = get_the_title($reviewPlatform);
														if(!$logo) {
															$logo = get_the_post_thumbnail_url($reviewPlatform);
														}
														echo '<div class="reviews-slide__platform">
															<span class="reviews-slide__platform-logo"><img src="' . $logo . '" alt="' . $title . '"/></span>
															<div class="reviews-slide__platform-info">
															<div class="ratio reviews-slide__platform-ration">';
																for ($i=1; $i <= 5; $i++) { 
																	if($i <= $star) {
																		echo '<div class="star-ratio checked disabled"></div>';
																	} else {
																		echo '<div class="star-ratio disabled no-cheked"></div>';
																	}
																}
															echo '</div>';
															if($countReviews) echo '<p class="reviews-slide__company-text">' .  $countReviews . ' reviews</p>';
															echo '</div>
														</div>';
													}
												echo '</div>';
												echo '<div class="reviews-slide__separating">
													<svg role="img" class="reviews-slide__separating-svg">
														<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="' . get_bloginfo('template_url') . '/static/images/sprite.svg#review-separate"></use> 
													</svg>
												</div>';
												echo '<div class="reviews-slide__text-content">';
													if($reviewTitle) echo '<h3 class="reviews-slide__title">' . $reviewTitle . '</h3>';
													if($reviewText) echo '<p class="reviews-slide__text">' . $reviewText . '</p>';
												echo '</div>';
												
											echo '</div>
										</div>';
									}
									$indexReviews++;
								}
								wp_reset_postdata();
							} else {
								$review_query = new WP_Query([
									'post_type' => 'reviews',
									'posts_per_page' => $reviewsPostsPerPage,
									'post_status' => 'publish'
								]);
								if($review_query) {
									while( $review_query->have_posts() ) {
										$review_query->the_post();
										$userName = get_field('user-name');
										$userPost = get_field('user-post');
										$reviewPlatform = get_field('review-platform');
										$reviewTitle = get_field('review-title');
										$reviewText = get_field('review-text');

										echo '<div class="swiper-slide reviews-slide">
											<div class="reviews-slide__content">
												<div class="reviews-slide__user">';
													if($userName) echo '<p class="reviews-slide__user-name">' . $userName . '</p>';
													if($userPost) echo '<p class="reviews-slide__user-post">' . $userPost . '</p>';
													if($reviewPlatform) {
														$logo = get_field('mini-logo', $reviewPlatform);
														$logo = $logo['url'];
														$star = get_field('count-star', $reviewPlatform);
														$countReviews = get_field('count-reviews', $reviewPlatform);
														$title = get_the_title($reviewPlatform);
														if(!$logo) {
															$logo = get_the_post_thumbnail_url($reviewPlatform);
														}
														echo '<div class="reviews-slide__platform">
															<span class="reviews-slide__platform-logo"><img src="' . $logo . '" alt="' . $title . '"/></span>
															<div class="reviews-slide__platform-info">
															<div class="ratio reviews-slide__platform-ration">';
																for ($i=1; $i <= 5; $i++) { 
																	if($i <= $star) {
																		echo '<div class="star-ratio checked disabled"></div>';
																	} else {
																		echo '<div class="star-ratio disabled no-cheked"></div>';
																	}
																}
															echo '</div>';
															if($countReviews) echo '<p class="reviews-slide__company-text">' .  $countReviews . ' reviews</p>';
															echo '</div>
														</div>';
													}
												echo '</div>';
												echo '<div class="reviews-slide__separating">
													<svg role="img" class="reviews-slide__separating-svg">
														<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="' . get_bloginfo('template_url') . '/static/images/sprite.svg#review-separate"></use> 
													</svg>
												</div>';
												echo '<div class="reviews-slide__text-content">';
													if($reviewTitle) echo '<h3 class="reviews-slide__title">' . $reviewTitle . '</h3>';
													if($reviewText) echo '<p class="reviews-slide__text">' . $reviewText . '</p>';
												echo '</div>';
												
											echo '</div>
										</div>';
									}
									wp_reset_postdata();
								}
							}
						?>
					</div>
					<div class="swiper-pagination slider-reviews__pagination"></div>
				</div>
			</div>
		</div>
	<?php }

	// Проекты
	private function project() {
		global $idPortfolioCategory;
		echo '<div class="content-project">
			<div class="container">';
				$title = get_sub_field('content-section-title');
				$projects = get_sub_field('project'); 
				if($title) echo '<h2 class="section-title">' . $title . '</h2>'; ?>

				<div class="project__wrap">
					<?php
					if(count($projects) >= 1 && $projects) {
						$projects = array_chunk($projects, $portfolioPostsPerLine);
						foreach ($projects as $news) {
							echo '<div class="project-grid">';
								foreach ($news as $news_item) {
									$img = get_the_post_thumbnail_url($news_item);
									$title = get_the_title($news_item);
									$link = get_permalink($news_item);
									if(!$img) {
										$img = get_bloginfo('template_url') . '/static/images/project-plug.jpg';
									}
									$cat = get_the_category($news_item);
									$tags = get_the_tags($news_item);

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
					} else {
						$project_query = new WP_Query([
							'post_type' => 'post',
							'cat' => $idPortfolioCategory,
							'posts_per_page' => 4,
							'post_status' => 'publish',
							'post__not_in' => [get_the_ID()]
						]);
						if($project_query) {
							echo '<div class="project-grid">';
								while( $project_query->have_posts() ) {
									$project_query->the_post();
									$img = get_the_post_thumbnail_url();
									$title = get_the_title();
									$link = get_permalink();
									if(!$img) {
										$img = get_bloginfo('template_url') . '/static/images/project-plug.jpg';
									}
									$cat = get_the_category(get_the_ID());
									$tags = get_the_tags(get_the_ID());
			
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
							wp_reset_postdata();
						}
					}
					?>
				</div>
			<?php echo '</div>
		</div>';
	}

	// Карточки в несколько столбцов
	private function card() {
		$title = get_sub_field('content-section-title');
		$text = get_sub_field('content-section-text'); 
		$cards = get_sub_field('card-repeater');
		
		echo '<div class="content-card">
			<div class="container">';
				if($title) echo '<h2 class="section-title">' . $title . '</h2>';
				if($text) echo '<div class="section-text">' . $text . '</div>';

				if($cards) {
					echo '<div class="card__row">';
						foreach ($cards as $card) {
							$cardTitle = $card['card-title'];
							$cardText = $card['card-text'];
							echo '<div class="card__item">';
								if($cardTitle) echo '<h3 class="card__title">' . $cardTitle . '</h3>';
								if($cardText) echo '<p class="card__text">' . $cardText . '</p>';
							echo '</div>';
						}
						wp_reset_postdata();
					echo '</div>';
				}
			echo '</div>
		</div>';
	}

	// Технологии
	private function stack() {
		$type = get_sub_field('stack-type');
		echo '<div class="content-stack">';
		if($type == 'type1') { ?>
			<div class="section-technologies">
				<div class="container">
					<?php
					$title = get_field('technologies-title', 'option');
					$subtitle = get_sub_field('stack-subtitle');
					$stackRepeater = get_sub_field('stack__group-repeater');
					if(get_sub_field('content-section-title')) $title = get_sub_field('content-section-title');
					if(!$stackRepeater && !$subtitle) $subtitle = get_field('technologies-subtitle', 'option');
					if($title) {
						echo '<h2 class="section-title">' . $title . '</h2>';
					} 
					if($subtitle) {
						echo '<p class="section-text">' . $subtitle . '</p>';
					}
					if($stackRepeater) {
						foreach ($stackRepeater as $value) {
							echo '<div class="stack-wrapper">';
								echo '<h3 class="stack-group__name">' . $value['stack-group__name'] . '</h3>';
								$stack = $value['stack-repeater'];
								if($stack) {
									echo '<div class="row">';
										foreach ($stack as $stackItem) {
											echo '<div class="col-md-2 col-4">
												<img src="' . $stackItem['stack-icon']['url'] . '" alt="' . $stackItem['stack-icon']['alt'] . '" class="stack-group__logo"/>
											</div>';
										}
									echo '</div>';
								}
							echo '</div>';
						}
						wp_reset_postdata();
					} else {
						if(get_field('technologies__group-repeater', 'option')) {
							foreach (get_field('technologies__group-repeater', 'option') as $value) {
								echo '<div class="stack-wrapper">';
									echo '<h3 class="stack-group__name">' . $value['technologies-group__name'] . '</h3>';
									$stack = $value['technologies-repeater'];
									if($stack) {
										echo '<div class="row">';
											foreach ($stack as $stackItem) {
												echo '<div class="col-md-2 col-4">
													<img src="' . $stackItem['technologies-icon']['url'] . '" alt="' . $stackItem['technologies-icon']['alt'] . '" class="stack-group__logo"/>
												</div>';
											}
										echo '</div>';
									}
								echo '</div>';
							}
							wp_reset_postdata();
						}
					}
					 ?>
				</div>
			</div>
		<?php } else {
			$title = get_sub_field('content-section-title');
			$stack = get_sub_field('stack-repeater');
			
			echo '<div class="container">';
				if($title) echo '<h2 class="section-title">' . $title . '</h2>';
				if($stack ) {
					echo '<div class="row">';
						foreach ($stack  as $stackItem) {
							echo '<div class="col-md-2 col-4">
								<img src="' . $stackItem['stack-logo']['url'] . '" alt="' . $stackItem['stack-logo']['alt'] . '" class="stack__logo"/>
							</div>';
						}
						wp_reset_postdata();
					echo '</div>';
				}
			echo '</div>';
		}
		echo '</div>';
	}

	// Темный блок с заголовком и ссылкой
	private function banner() {
		$title = get_sub_field('banner-title');
		$btn = get_sub_field('banner-btn');
		$btnText = $btn['banner-btn__text'];
		$btnLink = $btn['banner-btn__link'];
		echo '<div class="content-banner">
			<div class="content-banner__wrap">
				<div class="container">';
					if($title) echo '<h2 class="banner__title">' . $title . '</h2>';
					if($btnText && $btnLink) {
						echo '<a href="' . $btnLink . '" class="btn-yellow banner__btn">' . $btnText . '</a>';
					}
				echo '</div>
			</div>
		</div>';
	}

	// Список с иконками
	private function listIcon() {
		$title = get_sub_field('content-section-title');
		$list = get_sub_field('list-repeater');
		echo '<div class="content-list-icon">
			<div class="container">';
				if($title) echo '<h2 class="section-title">' . $title . '</h2>';
				if($list) {
					echo '<div class="row">';
						foreach ($list as $listItem) {
							$listTitle = $listItem['list-title'];
							$listIcons = $listItem['list-icons'];

							echo '<div class="col-md-6">
								<div class="list__wrap">';
									if($listTitle) echo '<h3 class="list__title">' . $listTitle . '</h3>';
									if($listIcons) {
										echo '<ul class="list__list-icon">';
											foreach ($listIcons as $listIconsItem) {
												$icon = $listIconsItem['list-item-icon'];
												$text = $listIconsItem['list-item-text'];

												echo '<li class="list__item">';
													if($icon['url']) 
														echo '<span class="list__icon-wrap"><img class="list__icon" src="' . $icon['url'] . '" alt="' . $icon['caption'] . '"/></span>';
													if($text) echo '<span class="list__icon-text">' . $text . '</span>';
												echo '</li>';
											}
										echo '</ul>';
									}
								echo '</div>
							</div>';
						}
						wp_reset_postdata();
					echo '</div>';
				}
			echo '</div>
		</div>';
	}
}