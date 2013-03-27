<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Стас
 * Date: 22.03.13
 * Time: 22:03
 * To change this template use File | Settings | File Templates.
 */

namespace Request\Adapter;
require_once 'AdapterInterface.php';

class HttpAdapter implements AdapterInterface
{
  private $get;
  private $post;

  public function __construct()
  {
    $this->get = $_GET;
    $this->post = $_POST;
  }

  /**
   * @return mixed
   */
  public function isPost()
  {
    return ($_SERVER['REQUEST_METHOD'] === 'POST');
  }

  /**
   * @return mixed
   */
  public function getParams()
  {
    return $this->get;
  }

  /**
   * get post data
   * @return mixed
   */
  public function getPost()
  {
    return $this->post;
  }

  /**
   * is AJAX
   * @return mixed
   */
  public function isXmlHttpRequest()
  {
    $xmlHttpRequest = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    return $xmlHttpRequest;
  }

  /**
   * @param $response
   *
   * @return mixed
   */
  public function response($response)
  {
    echo json_encode($response);
    exit;
  }

  /**
   * @param $url
   *
   * @return mixed
   */
  public function redirect($url)
  {
    header('Location: '.$url);
    exit;
  }
}