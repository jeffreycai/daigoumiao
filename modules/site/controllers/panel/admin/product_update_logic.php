<?php
require_permission('manage products');


// prepare vars
$pid = isset($_POST['pid']) ? strip_tags($_POST['pid']) : 0;
$title = isset($_POST['title']) ? strip_tags($_POST['title']) : null;
$description = isset($_POST['description']) ? $_POST['description'] : null;
$active = isset($_POST['active']) ? 1 : 0;
$price = isset($_POST['price']) ? strip_tags($_POST['price']) : null;
$thumbnail = isset($_FILES['thumbnail']) ? $_FILES['thumbnail'] : null;

$product = Product::findById($pid);
if (is_null($product)) {
  $product = new Product();
}

// validation
$messages = array();
if (empty($title)) {
  $messages[] = new Message(Message::DANGER, '请填写标题');
}
if (!preg_match('/^\d+(\.\d+)?$/', $price)) {
  $messages[] = new Message(Message::DANGER, '价格必须为数字');
}

if (sizeof($messages) > 0) {
  Message::register($messages);
// succeed
} else {
  // do update
  $product->setTitle($title);
  $product->setDescription($description);
  $product->setActive($active);
  $product->setPrice(floatval($price));
  if ($product->save()) {
    Message::register(new Message(Message::SUCCESS, empty($pid) ? '新产品添加成功' : '产品更新成功'));
    HTML::forwardBackToReferer();
  } else {
    Message::register(new Message(Message::DANGER, '系统错误，产品更新失败'));
  }
}





