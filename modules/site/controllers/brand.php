<?php

$bid = isset($vars[1]) ? $vars[1] : null;
$brand;
if (is_null($bid)) {
  dispatch('site/404');
  exit;
}
$brand = Brand::findById($bid);
if (is_null($brand)) {
  dispatch('site/404');
  exit;
}

$page = isset($_GET['page']) ? $_GET['page'] : 1;
if (!preg_match('/^\d+$/', $page)) {
  dispatch('site/404');
  exit;
}
$perpage = 12;
$total = Item::countAllByBrand($bid, true);
$total_page = ceil($total / $perpage);



$html = new HTML();

$html->renderOut('site/html_header', array(
    'title' => '商品品牌 - ' . $brand->getName() . ' :: ' . $settings['sitename'],
    'body_class' => 'brand'
));
$html->renderOut('site/block/topnav');
//$html->renderOut('site/block/hero_home');
$html->renderOut('site/block/header', array(
    'title' => '品牌 - ' . $brand->getName()
));
$html->renderOut('site/layout/fullpage', array(
    'main_region' => $html->render('site/layout/region/blocks', array(
        'blocks' => array(
//            'breadcrumb' => $html->render('site/components/breadcrumb', array(
//                'items' => array(
//                    '首页' => uri(''),
//                    '标签 - ' . $brand->getName() => null
//                )
//            )),
            'items' => $html->render('site/block/items', array(
                'items' => Item::findAllByBrandWithPage($brand, $page, $perpage, true),
                'current_page' => $page,
                'total_page' => $total_page,
                'total' => $total,
                'pager' => $html->render('site/components/pagination', array('total' => $total_page, 'page' => $page)),
                'perpage' => $perpage,
//                'title' => '标签 - ' . $brand->getName() 
            )),
            'taxonomy_nav' => $html->render('site/block/taxonomy_nav'),
        )
    )),
));
$html->renderOut('site/block/footer');
$html->renderOut('site/html_footer');