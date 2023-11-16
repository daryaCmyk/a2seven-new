<?php 
    $GLOBALS['q_config']['language'] = $_POST['lang'];

    global $idVacancyPage; 

    $tags = $_POST['tag'];
    $tagArr = array();

    if($tags) {
        $tagArr[] = [
            'key' => $tags,
            'value' => true,
            'compare' => 'LIKE'
        ];
    }

    $arg = [
        'post_type'      => 'page',
        'posts_per_page' => -1,
        'post_parent'    => $idVacancyPage,
        'order'          => 'ASC',
        'orderby'        => 'menu_order',
        'post_status' => 'publish',
        'meta_query' => [$tagArr]
    ];

    $parent = new WP_Query( $arg );

    if ( $parent->have_posts() ) : ?>
           <?php while ( $parent->have_posts() ) : $parent->the_post(); 
                $officeErevan = get_field('office-erevan', get_the_ID());
                $officeTaganrog = get_field('office-taganrog', get_the_ID());
                $officeRemotely = get_field('office-distance', get_the_ID()); 
                $officeArr = []; 
                if($officeTaganrog == true) $officeArr[] = get_field('word-taganrog', 'option');
                if($officeErevan == true) $officeArr[] = get_field('word-erevan', 'option');
                if($officeRemotely == true) $officeArr[] = get_field('word-remotely', 'option'); ?>
                <a href="<?php the_permalink(); ?>" class="vacancy-item">
                    <h2 class="vacancy-title"><?php the_title();?></h2>
                    <?php if(count($officeArr) > 0) echo '<div class="vacancy-tag">' . implode('/', $officeArr) . '</div>'; ?> 
                </a>
            <?php endwhile; ?>
    <?php endif; ?>