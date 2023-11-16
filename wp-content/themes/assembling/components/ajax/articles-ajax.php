<?php 
    $GLOBALS['q_config']['language'] = $_POST['lang'];

    global $idPortfolioCategory; 

    global $portfolioPostsPerPage; 
    global $portfolioPostsPerLine; 

    $paged = $_POST['page'];
    $tags = $_POST['tag'];

    $arg = [
        'post_type' => 'post',
        'cat' => 1,
        'post_status' => 'publish',
        'posts_per_page' => 8,
        'paged' =>   $paged,
        'tag' => $tags,
        'orderby' => 'date'
    ];

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