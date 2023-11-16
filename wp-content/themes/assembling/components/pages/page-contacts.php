<section class="page page-contact section-form">
    <div class="container">
        <h1 class="page-title"><?php the_title($idContactPage); ?></h1>

        <div class="contacts-wrapper">
            <div class="contacts" itemscope itemtype="http://schema.org/LocalBusiness">
                <p class="contacts__title" style="display: none;" itemprop="name"><?php the_field('company-name', 'option'); ?></p>

                <div class="row">
                    <div class="col-md-8">
                        <?php get_template_part('includes/form-consultation')?>
                    </div>
<!--                    <div class="neeewws"  style="display: none;">-->
<!--                        --><?php //get_template_part('includes/new-form-consultation')?>
<!--                    </div>-->

                    <div class="col-md-3">
                        <?php $contacts = get_field('contact-repeater', 'option');
                        if($contacts) {
                            echo '<div class="contact-wrap">';
                                foreach ($contacts as $contact) {
                                    $address = $contact['contact-repeater__address'];
                                    $tel = $contact['contact-repeater__tel'];
                                    $telLink = $contact['contact-repeater__tel-link'];
                                    $mail = $contact['contact-repeater__email'];

                                    if($address) {
                                        echo '<div class="contact"><p class="contact__text" itemprop="address">' . $address . '</p></div>';
                                    }

                                    if($tel && $telLink) {
                                        echo '<div class="contact"><a href="tel:' . $telLink . '" class="contact__text link" itemprop="telephone">' . $tel . '</a></div>';
                                    }

                                    if($mail) {
                                        echo '<div class="contact"><a href="mailto:' . $mail . '" class="contact__text link link-email" itemprop="email">' . $mail . '</a></div>';
                                    }
                                }
                            echo '</div>';
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>