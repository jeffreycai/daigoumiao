<?php

//HTML::registerHeaderUpper('<link rel="stylesheet" href="'.uri('libraries/flexslider/flexslider.css', false).'" type="text/css" media="screen" />');
//HTML::registerFooterLower('<script type="text/javascript" src="'.uri('libraries/flexslider/jquery.flexslider-min.js', false).'"></script>');
//HTML::registerFooterLower('
//  <script type="text/javascript">
//    // Can also be used with $(document).ready()
//    $(window).load(function() {
//      $(\'.flexslider\').flexslider({
//        animation: "slide"
//      });
//    });
//  </script>
//');


$page = isset($_GET['page']) ? $_GET['page'] : 1;
if (!preg_match('/^\d+$/', $page)) {
  dispatch('site/404');
  exit;
}
$perpage = 12;
$total = Item::countAllTitleZh();
$total_page = ceil($total / $perpage);



$html = new HTML();

$html->renderOut('site/html_header', array(
    'title' => $settings['sitename'] . '  - 实时查询澳洲产品本地真实价格',
    'body_class' => 'home'
));
$html->renderOut('site/block/topnav');
$html->renderOut('site/block/hero_home');
//$html->renderOut('site/block/header');
$html->renderOut('site/layout/fullpage', array(
    'main_region' => $html->render('site/layout/region/blocks', array(
        'blocks' => array(
            'taxonomy_nav' => $html->render('site/block/taxonomy_nav'),
            'search_box' => $html->render('site/block/search_box'),
            'items' => $html->render('site/block/items', array(
                'items' => Item::findAllTitleZhWithPage($page, $perpage),
                'current_page' => $page,
                'total_page' => $total_page,
                'total' => $total,
                'pager' => $html->render('site/components/pagination', array('total' => $total_page, 'page' => $page)),
                'perpage' => $perpage
            ))
        )
    )),
));
$html->renderOut('site/block/footer');
$html->renderOut('site/html_footer');