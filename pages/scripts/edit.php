<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Стас
 * Date: 24.03.13
 * Time: 21:16
 */

$address = 'localhost';
$port    = DEFAULT_SOCKET_PORT;

$view = new Template\View\View();
$adapter = new Repository\Adapter\Mysql\MySqlAdapter();
$request = new Request\Adapter\HttpAdapter();

if($request->isXmlHttpRequest())
{
  $view->setLayout(null);
  $view->hide = true;
}


$params = $request->getParams();
if(!empty($params['id']) && is_numeric($params['id']))
  $id = $params['id'];
else
  $id = 0;

if($request->isPost())
{
  $post = $request->getPost();
  if($id)
  {
    $query = '
      update
        shopping_list
      set
        `name` = \''.$adapter->escape($post['name']).'\'
      where
        `id` = '.$adapter->escape($id).'
    ';
  } else {
    $query = '
      insert into
        shopping_list
      (`name`)
      values
      (\''.$adapter->escape($post['name']).'\')
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
    socket_close($socket);

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
  $query = '
    select
      `name`
    from
      shopping_list
    where
      `id` = '.$adapter->escape($id).'
  ';
  $result = $adapter->query($query)->fetchAll();
  $view->name = empty($result[0]['name'])?'':$result[0]['name'];
  $view->id = $id;
}

$view->render('edit.phtml');