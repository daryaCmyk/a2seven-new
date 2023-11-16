<?php
$title = get_field('main-form-title', 'option');
if(get_field('form-footer__title', $args['id'])) $title = get_field('form-footer__title', $args['id']);
if($title) echo '<h2 class="section-title">' . $title . '</h2>';
$titleMails = strip_tags($title);
$formType = get_field('path-send', 'option');
?>
<form action="" class="contact-form <?php echo $formType; ?>" enctype="multipart/form-data" >
    <div class="" style="display: flex;flex-direction: column;">
        <label class="">
            <input type="text" class="" name="name" autocomplete="none" pattern="[a-zA-Zа-яА-ЯёЁ]+" maxlength="50">
<!--            <span class="">Представьтесь*</span>-->
<!--            <span class="">Обязательное поле</span>-->
        </label>
        <label class="">
            <input type="email" class="" name="email" autocomplete="none">
            <span class="">Email*</span>
<!--            <span class="">Обязательное поле</span>-->
<!--            <span class="">Неверный формат</span>-->
        </label>
        <label class="">
            <input type="tel" class="" name="phone" autocomplete="none">
            <span class="">Телефон</span>
        </label>
        <label class="">
            <textarea type="textarea" class="" rows="1" name="mess" autocomplete="none" maxlength="400" ></textarea>
            <span class="">Сообщение</span>
        </label>
    </div>
    <div class="">
        <input type="submit" value="Отправить"/>
        <label class="" for="file-uploader">
<!--            <div class="">Размер файла должен быть меньше 25 Mb</div>-->
            <input type="file" name="file" id="file-uploader">
<!--            <div class="">-->
<!--                <svg class="" role="image">-->
<!--                    <use xlink:href="https://a2seven.ru/wp-content/themes/assembling/static/images/sprite.svg#clip"></use>-->
<!--                </svg>-->
<!--                <span class="" data-title="Прикрепить файл">Прикрепить файл</span>-->
<!--            </div>-->
        </label>
<!--        <span class="">-->
<!--            <svg class="" role="image">-->
<!--                <use xlink:href="https://a2seven.ru/wp-content/themes/assembling/static/images/sprite.svg#close"></use>-->
<!--            </svg>-->
<!--        </span>-->
    </div>
</form>
