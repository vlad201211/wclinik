<?php
/**
 * Основные параметры WordPress.
 *
 * Этот файл содержит следующие параметры: настройки MySQL, префикс таблиц,
 * секретные ключи, язык WordPress и ABSPATH. Дополнительную информацию можно найти
 * на странице {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Кодекса. Настройки MySQL можно узнать у хостинг-провайдера.
 *
 * Этот файл используется сценарием создания wp-config.php в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать этот файл
 * с именем "wp-config.php" и заполнить значения.
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'widgetclinik');

/** Имя пользователя MySQL */
define('DB_USER', 'root');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', '');

/** Имя сервера MySQL */
define('DB_HOST', '127.0.0.1');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется снова авторизоваться.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'N7KDmaxqG],hmDAX~^YTgV,.9DHE4;bhW9 -.vInV[71wEy)w_k.jKvw2}Z?:F<m');
define('SECURE_AUTH_KEY',  'o~8CzC |#)c$oN#>Ty}4HPea9[~DfCl>iR+2$E/S?.NJ,fC ^a7oy}V#l-q]&_bh');
define('LOGGED_IN_KEY',    '8/?hj0s}pb-fSP&u*,yHoM8K,NVZhNPoA;R2|>X,+mRD(ZbR-=/hMIa%7i2k&J ?');
define('NONCE_KEY',        'Idc>&tbc5WO)@x09+- RY&~*hxL27)*0@xS(S>4w!r{3HU`vyy-z,T.(m*4{E8jY');
define('AUTH_SALT',        'y$7bwp.FE5@EKkB&5lCi]IM-dOHoQS ~oCcEV>%f2R|p#_D%9lz4`W#TF*WuM`NO');
define('SECURE_AUTH_SALT', 'HOQyl[(!I?]NJ:@Aib2UT^mJgl;|4s.u]4&`~:drE7eYUb$_Wm!O({e7$`fr6Eb<');
define('LOGGED_IN_SALT',   '~9DDLm7-WeVd8n#79cJ8K;_D>t0gvi$/g.jfcyxXi6 Nr$>F^gIPtH:/4k4APd{t');
define('NONCE_SALT',       'WN560qL!i0io5P[_3#>SjQIcAcBND+U>j*{<zkf1me9Ho:,5l^(+6@j6V=}7=)nq');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько блогов в одну базу данных, если вы будете использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Язык локализации WordPress, по умолчанию английский.
 *
 * Измените этот параметр, чтобы настроить локализацию. Соответствующий MO-файл
 * для выбранного языка должен быть установлен в wp-content/languages. Например,
 * чтобы включить поддержку русского языка, скопируйте ru_RU.mo в wp-content/languages
 * и присвойте WPLANG значение 'ru_RU'.
 */
define('WPLANG', 'ru_RU');

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Настоятельно рекомендуется, чтобы разработчики плагинов и тем использовали WP_DEBUG
 * в своём рабочем окружении.
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
