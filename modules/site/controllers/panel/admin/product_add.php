<?php
require_permission('manage products');

if (isset($_POST['submit'])) {
  require 'product_update_logic.php';
}

$html = new HTML();

$product_form = $html->render('site/panel/admin/product_add', array(
    'product' => new Product()
));

$html->renderOut('site/panel/html_header', array('title' => '添加商品'));
$html->renderOut('site/panel/nav-left');

$html->output('<div class="gray-bg dashbard-1" id="page-wrapper">');
$html->renderOut('site/panel/nav-top');
$html->renderOut('site/panel/page-header', array(
    'title' => '添加商品',
    'breadcrumb' => array(
        '控制面板' => uri('panel'),
        '管理产品' => array(
            '所有产品列表' => uri('panel/admin/product/list'),
            '添加商品' => uri('panel/admin/product/add')
        ),
        '添加商品' => null,
    )
));
$html->output($product_form);
$html->output('</div>');

$html->renderOut('site/panel/html_footer');