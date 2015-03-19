<?php
require_permission('manage products');

$html = new HTML();
$html->renderOut('site/panel/html_header', array('title' => '管理产品'));
$html->renderOut('site/panel/nav-left');

$html->output('<div class="gray-bg dashbard-1" id="page-wrapper">');
$html->renderOut('site/panel/nav-top');
$html->renderOut('site/panel/page-header', array(
    'title' => '所有产品列表',
    'breadcrumb' => array(
        '控制面板' => uri('panel'),
        '管理产品' => array(
            '所有产品列表' => uri('panel/admin/product/list'),
            '添加商品' => uri('panel/admin/product/add')
        ),
        '所有产品列表' => null,
    )
));
$html->renderOut('site/panel/admin/product_list', array(
    'products' => Product::findAll()
));
$html->output('</div>');

$html->renderOut('site/panel/html_footer');