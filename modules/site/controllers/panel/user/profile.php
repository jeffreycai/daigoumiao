<?php

require_login();

$html = new HTML();
$html->renderOut('site/panel/html_header', array('title' => '更改个人信息'));
$html->renderOut('site/panel/nav-left');

$html->output('<div class="gray-bg dashbard-1" id="page-wrapper">');
$html->renderOut('site/panel/nav-top');
$html->renderOut('site/panel/page-header', array(
    'title' => '更改个人信息',
    'breadcrumb' => array(
        '控制面板' => uri('panel'),
        '账号管理' => array(
            '更改个人信息' => uri('panel/user/profile')
        ),
        '更改个人信息' => null,
    )
));
$html->output('</div>');

$html->renderOut('site/panel/html_footer');