<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Стас
 * Date: 22.03.13
 * Time: 0:26
 */

define('DEFAULT_SOCKET_PORT', 10003);

header('Content-Type: text/plain;');
error_reporting(E_ALL ^ E_WARNING);
set_time_limit(0);
ob_implicit_flush();

echo "-= Server =-\n\n";

if(!function_exists('socket_create'))
  die('PHP module socket is not installed');

$address = 'localhost';
$port    = DEFAULT_SOCKET_PORT;

// Время последней модификации таблицы
$last = 0;

try {

  echo 'Create socket ... ';
  if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) < 0) {
    throw new Exception('socket_create() failed: '.socket_strerror(socket_last_error())."\n");
  } else {
    echo "OK\n";
  }

  echo 'Bind socket ... ';
  if (($ret = socket_bind($sock, $address, $port)) < 0) {
    throw new Exception('socket_bind() failed: '.socket_strerror(socket_last_error())."\n");
  } else {
    echo "OK\n";
  }

  echo 'Listen socket ... ';
  if (($ret = socket_listen($sock, 1000)) < 0) {
    throw new Exception('socket_listen() failed: '.socket_strerror(socket_last_error())."\n");
  } else {
    echo "OK\n";
  }

  do {
    if (($msgsock = socket_accept($sock)) < 0) {
      throw new Exception('socket_accept() failed: '.socket_strerror(socket_last_error())."\n");
    }

    if (false === ($buf = socket_read($msgsock, 1024))) {
      throw new Exception('socket_read() failed: '.socket_strerror(socket_last_error())."\n");
    }

    $response = 0;
    switch(trim($buf)){
      case 'get':
        $response = $last;
        socket_write($msgsock, $response, strlen($response));
        break;
      case 'set':
        $last = time();
        echo 'Been documented in the table at '.date('Y-m-d H:i:s',$last). PHP_EOL;
        break;
      case 'shutdown':
        break 2;
      case '':
        break;
      default:
        throw new Exception('Unknown command `'.$buf.'`');
        break;
    }

    socket_close($msgsock);

  } while (true);

} catch (Exception $e) {
  echo "\nError: ".$e->getMessage();
}

if (isset($sock)) {

  echo 'Close socket ... ';
  socket_close($sock);

}