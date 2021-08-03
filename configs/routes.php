<?php
$routes['default_controller'] = 'productcontroller';
$routes['default_action'] = 'index';

$routes['dang-nhap'] = 'login/index';
$routes['san-pham'] = "ProductController/fetchData";
$routes['product'] = "ProductController/reloadData";
$routes['san-pham-add'] = "ProductController/add";
$routes['san-pham-update'] = "ProductController/update";
$routes['san-pham-delete'] = "ProductController/delete";