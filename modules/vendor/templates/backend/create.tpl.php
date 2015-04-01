<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header"><?php i18n_echo(array(
          'en' => 'Vendor', 
          'zh' => '商家'
      )); ?></h1>
    </div>
  </div>
  
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading"><?php i18n_echo(array(
            'en' => 'Create vendor', 
            'zh' => '创建商家'
        )) ?></div>
        <div class="panel-body">
          
        <?php echo Message::renderMessages(); ?>
          
<form role="form" method="POST" action="<?php print_uri('admin/vendor/create') ?>">
  
  <?php if ($settings['i18n']): ?>
    <?php foreach (array_keys($settings['i18n_lang']) as $lang): $name = array(
        'en' => 'Name', 
        'zh' => '名称'
    );?>
      <div class="form-group">
        <label for="name"><?php echo $name[$lang]; ?></label>
        <input value="" type="text" class="form-control" id="title" name="name" required="required" placeholder="<?php i18n_echo(array(
            'en' => 'Vendor name', 
            'zh' => '商家名称'
        )) ?>">
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="form-group">
      <input value="" type="text" class="form-control" id="title" name="name" required="required" placeholder="<?php i18n_echo(array(
          'en' => 'Vendor name', 
          'zh' => '商家名称'
      )) ?>">
    </div>
  <?php endif; ?>
  

  <input type="submit" name="submit" value="<?php i18n_echo(array(
      'en' => 'Create', 
      'zh' => '创建'
  )) ?>" class="btn btn-default">
</form>
          
        </div>
      </div>
    </div>
  </div>
</div>

