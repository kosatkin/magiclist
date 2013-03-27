<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Стас
 * Date: 22.03.13
 * Time: 23:37
 */

$view = new Template\View\View();
$adapter = new Repository\Adapter\Mysql\MySqlAdapter();
$request = new Request\Adapter\HttpAdapter();

if($request->isXmlHttpRequest())
  $view->setLayout(null);

if(!$request->isPost()) {
  $select = '
    select
      `id`,`name`
    from
      shopping_list
  ';
  $result = $adapter->query($select)->fetchAll();
  $view->data = $result;
} else {

}

$view->render('list.phtml');