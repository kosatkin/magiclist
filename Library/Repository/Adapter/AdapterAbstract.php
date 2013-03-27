<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Стас
 * Date: 22.03.13
 * Time: 21:33
 * To change this template use File | Settings | File Templates.
 */

namespace Repository\Adapter;

require_once 'AdapterInterface.php';

abstract class AdapterAbstract implements AdapterInterface
{
  private $connection;

  public function setConnection($connection)
  {
    $this->connection=$connection;
  }

  public function getConnection()
  {
    return $this->connection;
  }
}