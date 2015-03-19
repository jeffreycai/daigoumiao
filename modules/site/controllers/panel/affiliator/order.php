<?php
require_permission('order products');

$html = new HTML();
$html->renderOut('site/panel/html_header', array('title' => '下订单'));
$html->renderOut('site/panel/nav-left');

$html->output('<div class="gray-bg dashbard-1" id="page-wrapper">');
$html->renderOut('site/panel/nav-top');
$html->renderOut('site/panel/page-header', array(
    'title' => '订购代购商品',
    'breadcrumb' => array(
        '控制面板' => uri('panel'),
        '订购代购商品' => array(
            '选择商品' => uri('panel/order')
        ),
        '选择商品' => null,
    )
));
$html->renderOut('site/panel/affiliator/order', array(
    'products' => Product::findAll()
));
$html->output('</div>');

$html->renderOut('site/panel/html_footer');