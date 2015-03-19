<?php
require_login();

$html = new HTML();
$html->renderOut('site/panel/html_header', array('title' => '控制面板'));
$html->renderOut('site/panel/nav-left');

$html->output('<div class="gray-bg dashbard-1" id="page-wrapper">');
$html->renderOut('site/panel/nav-top');
$html->renderOut('site/panel/page-header', array(
    'title' => '控制面板',
    'breadcrumb' => array(
        '控制面板' => null,
    )
));

$html->output('</div>');

$html->renderOut('site/panel/html_footer');