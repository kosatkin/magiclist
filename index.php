<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Стас
 * Date: 23.03.13
 * Time: 0:25
 */

set_include_path(get_include_path() . PATH_SEPARATOR .  realpath(__DIR__) . DIRECTORY_SEPARATOR . 'Library');

// Загружаем общие настройки системы
require_once 'config/options.php';

// Подключаем автозагрузчик
require_once 'library/autoload.php';

$application = new \Application\SimpleApplication();
$application->run();