<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Стас
 * Date: 24.03.13
 * Time: 18:34
 */

namespace Template\View;


interface EscapeInterface {

  /**
   * Метод экранирования данных. Защита от XSS
   * @param $value
   * @return mixed
   */
  public function escape($value);

}