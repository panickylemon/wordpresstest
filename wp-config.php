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
/** Имя базы данных для WordPress */
define('DB_NAME', 'wordpress');

/** Имя пользователя MySQL */
define('DB_USER', 'admin');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', '123');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         '{&dr-f_cxCR;Lib2&o2`C|y3TwLF%[d^3/=|8IeN&{}m1<wU[YJfD4rwbTi+5L3Z');
define('SECURE_AUTH_KEY',  's|uR`c_8-3&1_yN6i]UjJ^ZXYVJmlF5Y]t1lzbu*|1|UGk|-w;G<QG-bA6<WpYR4');
define('LOGGED_IN_KEY',    'Lvr9BlCiudgm84w!)OqEP}z[lk!Fom|V4I#W(|o/^QziC+I)E=44p.bH_3u`~9uo');
define('NONCE_KEY',        's@Xsd,toi=hJ#wY.D0}t[>#vf-flG%Hj+P+=FRFx4qLdKvNke%F:)o}nP[_-pM-7');
define('AUTH_SALT',        '/J+{(OPD+49TA]=_@#8t(jgjov+IkNYexDjq,[4Y|hXr2+[HbNjuJWu]UIvPAneI');
define('SECURE_AUTH_SALT', 'Q6v!+fys+|6V}QLP1)O:!,6v>@ZJb<08T~`$-(}~X=0M!GaAW~/NxaP;f?(Gr6,b');
define('LOGGED_IN_SALT',   '.Z2$w4;8seuKc~pH|Xs~ZVrUqN43oHj-z$I)P>L|Tym:>/@Aomo}oR$XF_ZoyR+[');
define('NONCE_SALT',       '<% 2RH.}-R<+ B|WlR/^7$-!k.[cZ9@6HmXIlb;X;t+A VxEhgo`Y<|U)yZRSZ_h');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'ffrggd_';

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

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
