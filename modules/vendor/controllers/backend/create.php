<?php
$cat = new Vendor();
  

// handle form submission
if (isset($_POST['submit'])) {
  $name = strip_vendors(trim($_POST['name']));

  // validation
  if (empty($name)) {
    $message = new Message(Message::DANGER, i18n(array(
        'en' => 'Please enter name', 
        'zh' => '请填写名称'
    )));
    Message::register($message);
    HTML::forwardBackToReferer();
  }

  
  // create vendor
  $cat->setName($name);
  if ($cat->save()) {
    $message = new Message(Message::SUCCESS, i18n(array(
        'en' => 'Vendor saved successfully!  <small><a href="'.uri('admin/vendor/list').'">Go back to list</a></small>', 
        'zh' => '商家保存成功!  <small><a href="'.uri('admin/vendor/list').'">回到商家列表</a></small>'
    )));
    Message::register($message);
    HTML::forwardBackToReferer();
  } else {
    $message = new Message(Message::DANGER, i18n(array(
        'en' => 'Vendor saved failed :(', 
        'zh' => '商家保存失败 :('
    )));
    Message::register($message);
  }
}



$html = new HTML();

$html->renderOut('core/backend/html_header', array(
  'title' => i18n(array(
      'en' => 'Create vendor - ' . $cat->getName(get_language()), 
      'zh' => '创建商家 - ' . $cat->getName(get_language())
  )),
), true);
$html->output('<div id="wrapper">');
$html->renderOut('core/backend/header');


$html->renderOut('vendor/backend/create', array(), true);


$html->output('</div>');

$html->renderOut('core/backend/html_footer');

exit;

