<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Стас
 * Date: 22.03.13
 * Time: 21:33
 * To change this template use File | Settings | File Templates.
 */

namespace Repository\Adapter;

interface AdapterInterface {

  /**
   * @param $host
   * @param $user
   * @param $password
   *
   * @return mixed
   */
  public function connect($host, $user, $password);

  /**
   * @return mixed
   */
  public function disconnect();

  /**
   * @param $name
   *
   * @return mixed
   */
  public function useDB($name);

  /**
   * @param $sql
   *
   * @return mixed
   */
  public function query($sql);

  /**
   * @param $value
   *
   * @return mixed
   */
  public function escape($value);

}