<?php

HTML::registerHeaderUpper('<link rel="stylesheet" href="'.uri('libraries/flexslider/flexslider.css', false).'" type="text/css" media="screen" />');
HTML::registerFooterLower('<script type="text/javascript" src="'.uri('libraries/flexslider/jquery.flexslider-min.js', false).'"></script>');
HTML::registerFooterLower('
  <script type="text/javascript">
    // Can also be used with $(document).ready()
    $(window).load(function() {
      $(\'.flexslider\').flexslider({
        animation: "slide"
      });
    });
  </script>
');


$html = new HTML();

$html->renderOut('site/html_header', array(
    'title' => '首页 :: ' . $settings['sitename'],
    'body_class' => 'home'
));
$html->renderOut('site/block/topnav');
$html->renderOut('site/block/header');
$html->renderOut('site/layout/singlesidebarright', array(
    'main_region' => $html->render('site/layout/region/main', array(
        'blocks' => array(
            'homepage_slideshow' => $html->render('site/block/homepage_slideshow'),
            'items' => $html->render('site/block/items')
        )
    )),
    'sidebar_region' => $html->render('site/layout/region/sidebar')
));
//$html->renderOut('site/block/footer');
$html->renderOut('site/html_footer');