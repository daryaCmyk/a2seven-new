<?php
/*	Контент
---------------------------------------*/
require_once('includes/Content.php');

/*
---------------------------------------*/
global $idContactPage;
global $idVacancyPage;
global $idPrivatePage;

global $idPortfolioCategory;
global $idEventCategory;
global $idBlogCategory;

global $previewCountTags;

global $eventpostsPerPage;
global $portfolioPostsPerPage;
global $portfolioPostsPerLine;
global $blogPostsPerPage;
global $reviewsPostsPerPage;

global $wp_query;

$idContactPage = 240; // Контакты
$idVacancyPage = 242; // Вакансии
$idPrivatePage = 3; // Политика конфиденциальности

$idPortfolioCategory = 1; // Портфолио
$idEventCategory = 28; // Мероприятия
$idBlogCategory = 13; // Рубрика Блог

$previewCountTags = 3;

$eventpostsPerPage = 3;
$portfolioPostsPerPage = 8;
$portfolioPostsPerLine = 4;
$blogPostsPerPage = 12;
$reviewsPostsPerPage = 3;

/*
Функция подключения файла с передачей в него данных.
Пример использования: render_partial('includes/components/section-advantages-one.php', ['param' => $i]);
*/
if (!function_exists('render_partial')) {
    function render_partial($template, $render_data)
    {
        extract($render_data);
        require locate_template($template);
    }
}


function seo_optimize() {
	$url = $_SERVER["REQUEST_URI"];

	// Если урл состоит из нескольких уровней и is_front_page() выдаёт true, перекидываем на 404 страницу
	if( ($url !== '/' && is_front_page() && empty($_GET)) || get_field('hide-page-'.qtranxf_getLanguage()) ) {
		global $post, $wp_query;
		$wp_query->set_404();
		status_header(404);
		include( get_query_template( '404' ) );
		die();
	}
}
add_action('wp', 'seo_optimize');

// Функция получения данных из бд
function getData($connection, $request) {
	if($resultSelectData = mysqli_query($connection, $request)){
		$resultSelect = $resultSelectData->fetch_array(MYSQLI_ASSOC);
		preg_match_all("/\](.+?)\[/", $resultSelect['option_value'], $data);
		$resultRequest = $resultSelect['option_value'];
		if(!empty($data[1])) {
			$resultRequest = $data[1][$_POST['lang']];
		}
		return $resultRequest;
    }
}

if (function_exists('register_sidebar'))
	register_sidebar(array( 'id' => 'sidebar-1' ));


if (function_exists('add_theme_support')) {
	add_theme_support('menus');
}

if (function_exists('add_theme_support')) {
	add_theme_support('post-thumbnails');
}


remove_filter( 'the_content', 'wpautop' );// для контента


function my_myme_types($mime_types){
    $mime_types['svg'] = 'image/svg+xml'; // поддержка SVG
    return $mime_types;
}
add_filter('upload_mimes', 'my_myme_types', 1, 1);


function get_file_info( $file_info ) {

	$mime_types = array(
		'application/msword'            => 'doc',
		'image/jpeg'                    => 'jpg',
		'application/pdf'               => 'pdf',
		'image/png'                     => 'png',
		'application/vnd.ms-powerpoint' => 'ppt',
		'application/x-rar-compressed'  => 'rar',
		'image/tiff'                    => 'tiff',
		'text/plain'                    => 'txt',
		'application/vnd.ms-excel'      => 'xls',
		'application/zip'               => 'zip',
		'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => 'docx',
		'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
		'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         => 'xlsx',
	);

	$file_size                          = array( 'b', 'kb', 'Mb' );
	$file_info_output                   = array();
	$file_info_output[ 'size' ]			= filesize( get_attached_file( $file_info['id'] ) );

	$i = 0;

	while( $file_info_output[ 'size' ] > 1024 ) {
		$file_info_output[ 'size' ] = $file_info_output[ 'size' ] / 1024;
		$i++;
	}

	$file_info_output[ 'url' ]  = $file_info[ 'url' ];
	$file_info_output[ 'size' ] = round($file_info_output[ 'size' ], 2) . " " . $file_size[$i]; // Размер файла
	$file_info_output[ 'mime' ] = $mime_types[ $file_info[ 'mime_type' ] ]; // Расширение файла

	if(is_null($file_info_output[ 'mime' ])) $file_info_output[ 'mime' ] = 'none';

	$file_info_output['pathinfo'] = pathinfo( get_attached_file( $file_info['id'] ) );

	return $file_info_output;
}

