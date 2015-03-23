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
if ($thumbnail) {
  switch ($thumbnail['error']) {
    case  UPLOAD_ERR_OK:
       if ($thumbnail && !preg_match('/^image/', $thumbnail['type'])) {
        $messages[] = new Message(Message::DANGER, i18n(array(
                    'en' => 'Please select an image file as thumbnail',
                    'zh' => '请选择图片文件作为缩略图上传'
        )));
      } else if ($thumbnail['size'] > $settings['thumbnail_max_size']) {
        $messages[] = new Message(Message::DANGER, i18n(array(
                    'en' => 'thumbnail file size can not be larger than ' . round($settings['thumbnail_max_size'] / 1000000) . 'MB',
                    'zh' => '缩略图图片大小不能超过'  . round($settings['thumbnail_max_size'] / 1000000, 1) . 'MB'
        )));
      }
      break;
    case  UPLOAD_ERR_NO_FILE:
      break;
    case UPLOAD_ERR_INI_SIZE:
      $messages[] = new Message(Message::DANGER, i18n(array(
                  'en' => 'Thumbnail file size can not be larger than ' . round($settings['thumbnail_max_size'] / 1000000) . 'MB',
                  'zh' => '缩略图图片大小不能超过'  . round($settings['thumbnail_max_size'] / 1000000, 1) . 'MB'
      )));
      break;
    default:
      $messages[] = new Message(Message::DANGER, i18n(array(
                  'en' => 'Error occured during upload. Please try again',
                  'zh' => '缩略图图片上传错误，请重试'
      )));
      break;
  }
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
    
    // handle thumbnail
    if ($thumbnail && $thumbnail['error'] == UPLOAD_ERR_OK) {
      load_library_wide_image();
      $image = WideImage::load($thumbnail['tmp_name']);
      $image = $image->resize($settings['thumbnail_width'], $settings['thumbnail_height']);
      $white = $image->allocateColor(255, 255, 255);
      $image = $image->resizeCanvas($settings['thumbnail_width'], $settings['thumbnail_height'], 'center', 'center', $white);
      $image->saveToFile(PRODUCT_THUMBNAIL_DIR . '/' . $product->getId() . '.jpg', 80);
      $product->setThumbnail($product->getId() . '.jpg');
      $product->save();

      @unlink($thumbnail['tmp_name']);
    }
    
    
    Message::register(new Message(Message::SUCCESS, empty($pid) ? '新产品添加成功' : '产品更新成功'));
    HTML::forwardBackToReferer();
  } else {
    Message::register(new Message(Message::DANGER, '系统错误，产品更新失败'));
  }
}





