<?php
$id = $vars[1];
$cat = Brand::findById($id);
  
if (!$cat) {
  dispatch('core/backend/404');
  exit;
}

// handle form submission
if (isset($_POST['submit'])) {
  $name = strip_brands(trim($_POST['name']));

  // validation
  if (empty($name)) {
    $message = new Message(Message::DANGER, i18n(array(
        'en' => 'Please enter name', 
        'zh' => '请填写名称'
    )));
    Message::register($message);
    HTML::forwardBackToReferer();
  }

  
  // edit brand
  $cat->setName($name);
  if ($cat->save()) {
    $message = new Message(Message::SUCCESS, i18n(array(
        'en' => 'Brand saved successfully!  <small><a href="'.uri('admin/brand/list').'">Go back to list</a></small>', 
        'zh' => '品牌保存成功!  <small><a href="'.uri('admin/brand/list').'">回到品牌列表</a></small>'
    )));
    Message::register($message);
    HTML::forwardBackToReferer();
  } else {
    $message = new Message(Message::DANGER, i18n(array(
        'en' => 'Brand saved failed :(', 
        'zh' => '品牌保存失败 :('
    )));
    Message::register($message);
  }
}



$html = new HTML();

$html->renderOut('core/backend/html_header', array(
  'title' => i18n(array(
      'en' => 'Edit brand - ' . $cat->getName(get_language()), 
      'zh' => '修改品牌 - ' . $cat->getName(get_language())
  )),
), true);
$html->output('<div id="wrapper">');
$html->renderOut('core/backend/header');


$html->renderOut('brand/backend/edit', array('cat' => $cat), true);


$html->output('</div>');

$html->renderOut('core/backend/html_footer');

exit;

