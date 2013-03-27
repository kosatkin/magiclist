<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Стас
 * Date: 23.03.13
 * Time: 0:11
 * To change this template use File | Settings | File Templates.
 */

namespace Template\View;


interface ViewInterface {

  /**
   * @param $script
   *
   * @return mixed
   */
  public function render($script);

  /**
   * @param $script
   *
   * @return mixed
   */
  public function setLayout($script);

  /**
   * @return mixed
   */
  public function getLayout();

  /**
   * @param $code
   *
   * @return mixed
   */
  public function setContent($code);

  /**
   * @return mixed
   */
  public function content();

}