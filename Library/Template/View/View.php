<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Стас
 * Date: 23.03.13
 * Time: 0:13
 * To change this template use File | Settings | File Templates.
 */

namespace Template\View;

require_once 'ViewInterface.php';
require_once 'EscapeInterface.php';

class View implements ViewInterface, EscapeInterface
{
  private $viewData = array();
  private $layout;
  private $content;

  public function __construct()
  {
    $script = realpath($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'layout' ) . DIRECTORY_SEPARATOR . 'layout.phtml';
    $this->setLayout($script);
  }

  /**
   * @return mixed
   */
  public function content()
  {
    return $this->content;
  }

  public function __set($key, $value)
  {
    $this->viewData[$key] = $value;
  }

  public function __get($key)
  {
    return empty($this->viewData[$key])?null:$this->viewData[$key];
  }

  /**
   * @param $script
   *
   * @return mixed
   */
  public function render($script)
  {
    ob_start();
    include $script;
    $content = ob_get_contents();
    ob_end_clean();
    $this->setContent($content);

    if(null !== $this->getLayout())
      return include $this->getLayout();
    else
      echo $content;
    return true;
  }

  /**
   * @param $script
   *
   * @return mixed
   */
  public function setLayout($script)
  {
    $this->layout = $script;
  }

  /**
   * @return mixed
   */
  public function getLayout()
  {
    return $this->layout;
  }

  /**
   * @param $code
   *
   * @return mixed
   */
  public function setContent($code)
  {
    $this->content = $code;
  }

  /**
   * Метод экранирования данных. Защита от XSS
   *
   * @param $value
   *
   * @return mixed
   */
  public function escape($value)
  {
    return htmlspecialchars($value);
  }
}