<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Стас
 * Date: 24.03.13
 * Time: 21:16
 */

$view = new Template\View\View();
$adapter = new Repository\Adapter\Mysql\MySqlAdapter();
$request = new Request\Adapter\HttpAdapter();

$address = 'localhost';
$port    = DEFAULT_SOCKET_PORT;

if($request->isXmlHttpRequest())
  $view->setLayout(null);

$params = $request->getParams();
if(!empty($params['id']) && is_numeric($params['id']))
  $id = $params['id'];
else
  $id = 0;

if(!$request->isPost())
{
  if($id)
  {
    $query = '
      delete from
        shopping_list
      where
        `id` = '.$adapter->escape($id).'
    ';
  }
  $adapter->query($query);

  // Посылаем уведомление о том, что таблица изменилась
  try {
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if ($socket < 0) {
      throw new Exception('socket_create() failed: '.socket_strerror(socket_last_error())."\n");
    }

    $result = socket_connect($socket, $address, $port);
    if ($result === false) {
      throw new Exception('socket_connect() failed: '.socket_strerror(socket_last_error())."\n");
    }

    $msg = 'set';
    socket_write($socket,$msg,strlen($msg));

  } catch (Exception $e) {
    echo "\nError: ".$e->getMessage();
    exit;
  }
  if (isset($socket)) {
    socket_close($socket);
  }

  if($request->isXmlHttpRequest()){
    $request->response(array('status' => 'success'));
  } else {
    $request->redirect('/?page=list');
  }
} else {
  die('What are you doing here?');
}