/*	ACF
---------------------------------------*/
if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title'    => 'Главная страница',
		'menu_title'    => 'Главная страница',
		'menu_slug'     => 'main-settings',
		'capability'    => 'edit_posts',
		'icon_url'		=> 'dashicons-welcome-write-blog',
		'redirect'      => true
	));

	acf_add_options_page(array(
		'page_title'    => 'Общие настройки сайта',
		'menu_title'    => 'Общие настройки сайта',
		'menu_slug'     => 'general-settings',
		'capability'    => 'edit_posts',
		'icon_url'		=> 'dashicons-admin-generic',
		'redirect'      => true
	));

	acf_add_options_page(array(
		'page_title'    => 'Форма',
		'menu_title'    => 'Форма',
		'menu_slug'     => 'form-settings',
		'capability'    => 'edit_posts',
		'icon_url'		=> 'dashicons-admin-generic',
		'redirect'      => true
	));

}
add_filter( 'wpcf7_validate_configuration', '__return_false' );


/*	Подстраница
---------------------------------------*/
if( ! function_exists( 'is_subpage' ) ) {
    /**
     * Функция проверяет текущий объект, является ли он подстраницей
     * @param integer $post_parent_id ИД родительской страницы, если необходимо
     *     boolean Или false, если данный атрибут необходимо пропустить
     * @param WP_Post $post Объект записи, если необходимо
     * null Или null, если необходимо опустить параметр
     * @return boolean Возвращает результат проверки
     * integer Или ИД родителя, если $post_parent_id = false
     */
    function is_subpage( $post_parent_id = false, $post = null ) {
        if( is_null( $post ) ) global $post;
        if( ! is_page() ) return false;

        if( $post->post_parent ) {
            if( $post_parent_id ) {
                if( $post->post_parent != $post_parent_id && $post->post_parent > 0 ) {
                    return is_subpage( $post_parent_id, get_post( $post->post_parent ) );
                } else return true;
            } else return $post->post_parent;
        } else {
            return false;
        }
    }
}

