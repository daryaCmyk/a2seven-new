<?php global $idVacancyPage;?>
<section class="page text-page subvacancy-page">
    <div class="container">
        <div class="back-btn">
            <a href="<?php echo get_permalink($idVacancyPage); ?>">
                <svg role="img">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?php bloginfo('template_url'); ?>/static/images/sprite.svg#arr-back"></use> 
                </svg>
                <?php the_field('word-back', 'option'); ?>
            </a>
        </div>
        <h1 class="page-title"><?php the_title(); ?></h1>

        <?php $officeErevan = get_field('office-erevan');
                $officeTaganrog = get_field('office-taganrog');
                $officeRemotely = get_field('office-distance'); 
                $officeArr = []; 
                if($officeTaganrog == true) $officeArr[] = get_field('word-taganrog', 'option');
                if($officeErevan == true) $officeArr[] = get_field('word-erevan', 'option');
                if($officeRemotely == true) $officeArr[] = get_field('word-remotely', 'option');
                if(count($officeArr) > 0) echo '<div class="vacancy-tag">' . implode('/', $officeArr) . '</div>'; ?>

        <div class="content">
            <?php 
                while( have_rows('vacancy-content') ) {
                    the_row();
                    if( get_row_layout() == 'vacancy-content__text' ) {
                        echo '<div class="content-text">' . get_sub_field('content-text') . '</div>';
                    }
                    elseif( get_row_layout() == 'vacancy-content__description' ) {
                        $repeater = get_sub_field('vacancy-content__repeater');
                        if($repeater) {
                            echo '<div class="vacancy-description">';
                                foreach ($repeater as $value) {
                                    $title = $value['content-description__title'];
                                    $text = $value['content-description__text'];
                                    echo '<div class="row vacancy-row">';
                                        if($title) echo '<div class="col-md-5"><h4 class="vacancy-description__title">' . $title . '</h4></div>';
                                        if($text) echo '<div class="col-md-7"><div class="content-text">' . $text . '</div></div>';
                                    echo '</div>';
                                }
                            echo '</div>';
                        }
                    }
                }
            ?>
        </div>
    </div>
</section>