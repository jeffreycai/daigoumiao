<?php

$tid = isset($vars[1]) ? $vars[1] : null;
$tag;
if (is_null($tid)) {
  dispatch('site/404');
  exit;
}
$tag = Tag::findById($tid);
if (is_null($tag)) {
  dispatch('site/404');
  exit;
}

$page = isset($_GET['page']) ? $_GET['page'] : 1;
if (!preg_match('/^\d+$/', $page)) {
  dispatch('site/404');
  exit;
}
$perpage = 12;
$total = Item::countAllByTag($tid);
$total_page = ceil($total / $perpage);



$html = new HTML();

$html->renderOut('site/html_header', array(
    'title' => '商品标签 - ' . $tag->getName() . ' :: ' . $settings['sitename'],
    'body_class' => 'tag'
));
$html->renderOut('site/block/topnav');
//$html->renderOut('site/block/hero_home');
$html->renderOut('site/block/header', array(
    'title' => '标签 - ' . $tag->getName()
));
$html->renderOut('site/layout/fullpage', array(
    'main_region' => $html->render('site/layout/region/blocks', array(
        'blocks' => array(
//            'breadcrumb' => $html->render('site/components/breadcrumb', array(
//                'items' => array(
//                    '首页' => uri(''),
//                    '标签 - ' . $tag->getName() => null
//                )
//            )),
            'items' => $html->render('site/block/items', array(
                'items' => Item::findAllByTagWithPage($tag, $page, $perpage, true),
                'current_page' => $page,
                'total_page' => $total_page,
                'total' => $total,
                'pager' => $html->render('site/components/pagination', array('total' => $total_page, 'page' => $page)),
                'perpage' => $perpage,
//                'title' => '标签 - ' . $tag->getName() 
            )),
            'taxonomy_nav' => $html->render('site/block/taxonomy_nav'),
        )
    )),
));
$html->renderOut('site/block/footer');
$html->renderOut('site/html_footer');