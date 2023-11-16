<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //

/** The name of the database for WordPress */
define( 'DB_NAME', 'a2seven-com');

/** MySQL database username */
define( 'DB_USER', 'root');

/** MySQL database password */
define( 'DB_PASSWORD', 'root');

/** MySQL hostname */
define( 'DB_HOST', 'host.docker.internal');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Fbt:>Hs>|dWLkvL~s.^LS^>FvNYRkK1c1vnOIQexny[s<#qz9WWztv-vC@-j-q3V');
define('SECURE_AUTH_KEY',  'yX}0[o9-z9c8}%YF^dnMY~nt,qQLd4[$5[qn.xd$Vjgbkx)(e~$u]@T*b{O[zq~t');
define('LOGGED_IN_KEY',    'V~M|nVmE<uG4*Xd2.BFd.a+Ny(h#+V^[8DxxE}$/2[,K#VKd69lhg22Js*VTnHkV');
define('NONCE_KEY',        'lpiI[)x&7s:P-]ia|IY>7/$j/I>C}t<:v9JY,axze2j]xBvC{y|DxjO|~orD3y(P');
define('AUTH_SALT',        '#CH<c)]^N&Tb>53dWj<Lp(aOw-1b]N5dvY[!LQGkSFR+G#bZJig!|WU!dXM/A~~<');
define('SECURE_AUTH_SALT', '|<PC|*x,A(}H^SaiF,{Wh0n(>g|DpS(0~Vq3B^G-D3a%+oo0jMTqRGC6bk[Z{,E%');
define('LOGGED_IN_SALT',   '6&kbXteD19*]TGYnxMZ!Ji.qcT1aUuANQ$NBehP%k3c]WOIE.OQ(s0&M414r.sn*');
define('NONCE_SALT',       '-G}Br8pZ]<V12m[.!m([rzQQY{qLOz3ski}t4SrR()*{1/-O6qiRM/hVlO[M)>j7');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
	$_SERVER['HTTPS'] = 'on';
}
define('WP_HOME', 'https://'. $_SERVER['SERVER_NAME'] .'/');
define('WP_SITEURL', 'https://'. $_SERVER['SERVER_NAME'] .'/');
define('COOKIE_DOMAIN', $_SERVER['HTTP_HOST'] );
define('FS_METHOD', 'direct');

define('MAIL_HOST', 'mail.a2seven.ru');
define('MAIL_USERNAME', 'websiteapp');
define('MAIL_PASSWORD', 'XA6tSZpn4JdH3x');
define('MAIL_PORT', 587);
define('MAIL_FROM', 'website@tech.a2seven.ru');
define('MAIL_FROM_NAME', 'a2seven.com');

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');