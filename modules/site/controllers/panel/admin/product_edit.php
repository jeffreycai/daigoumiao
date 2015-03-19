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
  require 'product_update_logic.php';
}

// presentation
$html = new HTML();

$product_form = $html->render('site/panel/admin/product_add', array(
    'product' => $product
));

$html->renderOut('site/panel/html_header', array('title' => '编辑商品'));
$html->renderOut('site/panel/nav-left');

$html->output('<div class="gray-bg dashbard-1" id="page-wrapper">');
$html->renderOut('site/panel/nav-top');
$html->renderOut('site/panel/page-header', array(
    'title' => '编辑商品',
    'breadcrumb' => array(
        '控制面板' => uri('panel'),
        '管理产品' => array(
            '所有产品列表' => uri('panel/admin/product/list'),
            '添加商品' => uri('panel/admin/product/add')
        ),
        '编辑商品' => null,
    )
));
$html->output($product_form);
$html->output('</div>');

$html->renderOut('site/panel/html_footer');