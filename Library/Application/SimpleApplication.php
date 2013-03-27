<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Стас
 * Date: 24.03.13
 * Time: 17:33
 */

namespace Application;
require_once 'ApplicationInterface.php';

class SimpleApplication implements ApplicationInterface
{
  public function __construct()
  {
    // todo Добавить настраиваемые пути
    set_include_path(get_include_path() . PATH_SEPARATOR .  realpath(PROJECT_BASE_PATH . DIRECTORY_SEPARATOR . 'pages') . DIRECTORY_SEPARATOR . 'scripts');
    set_include_path(get_include_path() . PATH_SEPARATOR .  realpath(PROJECT_BASE_PATH . DIRECTORY_SEPARATOR . 'pages') . DIRECTORY_SEPARATOR . 'views');
  }

  /**
   * Run application
   * @return mixed
   */
  public function run()
  {
    $page = empty($_GET['page']) ? APPLICATION_DEFAULT_PAGE : $_GET['page'];

    if(preg_match('~[^a-zA-Z0-9_-]+~', $page))
    {
      header('HTTP/1.1 500 Internal Server Error');
      die('Internal server error');
    }

    $pageFile = realpath(PROJECT_BASE_PATH . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . 'scripts') . DIRECTORY_SEPARATOR . $page . '.php';
    if(!file_exists($pageFile))
    {
      header('HTTP/1.0 404 Not Found');
      die('Page not found');
    }

    include $pageFile;
  }
}