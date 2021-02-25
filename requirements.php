<?php
/**
 * Application requirement checker script.
 *
 * In order to run this script use the following console command:
 * php requirements.php
 *
 * In order to run this script from the web, you should copy it to the web root.
 * If you are using Linux you can create a hard link instead, using the following command:
 * ln ../requirements.php requirements.php
 */

// you may need to adjust this path to the correct Yii framework path
// uncomment and adjust the following line if Yii is not located at the default path
//$frameworkPath = dirname(__FILE__) . '/vendor/yiisoft/yii2';

if (!isset($frameworkPath)) {
    $searchPaths = [
        dirname(__FILE__) . '/vendor/yiisoft/yii2',
        dirname(__FILE__) . '/../vendor/yiisoft/yii2',
    ];
    foreach ($searchPaths as $path) {
        if (is_dir($path)) {
            $frameworkPath = $path;
            break;
        }
    }
}

if (!isset($frameworkPath) || !is_dir($frameworkPath)) {
    $message = "<h1>Error</h1>\n\n"
        . "<p><strong>The path to yii framework seems to be incorrect.</strong></p>\n"
        . '<p>You need to install Yii framework via composer or adjust the framework path in file <abbr title="' . __FILE__ . '">' . basename(__FILE__) . "</abbr>.</p>\n"
        . '<p>Please refer to the <abbr title="' . dirname(__FILE__) . "/README.md\">README</abbr> on how to install Yii.</p>\n";

    if (!empty($_SERVER['argv'])) {
        // do not print HTML when used in console mode
        echo strip_tags($message);
    } else {
        echo $message;
    }
    exit(1);
}

require_once($frameworkPath . '/requirements/YiiRequirementChecker.php');
$requirementsChecker = new YiiRequirementChecker();

$gdMemo = $imagickMemo = 'Either GD PHP extension with FreeType support or ImageMagick PHP extension with PNG support is required for image CAPTCHA.';
$gdOK = $imagickOK = false;

if (extension_loaded('imagick')) {
    $imagick = new Imagick();
    $imagickFormats = $imagick->queryFormats('PNG');
    if (in_array('PNG', $imagickFormats)) {
        $imagickOK = true;
    } else {
        $imagickMemo = 'Imagick extension should be installed with PNG support in order to be used for image CAPTCHA.';
    }
}

if (extension_loaded('gd')) {
    $gdInfo = gd_info();
    if (!empty($gdInfo['FreeType Support'])) {
        $gdOK = true;
    } else {
        $gdMemo = 'GD extension should be installed with FreeType support in order to be used for image CAPTCHA.';
    }
}

/**
 * Adjust requirements according to your application specifics.
 */
$requirements = [
    // Database :
    [
        'by' => 'All DB-related classes',
        'condition' => extension_loaded('pdo'),
        'mandatory' => true,
        'name' => 'PDO extension'
    ],
    [
        'by' => 'All DB-related classes',
        'condition' => extension_loaded('pdo_mysql'),
        'mandatory' => false,
        'memo' => 'Required for MySQL database.',
        'name' => 'PDO MySQL extension'
    ],
    [
        'by' => 'All DB-related classes',
        'condition' => extension_loaded('pdo_pgsql'),
        'mandatory' => false,
        'memo' => 'Required for PostgreSQL database.',
        'name' => 'PDO PostgreSQL extension'
    ],
    [
        'by' => 'All DB-related classes',
        'condition' => extension_loaded('pdo_sqlite'),
        'mandatory' => false,
        'memo' => 'Required for SQLite database.',
        'name' => 'PDO SQLite extension'
    ],
    // Cache :
    [
        'by' => '<a href="http://www.yiiframework.com/doc-2.0/yii-caching-memcache.html">MemCache</a>',
        'condition' => extension_loaded('memcache') || extension_loaded('memcached'),
        'mandatory' => false,
        'memo' => extension_loaded('memcached') ? 'To use memcached set <a href="http://www.yiiframework.com/doc-2.0/yii-caching-memcache.html#$useMemcached-detail">MemCache::useMemcached</a> to <code>true</code>.' : '',
        'name' => 'Memcache extension'
    ],
    // CAPTCHA:
    [
        'by' => '<a href="http://www.yiiframework.com/doc-2.0/yii-captcha-captcha.html">Captcha</a>',
        'condition' => $gdOK,
        'mandatory' => false,
        'memo' => $gdMemo,
        'name' => 'GD PHP extension with FreeType support'
    ],
    [
        'by' => '<a href="http://www.yiiframework.com/doc-2.0/yii-captcha-captcha.html">Captcha</a>',
        'condition' => $imagickOK,
        'mandatory' => false,
        'memo' => $imagickMemo,
        'name' => 'ImageMagick PHP extension with PNG support'
    ],
    // PHP ini :
    'phpAllowUrlInclude' => [
        'by' => 'Security reasons',
        'condition' => $requirementsChecker->checkPhpIniOff("allow_url_include"),
        'mandatory' => false,
        'memo' => '"allow_url_include" should be disabled at php.ini',
        'name' => 'PHP allow url include'
    ],
    'phpExposePhp' => [
        'by' => 'Security reasons',
        'condition' => $requirementsChecker->checkPhpIniOff("expose_php"),
        'mandatory' => false,
        'memo' => '"expose_php" should be disabled at php.ini',
        'name' => 'Expose PHP'
    ],
    'phpSmtp' => [
        'by' => 'Email sending',
        'condition' => strlen(ini_get('SMTP')) > 0,
        'mandatory' => false,
        'memo' => 'PHP mail SMTP server required',
        'name' => 'PHP mail SMTP'
    ]
];

// OPcache check
if (!version_compare(phpversion(), '5.5', '>=')) {
    $requirements[] = [
        'by' => '<a href="http://www.yiiframework.com/doc-2.0/yii-caching-apccache.html">ApcCache</a>',
        'condition' => extension_loaded('apc'),
        'mandatory' => false,
        'name' => 'APC extension'
    ];
}

$result = $requirementsChecker->checkYii()->check($requirements)->getResult();
$requirementsChecker->render();
exit($result['summary']['errors'] === 0 ? 0 : 1);