// Подлючение файлов ///
function Enabling(){
	global $idContactPage;
	global $idVacancyPage;
	global $idPortfolioCategory;

	wp_register_script( 'script', get_template_directory_uri() . '/static/js/script.bundle.js', array(), rand(), true);
	wp_register_script( 'swiper', get_template_directory_uri() . '/static/js/swiper-bundle.min.js', array(), '1.0', true);

	//Page Js
	wp_register_script( 'index', get_template_directory_uri() . '/static/js/index.bundle.js', array(), rand(), true);
	wp_register_script( 'portfolio', get_template_directory_uri() . '/static/js/portfolio.bundle.js', array(), rand(), true);
	wp_register_script( 'blog', get_template_directory_uri() . '/static/js/blog.bundle.js', array(), rand(), true);
	wp_register_script( 'vacancy', get_template_directory_uri() . '/static/js/vacancy.bundle.js', array(), rand(), true);
	wp_register_script( 'text', get_template_directory_uri() . '/static/js/text.bundle.js', array(), rand(), true);
	wp_register_script( 'form', get_template_directory_uri() . '/static/js/consultation-form.js', array(), rand(), true);
    //webpack  Js

	// CSS
	wp_register_style( 'fancybox', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css', array(), '1.2', 'screen');
	wp_register_style( 'swiper', get_template_directory_uri() . '/static/css/swiper-bundle.min.css', array(), rand(), 'screen');

	wp_register_style( 'general', get_template_directory_uri() . '/static/css/general.css', array(), rand(), 'screen');
	wp_register_style( 'main', get_template_directory_uri() . '/static/css/main.css', array(), rand(), 'screen');
	wp_register_style( 'post', get_template_directory_uri() . '/static/css/post.css', array(), rand(), 'screen');

	//Page CSS
	wp_register_style( 'index', get_template_directory_uri() . '/static/css/index.css', array(), rand(), 'screen');
	wp_register_style( '404', get_template_directory_uri() . '/static/css/page-404.css', array(), rand(), 'screen');
	wp_register_style( 'portfolio', get_template_directory_uri() . '/static/css/portfolio-page.css', array(), rand(), 'screen');
	wp_register_style( 'blog', get_template_directory_uri() . '/static/css/blog-page.css', array(), rand(), 'screen');
	wp_register_style( 'contact', get_template_directory_uri() . '/static/css/page-contacts.css', array(), rand(), 'screen');
	wp_register_style( 'vacancy', get_template_directory_uri() . '/static/css/vacancy-page.css', array(), rand(), 'screen');
	wp_register_style( 'subvacancy', get_template_directory_uri() . '/static/css/subvacancy.css', array(), rand(), 'screen');

	// Подключение и инициализация файлов JS, CSS

	wp_enqueue_script('script');

	wp_enqueue_style('commons');
	wp_enqueue_style('general');

	wp_enqueue_script('swiper');
	wp_enqueue_style('swiper');

	if( is_front_page() ){ // Главная страница
		wp_enqueue_style('main');
		wp_enqueue_script('index');
		wp_enqueue_style('post');
	} elseif(is_404()) {
		wp_enqueue_style('404');
	} elseif(is_category()) {
		if(is_category($idPortfolioCategory)) {
			wp_enqueue_style('portfolio');
			wp_enqueue_script('portfolio');
		} else {
			wp_enqueue_style('blog');
			wp_enqueue_script('blog');
		}
	} elseif(is_page($idContactPage)) {
		wp_enqueue_style('contact');
	} elseif(is_page($idVacancyPage)) {
		wp_enqueue_style('vacancy');
		wp_enqueue_script('vacancy');
	} elseif(is_subpage($idVacancyPage)) {
		wp_enqueue_style('post');
		wp_enqueue_style('subvacancy');
	} else {
		wp_enqueue_style('fancybox');
		wp_enqueue_style('vacancy');
		wp_enqueue_style('post');
		wp_enqueue_script('text');
	}
}
add_action( 'wp_enqueue_scripts', 'Enabling', 1 );

// Рейтинг
function register_post_type_rating() {
	$post_type_labels = array(
		'name' => 'Рейтиг',
		'singular_name' => 'Компания',
		'add_new' => 'Добавить компанию',
		'add_new_item' => 'Добавить компанию',
		'edit_item' => 'Редактировать компанию',
		'new_item' => 'Новая компанию',
		'all_items' => 'Все компании',
		'view_item' => 'Просмотр компании на сайте',
		'search_items' => 'Искать компанию',
		'not_found' =>  'Компаний не найдено.',
		'not_found_in_trash' => 'В корзине нет компаний.',
		'menu_name' => 'Рейтинг'
	);

	$post_type_args = array(
		'labels' => $post_type_labels,
		'public' => true,
		'show_ui' => true,
		'has_archive' => true,
		'menu_icon' => 'dashicons-groups',
		'supports' => array('title', 'thumbnail'),
	);

	register_post_type('rating', $post_type_args);
}
add_action( 'init', 'register_post_type_rating' );

// Отзывы
function register_post_type_reviews() {
	$post_type_labels = array(
		'name' => 'Отзывы',
		'singular_name' => 'Отзывы',
		'add_new' => 'Добавить отзыв',
		'add_new_item' => 'Добавить отзыв',
		'edit_item' => 'Редактировать отзыв',
		'new_item' => 'Новый отзыв',
		'all_items' => 'Все отзывы',
		'view_item' => 'Просмотр отзыва на сайте',
		'search_items' => 'Искать отзыв',
		'not_found' =>  'Отзывы не найдены.',
		'not_found_in_trash' => 'В корзине нет отзывов.',
		'menu_name' => 'Отзывы'
	);

	$post_type_args = array(
		'labels' => $post_type_labels,
		'public' => true,
		'show_ui' => true,
		'has_archive' => true,
		'menu_icon' => 'dashicons-media-default',
		'supports' => array('title', 'thumbnail'),
	);

	register_post_type('reviews', $post_type_args);
}
add_action( 'init', 'register_post_type_reviews' );

// Сотрудники
function register_post_type_staff() {
	$post_type_labels = array(
		'name' => 'Сотрудники',
		'singular_name' => 'Сотрудники',
		'add_new' => 'Добавить сотрудника',
		'add_new_item' => 'Добавить сотрудника',
		'edit_item' => 'Редактировать сотрудника',
		'new_item' => 'Новый сотрудник',
		'all_items' => 'Все сотрудники',
		'view_item' => 'Просмотр сотрудника на сайте',
		'search_items' => 'Искать сотрудника',
		'not_found' =>  'Сотрудники не найдены.',
		'not_found_in_trash' => 'В корзине нет сотрудников.',
		'menu_name' => 'Сотрудники'
	);

	$post_type_args = array(
		'labels' => $post_type_labels,
		'public' => true,
		'show_ui' => true,
		'has_archive' => true,
		'menu_icon' => 'dashicons-universal-access-alt',
		'supports' => array('title', 'thumbnail'),
	);

	register_post_type('staff', $post_type_args);
}
add_action( 'init', 'register_post_type_staff' );

## отключение создания миниатюр файлов для указанных размеров
add_filter( 'intermediate_image_sizes', 'delete_intermediate_image_sizes' );
function delete_intermediate_image_sizes( $sizes ){
	return array_diff( $sizes, [
		'thumbnail',
		'medium',
		'1536x1536',
		'2048x2048',
	] );
}

add_filter( 'big_image_size_threshold', '__return_zero' );

// Отключение стилей для редактора Gutenberg
function wpassist_remove_block_library_css(){
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
}
add_action( 'wp_enqueue_scripts', 'wpassist_remove_block_library_css' );

// Удаление типов постов
function remove_default_post_type() {
	remove_menu_page( 'edit-comments.php' );// Комментарии
}
add_action( 'admin_menu', 'remove_default_post_type' );

/* Article-ajax */
function get_article() {
	get_template_part('components/ajax/articles-ajax');
	die();
}

add_action( 'wp_ajax_get_articles', 'get_article' );
add_action( 'wp_ajax_nopriv_get_articles', 'get_article' );

function submenu_tags() {
	$GLOBALS['q_config']['language'] = $_GET['lang'];

	$tags = get_tags_in_cat($_GET['cat']);
	?>
	<?php if ($_GET['type'] == 'desk') : ?>
	<ul class="sub-menu">
		<?php
		foreach ($tags as $tag_slug => $tag_name) {
			?>
			<li class="menu-item menu-item-type-custom menu-item-object-custom">
				<a href="/<?=$_GET['cat-slug']?>/?tag=<?=$tag_slug?>">
					<span><?=$tag_name?></span>
				</a>
			</li>
			<?php
		}
		?>
	</ul>
	<?php elseif ($_GET['type'] == 'mobile') : ?>
	<ul class="sub-menu is-collapsed">
		<?php
		foreach ($tags as $tag_slug => $tag_name) {
			?>
			<li class="menu-item menu-item-type-post_type menu-item-object-page">
				<a href="/<?=$_GET['cat-slug']?>/?tag=<?=$tag_slug?>"><?=$tag_name?></a>
			</li>
			<?php
		}
		?>
	</ul>
	<?php endif; ?>
	<?php
	die();
}

add_action( 'wp_ajax_submenu_tags', 'submenu_tags' );
add_action( 'wp_ajax_nopriv_submenu_tags', 'submenu_tags' );

/* Blog-ajax */
function get_blog() {
	get_template_part('components/ajax/blog-ajax');
	die();
}

add_action( 'wp_ajax_get_blogs', 'get_blog' );
add_action( 'wp_ajax_nopriv_get_blogs', 'get_blog' );

/* Vacancy-ajax */
function get_job() {
	get_template_part('components/ajax/vacancy-ajax');
	die();
}

add_action( 'wp_ajax_get_jobs', 'get_job' );
add_action( 'wp_ajax_nopriv_get_jobs', 'get_job' );


// Вывод меток в категориях
function get_tags_in_cat($cat_id) {
    $posts = get_posts( array('category' => $cat_id, 'numberposts' => -1) );
    $tags = array();

    foreach($posts as $post)
    {
        $post_tags = get_the_tags($post->ID);
        if( !empty($post_tags) )
            foreach($post_tags as $tag)
                $tags[$tag->slug] = $tag->name;

    }
    asort($tags);
    return $tags;
}

/*Стили в админку*/
add_action('admin_head', 'moi_novii_style');
function moi_novii_style() {
	print '<style>
		.media-attachments-filter-heading {display: none; }
	</style>';
}

/*Исправление тайтлов и описания сео-плагина*/
add_filter( 'wpseo_opengraph_title', 'joe_remove_yoast_meta' );
function joe_remove_yoast_meta( $filter ){
	$filter = wp_title('', false);
	return $filter;
}

add_filter( 'wpseo_metadesc', 'joe_remove_yoast_metadesc' );
add_filter( 'wpseo_opengraph_desc', 'joe_remove_yoast_metadesc' );
function joe_remove_yoast_metadesc( $filter ){
	preg_match_all("/\](.+?)\[/", $filter, $data);
	if(!empty($data[1])) {
		$filter = $data[1][array_search(qtranxf_getLanguage(), qtranxf_getSortedLanguages())];
	}

	return $filter;
}

remove_filter('get_the_time', 'qtranxf_timeFromPostForCurrentLanguage',0,3);
remove_filter('get_the_date', 'qtranxf_dateFromPostForCurrentLanguage',0,3);
remove_filter('get_the_modified_date', 'qtranxf_dateModifiedFromPostForCurrentLanguage',0,2);