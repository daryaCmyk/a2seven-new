<?php
$title = get_field('main-form-title', 'option');
if(get_field('form-footer__title', $args['id'])) $title = get_field('form-footer__title', $args['id']);
 if($title) echo '<h2 class="section-title">' . $title . '</h2>';
 $titleMails = strip_tags($title);
 $formType = get_field('path-send', 'option');
 ?>
<form action="callback" class="contact-form <?php echo $formType; ?>" enctype="multipart/form-data">
    <?php if($formType == 'mail'): ?>
        <input type='hidden' name='title' value='<?php echo $titleMails; ?>'>
        <input type='hidden' name='link' value='<?php echo bloginfo( 'url' ); echo $_SERVER['REQUEST_URI']; ?>'>
        <input type='hidden' name='action' value='callback'>
    <?php else: ?>
        <input type='hidden' name='site' value='<?php echo 'website_' . qtranxf_getLanguage(); ?>'>
    <?php endif; ?>
    <?php wp_nonce_field(); ?>

    <div class="contact-form__wrapper">
        <label class="contact-field field-full">
            <input type="text" class="contact-field__input" name="name" autocomplete="none"  pattern="[a-zA-Zа-яА-ЯёЁ]+" maxlength="50">
            <span class="contact-field__text"><?php the_field('field-name', 'option'); ?></span>
            <span class="contact-field__req contact-field__req-1"><?php the_field('field-required', 'option'); ?></span>
        </label>
        <label class="contact-field">
            <input type="email" class="contact-field__input" name="email" autocomplete="none">
            <span class="contact-field__text"><?php the_field('field-email', 'option'); ?></span>
            <span class="contact-field__req contact-field__req-1"><?php the_field('field-required', 'option'); ?></span>
            <span class="contact-field__req contact-field__req-2"><?php the_field('field-required-2', 'option'); ?></span>
        </label>
        <?php if(get_field('field-phone', 'option')): ?>
            <label class="contact-field">
                <input type="tel" class="contact-field__input" name='phone' autocomplete="none">
                <span class="contact-field__text"><?php the_field('field-phone', 'option'); ?></span>
            </label>
        <?php endif;?>
        <?php if(get_field('field-message', 'option')): ?>
            <label class="contact-field field-full">
                <textarea type="textarea" class="contact-field__input" rows="1" name="message" autocomplete="none" maxlength="400"></textarea>
                <span class="contact-field__text"><?php the_field('field-message', 'option'); ?></span>
            </label>
        <?php endif;?>
    </div>
    <div class="contact-btn__wrap">
            <a href="javascript:void(0)" class="contact-form__button btn-black">
                <span><?php the_field('btn-send-consultation', 'option'); ?></span>
            </a>
            <?php if(get_field('field-file', 'option')): ?>
                <label class="contact-field__file" for="file-uploader">
                    <div class="file-error"><?php the_field('file-warning', 'option'); ?></div>
                    <input type="file" name="file" id="file-uploader">
                    <div class="file-information">
                        <svg class="file__svg" role="image">
                            <use xlink:href="<?php echo bloginfo('template_url'); ?>/static/images/sprite.svg#clip"></use>
                        </svg>
                        <span class="file-title" data-title="<?php the_field('field-file', 'option'); ?>"><?php the_field('field-file', 'option'); ?></span>
                    </div>
                </label>
                <span class="file-delete hidden">
                    <svg class="file-delete__svg" role="image">
                        <use xlink:href="<?php echo get_bloginfo('template_url'); ?>/static/images/sprite.svg#close"></use>
                    </svg>
                </span>
            <?php endif;?>
        </div>
</form>
