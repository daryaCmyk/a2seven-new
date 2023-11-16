<?php get_header();

global $idPortfolioCategory;

global $portfolioPostsPerLine;
global $reviewsPostsPerPage; ?>
<?php $slider = get_field('slider-repeater', 'option');
if(count($slider) > 0):
    ?>
    <section class="section-slider">
        <div class="slider-container">
            <div class="slider-wrapper">
                <div class="slider-content">
                    <div class="slider-content__left">
                        <p class="slider-content__number">01</p>
                        <p class="slider-content__line"></p>
                        <div class="swiper slider-titles">
                            <div class="swiper-wrapper">
                                <?php
                                foreach ($slider as $slide) {
                                    echo '<div class="swiper-slide slider-titles__slide">
                                            <p class="slider-titles__title">' . $slide['slider-title'] . '</p>
                                        </div>';
                                }
                                ?>
                            </div>
                        </div>
                        <?php if(get_field('slider-text__immutable', 'option'))
                            echo '<p class="slider-content__text">' . get_field('slider-text__immutable', 'option') . '</p>'; ?>
                    </div>
                    <div class="slider-content__right">
                        <div class="swiper slider-main">
                            <div class="swiper-wrapper">
                                <?php
                                foreach ($slider as $slide) {
                                    $title = $slide['slider-title'];
                                    $text = $slide['slider-text'];
                                    $linkGroup = $slide['slider-link__group'];
                                    echo '<div class="swiper-slide slider-main__slide">
                                            <div class="slider-main__slide-content">
                                                <h2 class="slider-main__title">' . $title . '</h2>';
                                    if($text) echo '<p class="slider-main__text">' . $text . '</p>';
                                    if($linkGroup['slider-link__text'] && $linkGroup['slider-link__link']) {
                                        echo '<a href="' . $linkGroup['slider-link__link'] . '" class="slider-main__link">' . $linkGroup['slider-link__text'] . '</a>';
                                    }
                                    echo '</div>
                                        </div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination slider-main__pagination"></div>
                <?php if(get_field('slider-video', 'option')) {
                    echo '<div class="slider-video open-video">
                        <span class="slider-video__play">
                            <svg role="img" class="slider-video__play-svg">
                                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="' . get_bloginfo('template_url') . '/static/images/sprite.svg#play"></use> 
                            </svg>
                        </span>';
                    if(get_field('slider-video_text', 'option')) echo '<span class="slider-video__text">' . get_field('slider-video_text', 'option') . '</span>';
                    echo '</div>';
                } ?>
            </div>
        </div>
        <div class="slider-thumbs">
            <?php
            $i = 1;
            foreach ($slider as $slide) {
                $class = "";
                if($i == 1) $class="slider-thumbs__item-active";
                echo '<div class="slider-thumbs__item ' . $class . '" data-slide="' . $i .'">
                        <img class="slider-thumbs__img" src="' . $slide['slider-image']['url'] . '" alt="' . $slide['slider-title'] . '"/>
                        <div class="slider-thumbs__text">
                            <p class="slider-thumbs__number">' . sprintf("%02d", $i) . '</p>
                            <p class="slider-thumbs__title">' . $slide['slider-title'] . '</p>
                        </div>
                    </div>';
                $i++;
            }
            ?>
        </div>
    </section>
<?php endif; ?>
<?php
$blocksList = get_field('blocks-list', 'option');
foreach($blocksList as $block) {
    $currType = $block[$block['type']];
    if ($block['type'] == 'seo') {
        ?>
        <section class="section-seo">
            <div class="container">
                <div class="section-seo__wrap">
                    <?php if($currType['seo-title']) {
                        echo '<h2 class="section-title">' . $currType['seo-title'] . '</h2>';
                    }
                    ?>
                    <?php if($currType['seo-text']) {
                        echo '<p class="section-text">' . $currType['seo-text'] . '</p>';
                    }
                    $btnGroup = $currType['seo-btn'];
                    if($btnGroup['seo-btn__text'] && $btnGroup['seo-btn__link']) {
                        echo '<a href="' . $btnGroup['seo-btn__link'] . '" class="btn-black section-seo__btn">' . $btnGroup['seo-btn__text'] . '</a>';
                    }?>
                </div>
            </div>
        </section>
        <?php
    } else if ($block['type'] == 'line') {
        ?>
        <section class="section-company">
            <div class="container">
                <?php if($currType['company-title']) {
                    echo '<h2 class="section-title">' . $currType['company-title'] . '</h2>';
                }
                $companyRepeater = $currType['company-repeater'];
                if($currType['company-repeater']) {
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
                } ?>
            </div>
        </section>
        <?php
    } else if ($block['type'] == 'texticons') {
        ?>
        <section class="section-technologies">
            <div class="container">
                <?php if($currType['technologies-title']) {
                    echo '<h2 class="section-title">' . $currType['technologies-title'] . '</h2>';
                }
                if($currType['technologies-subtitle']) {
                    echo '<p class="section-text">' . $currType['technologies-subtitle'] . '</p>';
                }
                if($currType['technologies__group-repeater']) {
                    foreach ($currType['technologies__group-repeater'] as $value) {
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
                } ?>
            </div>
        </section>
        <?php
    } else if ($block['type'] == 'lists') {
        ?>
        <section class="section-service">
            <div class="container">
                <?php if($currType['service-title']) {
                    echo '<h2 class="section-title">' . $currType['service-title'] . '</h2>';
                }
                if($currType['service-repeater']) {
                    echo '<div class="row">';
                    foreach ($currType['service-repeater'] as $value) {
                        echo '<div class="col-md-6">
                                    <div class="service__item">
                                        <h3 class="service__name">' . $value['service-repeater__name'] . '</h3>';
                        $serviceRepeater = $value['service-repeater__service'];
                        if($serviceRepeater) {
                            echo '<ul>';
                            foreach ($serviceRepeater as $valueService) {
                                echo '<li>' . $valueService['service-repeater__service-name'] . '</li>';
                            }
                            echo '</ul>';
                        }
                        echo '</div>
                                </div>';
                    }
                    wp_reset_postdata();
                    echo '</div>';
                } ?>
            </div>
        </section>
        <?php
    } else if ($block['type'] == 'links') {
        ?>
        <section class="section-about">
            <div class="container">
                <div class="row row-center">
                    <div class="col-md-6">
                        <?php if($currType['about-title']) {
                            echo '<h2 class="section-title">' . $currType['about-title'] . '</h2>';
                        }
                        if($currType['about-text']) {
                            echo '<p class="section-text">' . $currType['about-text'] . '</p>';
                        } ?>
                    </div>
                    <?php
                    if($currType['about-directions']) {
                        echo '<div class="col-md-6">
                                    <div class="row about-directions__list">';
                        foreach ($currType['about-directions'] as $value) {
                            if ($value['about-directions__link']) echo '<a href="'.$value['about-directions__link'].'" class="col-md-4 col-6 about-directions__item">';
                            else echo '<div class="col-md-4 col-6 about-directions__item">';
                            if($value['about-directions__icon']['url']) {
                                echo '<img src="' .  $value['about-directions__icon']['url'] . '" class="about-directions__icon"/>';
                            }

                            if($value['about-directions__name']) {
                                echo '<span class="about-directions__name">' .  $value['about-directions__name'] . '</span>';
                            }
                            if ($value['about-directions__link']) echo '</a>';
                            else echo '</div>';
                        }
                        wp_reset_postdata();
                        echo '</div>
                                </div>';
                    }
                    ?>
                </div>
            </div>
        </section>
        <?php
    } else if ($block['type'] == 'image') {
        ?>
        <div class="content" style="padding: 0; margin: 0;">
            <div class="content-image">
                <div class="container">
                    <h2 class="section-title"><?=$currType['title']?></h2>
                </div>
                <div class="container-large">
                    <div class="image__wrap">
                        <img class="image__item" src="<?=$currType['img']['url']?>" alt="<?=$currType['img']['caption']?>"/>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else if ($block['type'] == 'quote') {
        ?>
        <div class="content" style="padding: 0; margin: 0;">
            <div class="container-quote">
                <div class="container">
                    <div class="content-quote">
                        <div class="quote-separator">
                            <svg role="img" class="quote-separator__svg">
                                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=get_bloginfo('template_url')?>/static/images/sprite.svg#review-separate"></use>
                            </svg>
                        </div>
                        <div class="quote-wrap">
                            <div class="quote-text"><?=$currType['text']?></div>
                            <?php
                            if($currType['author']) {
                                $id = $currType['author'];
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
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
<section class="section-reviews">
    <div class="container">
        <div class="swiper slider-reviews <?if(get_field('slider-auto', 'option') == 'true') echo 'slider-reviews--auto'; ?>">
            <div class="swiper-wrapper">
                <?php
                $reviews = get_field('reviews-objects', 'option');
                if(count($reviews) > 0 && $reviews) {
                    $j = 0;
                    foreach ($reviews as $review) {
                        if($j < $reviewsPostsPerPage) {
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
                                if($countReviews) echo '<p class="reviews-slide__company-text">' .  $countReviews . ' ' . get_field('word-reviews', 'option') . '</p>';
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
                        $j++;
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
                                if($countReviews) echo '<p class="reviews-slide__company-text">' .  $countReviews . ' ' . get_field('word-reviews', 'option') . '</p>';
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
</section>
<section class="section-project">
    <div class="container">
        <?php if(get_field('project-title', 'option')) {
            echo '<h2 class="section-title">' . get_field('project-title', 'option') . '</h2>';
        }
        $projects = get_field('project-objects', 'option');
        if(count($projects) > 1) {
            echo '<div class="project-grid">';
            $i = 0;
            foreach( $projects as $post_object) {
                if($i < $portfolioPostsPerLine) {
                    $img = get_the_post_thumbnail_url($post_object->ID);
                    $title = get_the_title($post_object->ID);
                    $link = get_permalink($post_object->ID);
                    if(!$img) {
                        $img = get_bloginfo('template_url') . '/static/images/project-plug.jpg';
                    }
                    $cat = get_the_category($post_object->ID);

                    $tags = get_the_tags($post_object->ID);

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
                $i++;
            }
            wp_reset_postdata();
            echo '</div>';
        } else {
            $project_query = new WP_Query([
                'post_type' => 'post',
                'cat' => $idPortfolioCategory,
                'posts_per_page' => $portfolioPostsPerLine,
                'post_status' => 'publish'
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
</section>
<?php if(count(get_field('rating-company', 'option')) > 1): ?>
    <section class="section-rating">
        <div class="container">
            <div class="company-row">
                <?php $companyObjects = get_field('rating-company', 'option');
                foreach( $companyObjects as $post_object):
                    $img = get_the_post_thumbnail_url($post_object->ID);
                    $title = get_the_title($post_object->ID);
                    $star = get_field('count-star', $post_object->ID);
                    $ratingNumber = get_field('rating-number', $post_object->ID);
                    $countReviews = get_field('count-reviews', $post_object->ID);
                    $link = get_field('company-link', $post_object->ID);

                    if($link) {
                        echo '<a href="' . $link . '" target="blank" class="company-row__item">';
                    } else {
                        echo '<div class="company-row__item">';
                    }
                    echo ' <img src="' . $img . '" alt="' . $title . '" class="company-image"/>';
                    echo '<div class="ratio company-ration">';
                    for ($i=1; $i <= 5; $i++) {
                        if($i <= $star) {
                            echo '<div class="star-ratio checked disabled"></div>';
                        } else {
                            echo '<div class="star-ratio disabled no-cheked"></div>';
                        }
                    }
                    echo '</div>';
                    if($ratingNumber) echo '<p class="company-text">' . get_field('word-rating', 'option') . ' ' .  $ratingNumber . '</p>';
                    if($countReviews) echo '<p class="company-text">' .  $countReviews . ' ' . get_field('word-reviews', 'option') . '</p>';
                    if($link) {
                        echo '</a>';
                    } else {
                        echo '</div>';
                    }
                    ?>
                <?php endforeach;
                wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php if(get_field('slider-video', 'option')) {
    echo '<div class="custom-modal modal-full" id="video-modal">
        <div class="custom-modal__wrapper">
            <div class="custom-modal-header">';
    /*<button class="full-modal" type="button">
        <svg class="full-modal__svg full-modal__svg--open" role="image">
            <use xlink:href="' . get_bloginfo('template_url') . '/static/images/sprite.svg#fullscreen"></use>
        </svg>
        <svg class="full-modal__svg full-modal__svg--exit" role="image">
            <use xlink:href="' . get_bloginfo('template_url') . '/static/images/sprite.svg#fullscreen-exit"></use>
        </svg>
    </button>*/
    echo '<button class="close-modal close-modal-event" type="button">
                    <svg class="close-modal__svg" role="image">
                        <use xlink:href="' . get_bloginfo('template_url') . '/static/images/sprite.svg#close"></use>
                    </svg>
                </button>
            </div>
            <div class="custom-modal-body">
                <div class="modal-container"><iframe class="modal-video" data-src="" width="100%" height="315" src="' . get_field('slider-video', 'option') . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
            </div>
        </div>
    </div>';
} ?>
<?php get_footer(); ?>
