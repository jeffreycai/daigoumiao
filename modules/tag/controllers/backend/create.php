<?php
$cat = new Tag();
  

// handle form submission
if (isset($_POST['submit'])) {
  $name = strip_tags(trim($_POST['name']));

  // validation
  if (empty($name)) {
    $message = new Message(Message::DANGER, i18n(array(
        'en' => 'Please enter name', 
        'zh' => '请填写名称'
    )));
    Message::register($message);
    HTML::forwardBackToReferer();
  }

  
  // create tag
  $cat->setName($name);
  if ($cat->save()) {
    $message = new Message(Message::SUCCESS, i18n(array(
        'en' => 'Tag saved successfully!  <small><a href="'.uri('admin/tag/list').'">Go back to list</a></small>', 
        'zh' => '标签保存成功!  <small><a href="'.uri('admin/tag/list').'">回到标签列表</a></small>'
    )));
    Message::register($message);
    HTML::forwardBackToReferer();
  } else {
    $message = new Message(Message::DANGER, i18n(array(
        'en' => 'Tag saved failed :(', 
        'zh' => '标签保存失败 :('
    )));
    Message::register($message);
  }
}



$html = new HTML();

$html->renderOut('core/backend/html_header', array(
  'title' => i18n(array(
      'en' => 'Create tag - ' . $cat->getName(get_language()), 
      'zh' => '创建标签 - ' . $cat->getName(get_language())
  )),
), true);
$html->output('<div id="wrapper">');
$html->renderOut('core/backend/header');


$html->renderOut('tag/backend/create', array(), true);


$html->output('</div>');

$html->renderOut('core/backend/html_footer');

exit;

