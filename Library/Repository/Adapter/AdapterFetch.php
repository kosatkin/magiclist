<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Стас
 * Date: 24.03.13
 * Time: 20:00
 */

namespace Repository\Adapter;


interface AdapterFetch {

  /**
   * Получить массив результата выборки
   * @return mixed
   */
  public function fetchAll();

}