<?php
require_permission('manage products');

// get vars from url
$pid = isset($vars[1]) ? $vars[1] : null;
if (is_null($pid)) {
  dispatch('core/404');
  exit;
}
$product = Product::findById($pid);
if (is_null($product)) {
  dispatch('core/404');
  exit;
}

// delete the product
if ($product->delete()) {
  Message::register(new Message(Message::SUCCESS, '产品删除'));
} else {
  Message::register(new Message(Message::DANGER, '产品删除失败'));
}
HTML::forward('panel/admin/product/list');