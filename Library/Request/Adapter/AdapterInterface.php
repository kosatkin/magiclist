<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Стас
 * Date: 22.03.13
 * Time: 21:57
 * To change this template use File | Settings | File Templates.
 */

namespace Request\Adapter;


interface AdapterInterface {

  /**
   * @return mixed
   */
  public function getParams();

  /**
   * @return mixed
   */
  public function isPost();

  /**
   * get post data
   * @return mixed
   */
  public function getPost();

  /**
   * is AJAX
   * @return mixed
   */
  public function isXmlHttpRequest();

  /**
   * @param $response
   * @return mixed
   */
  public function response($response);

  /**
   * @param $url
   * @return mixed
   */
  public function redirect($url);
}