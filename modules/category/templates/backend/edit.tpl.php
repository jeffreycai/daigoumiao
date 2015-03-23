<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header"><?php i18n_echo(array(
          'en' => 'Category', 
          'zh' => '分类'
      )); ?></h1>
    </div>
  </div>
  
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading"><?php i18n_echo(array(
            'en' => 'Edit category - ' . $cat->getName(get_language()), 
            'zh' => '编辑分类 - ' . $cat->getName(get_language())
        )) ?></div>
        <div class="panel-body">
          
        <?php echo Message::renderMessages(); ?>
          
<form role="form" method="POST" action="<?php print_uri('admin/category/edit/'.$cat->getId()) ?>">
  
  <?php if ($settings['i18n']): ?>
    <?php foreach (array_keys($settings['i18n_lang']) as $lang): $name = array(
        'en' => 'Name', 
        'zh' => '名称'
    );?>
      <div class="form-group">
        <label for="name"><?php echo $name[$lang]; ?></label>
        <input value="<?php echo $cat->getName($lang); ?>" type="text" class="form-control" id="title" name="name" required="required" placeholder="<?php i18n_echo(array(
            'en' => 'Category name', 
            'zh' => '分类名称'
        )) ?>">
      </div>
    <?php endforeach; ?>
  <?php else: ?>
      <div class="form-group">
        <input value="<?php echo $cat->getName(get_language()); ?>" type="text" class="form-control" id="title" name="name" required="required" placeholder="<?php i18n_echo(array(
            'en' => 'Category name', 
            'zh' => '分类名称'
        )) ?>">
      </div>
  <?php endif; ?>
  

  <input type="submit" name="submit" value="<?php i18n_echo(array(
      'en' => 'Edit', 
      'zh' => '编辑'
  )) ?>" class="btn btn-default">
</form>
          
        </div>
      </div>
    </div>
  </div>
</div>

