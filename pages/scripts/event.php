<?php
set_time_limit(0);
ini_set('html_error', 0);
$begin = time();

$address = 'localhost';
$port    = DEFAULT_SOCKET_PORT;

$request = new Request\Adapter\HttpAdapter();
$post = $request->getPost();
$timestamp = empty($post['timestamp'])?time():$post['timestamp'];

while(time()-$begin < 25)
{
  try {
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if ($socket < 0) {
      throw new Exception('socket_create() failed: '.socket_strerror(socket_last_error())."\n");
    }

    $result = socket_connect($socket, $address, $port);
    if ($result === false) {
      throw new Exception('socket_connect() failed: '.socket_strerror(socket_last_error())."\n");
    }

    $msg = 'get';
    socket_write($socket,$msg,strlen($msg));
    $last = socket_read($socket, 128);

    if($post['timestamp'] < $last)
    {
      if (isset($socket)) {
        socket_close($socket);
      }
      $request->response(array('timestamp' => $last));
    }


  } catch (Exception $e) {
    echo "\nError: ".$e->getMessage();
    exit;
  }
  if (isset($socket)) {
    socket_close($socket);
  }
  sleep(1);
}
$request->response(array('status' => 'success'));