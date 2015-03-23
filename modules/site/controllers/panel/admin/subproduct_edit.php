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

// handle form submission
if (isset($_POST['submit'])) {

  $sps = array();
  $error_flag = 0;
  foreach ($_POST['subproduct'] as $sp) {
    foreach ($sp as $key => $val) {
      $sp[$key] = strip_tags(trim($val));
    }
    // get vars from $_POST
    $attribute = isset($sp['attribute']) && !empty($sp['attribute']) ? $sp['attribute'] : null;
    $price = isset($sp['price']) && !empty($sp['price']) ? $sp['price'] : null;
    $active = (isset($sp['active']) && $sp['active'] == "1") ? 1 : 0;
    
    // validation
    if (is_null($attribute)) {
      Message::register(new Message(Message::DANGER, '请填写参数'));
      $error_flag = 1;
      break;
    }
    if (!is_null($price) && !preg_match('/^\d+(\.\d+)?$/', $price)) {
      Message::register(new Message(Message::DANGER, '价钱的格式不正确'));
      $error_flag = 1;
      break;
    // if sucess
    } else {
      $subproduct = new SubProduct();
      $subproduct->setProductId($product->getId());
      $subproduct->setAttribute($attribute);
      $subproduct->setActive($active);
      if (!is_null($price)) {
        $subproduct->setPrice($price);
      }
      $sps[] = $subproduct;
    }
  }
  if ($error_flag == 0) {
    foreach (SubProduct::findAllByProductId($product->getId()) as $sb) {
      $sb->delete();
    }
    foreach ($sps as $sp) {
      $sp->save();
    }
    Message::register(new Message(Message::SUCCESS, '子商品更新成功'));
  }
  
  
  HTML::forwardBackToReferer();
}

// presentation
HTML::registerFooterUpper('<script src="/'.get_sub_root().'modules/site/assets/js/plugins/iCheck/icheck.min.js"></script>');


$html = new HTML();

$html->renderOut('site/panel/html_header', array('title' => '编辑子商品'));
$html->renderOut('site/panel/nav-left');

$html->output('<div class="gray-bg dashbard-1" id="page-wrapper">');
$html->renderOut('site/panel/nav-top');
$html->renderOut('site/panel/page-header', array(
    'title' => '编辑子商品',
    'breadcrumb' => array(
        '控制面板' => uri('panel'),
        '管理产品' => array(
            '所有产品列表' => uri('panel/admin/product/list'),
            '添加商品' => uri('panel/admin/product/add')
        ),
        '编辑子商品' => null,
    )
));
$html->renderOut('site/panel/admin/subproduct_edit', array(
    'product' => $product,
    'subproducts' => $product->getSubProducts()
));
$html->output('</div>');

$html->renderOut('site/panel/html_footer');