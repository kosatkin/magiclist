<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Стас
 * Date: 22.03.13
 * Time: 21:42
 * To change this template use File | Settings | File Templates.
 */

namespace Repository\Adapter\Mysql;
use Repository\Adapter\AdapterAbstract;
use Repository\Adapter\Mysql\MySqlException;
use Repository\Adapter\AdapterFetch;

require_once 'MySqlException.php';
require_once 'Repository/Adapter/AdapterAbstract.php';
require_once 'Repository/Adapter/AdapterFetch.php';

class MySqlAdapter extends AdapterAbstract implements AdapterFetch
{
  private $result;

  public function setResult($result)
  {
    $this->result=$result;
  }

  public function getResult()
  {
    return $this->result;
  }

  /**
   * @param $host
   * @param $user
   * @param $password
   *
   * @throws MySqlException
   * @return mixed
   */
  public function connect($host,$user,$password)
  {
    $connection = mysql_connect($host, $user, $password);
    if(!$connection)
      throw new MySqlException('Cannot connect to host. Reason: '. mysql_error());
    $this->setConnection($connection);
    return $connection;
  }

  /**
   * @throws MySqlException
   * @return mixed
   */
  public function disconnect()
  {
    if(null == $this->getConnection())
      throw new MySqlException('Mysql connection is not isset');

    return mysql_close($this->getConnection());
  }

  /**
   * @param $sql
   *
   * @throws MySqlException
   * @return mixed
   */
  public function query($sql)
  {
    // todo Жеская зависимость от настроек.
    $this->connect(MYSQL_HOST,MYSQL_USER,MYSQL_PASSWORD);
    $this->useDB(MYSQL_DATABASE);

    if(null == $this->getConnection())
      throw new MySqlException('Mysql connection is not isset');

    $result = mysql_query($sql,$this->getConnection());
    if(false === $result)
      throw new MySqlException('Cannot execute query. Reason: '.mysql_error($this->getConnection()));

    $this->disconnect();

    $this->setResult($result);
    return $this;
  }

  /**
   * @param $value
   *
   * @throws MySqlException
   * @return mixed
   */
  public function escape($value)
  {
    $this->connect(MYSQL_HOST,MYSQL_USER,MYSQL_PASSWORD);
    $this->useDB(MYSQL_DATABASE);
    if(null == $this->getConnection())
      throw new MySqlException('Mysql connection is not isset');

    if(null == $this->getConnection())
      throw new MySqlException('Mysql connection is not isset');

    $result = mysql_real_escape_string($value,$this->getConnection());

    if(false === $result)
      throw new MySqlException('Cannot execute query. Reason: '.mysql_error($this->getConnection()));

    $this->disconnect();

    return $result;
  }

  /**
   * Получить массив результата выборки
   * @return mixed
   */
  public function fetchAll()
  {
    $data = $this->getResult();

    $result = array();
    while($f = mysql_fetch_assoc($data))
      $result[] = $f;

    return $result;
  }

  /**
   * @param $name
   * @throws MySqlException
   * @return mixed
   */
  public function useDB($name)
  {
    if(!mysql_select_db($name,$this->getConnection()))
      throw new MySqlException('Cannot use DB. Reason: '. mysql_error($this->getConnection()));
  }
}