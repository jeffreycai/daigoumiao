<?php

$html = new HTML();

$html->renderOut('site/html_header', array(
    'title' => '联系我们 :: ' . $settings['sitename'],
    'body_class' => 'contact'
));
$html->renderOut('site/block/topnav');
//$html->renderOut('site/block/hero_home');
$html->renderOut('site/block/header', array(
    'title' => '联系我们'
));
$html->renderOut('site/layout/fullpage', array(
    'main_region' => $html->render('site/layout/region/blocks', array(
        'blocks' => array(
            'contact_form' => $html->render('site/contact')
        )
    )),
));
$html->renderOut('site/block/footer');
$html->renderOut('site/html_footer');

exit;