<section class="page vacancy-page text-page">
    <div class="container">
        <h1 class="page-title"><?php the_title(); ?></h1>

        <ul class="vacancy-tags">
            <li class="vacancy-tags__item tags-item--active" data-vacancy=""><?php echo get_field('all-vacansies', 'option');?></li>
            <li class="vacancy-tags__item" data-vacancy="office-erevan">
            <?php echo get_field('word-office-erevan', 'option'); ?>
            </li>
            <li class="vacancy-tags__item" data-vacancy="office-taganrog"> 
            <?php echo get_field('word-office-taganrog', 'option'); ?>
            </li>
            <li class="vacancy-tags__item" data-vacancy="office-distance">
                <?php echo get_field('word-remotely', 'option'); ?>
            </li>
        </ul>

        <?php 
            $args = array(
                'post_type'      => 'page',
                'posts_per_page' => -1,
                'post_parent'    => get_the_ID(),
                'order'          => 'ASC',
                'orderby'        => 'menu_order',
                'post_status' => 'publish'
            );

            $parent = new WP_Query( $args );

            if ( $parent->have_posts() ) : ?>
                <div class="vacancy-wrap">
                    <?php while ( $parent->have_posts() ) : $parent->the_post(); 
                        $officeErevan = get_field('office-erevan', get_the_ID());
                        $officeTaganrog = get_field('office-taganrog', get_the_ID());
                        $officeRemotely = get_field('office-distance', get_the_ID()); 
                        $officeArr = []; 
                        if($officeTaganrog == true) $officeArr[] = get_field('word-taganrog', 'option');
                        if($officeErevan == true) $officeArr[] = get_field('word-erevan', 'option');
                        if($officeRemotely == true) $officeArr[] = get_field('word-remotely', 'option'); ?>
                        <a href="<?php the_permalink(); ?>" class="vacancy-item">
                            <h2 class="vacancy-title"><?php the_title(); ?></h2>
                            <?php if(count($officeArr) > 0) echo '<div class="vacancy-tag">' . implode('/', $officeArr) . '</div>'; ?> 
                        </a>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
    </div>
</section>