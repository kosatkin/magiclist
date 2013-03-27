<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Стас
 * Date: 24.03.13
 * Time: 17:35
 */

if(defined('LOAD_APPLICATION') && LOAD_APPLICATION)
  require_once (__DIR__) . DIRECTORY_SEPARATOR . 'Application' . DIRECTORY_SEPARATOR . 'options.php';

if(defined('LOAD_TEMPLATE') && LOAD_TEMPLATE)
  require_once (__DIR__) . DIRECTORY_SEPARATOR . 'Template' . DIRECTORY_SEPARATOR . 'options.php';

if(defined('LOAD_REPOSITORY') && LOAD_REPOSITORY)
  require_once (__DIR__) . DIRECTORY_SEPARATOR . 'Repository' . DIRECTORY_SEPARATOR . 'options.php';

if(defined('LOAD_REQUEST') && LOAD_REQUEST)
  require_once (__DIR__) . DIRECTORY_SEPARATOR . 'Request' . DIRECTORY_SEPARATOR . 'options.php';