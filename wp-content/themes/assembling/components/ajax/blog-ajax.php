<?php 
    $GLOBALS['q_config']['language'] = $_POST['lang'];
    
    global $blogPostsPerPage; 
    global $previewCountTags; 

    $paged = $_POST['page'];
    $tags = $_POST['tag'];
    $cat = $_POST['cat'];
    $postCount = $_POST['postCount'];

    $news_query = new WP_Query([
        'post_type' => 'post',
        'cat' => $cat,
        'post_status' => 'publish',
        'posts_per_page' => 12,
        'paged' =>   $paged,
        'tag' => $tags,
        'orderby' => 'date'
    ]);

    if($news_query->have_posts()) {
        while( $news_query->have_posts() ) {
            $news_query->the_post();
            $img = get_the_post_thumbnail_url(get_the_ID(), 'large');
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
    }

    if(($news_query->post_count + $postCount) < $news_query->found_posts) {
        echo '<span class="btn-true"></span>';
    }