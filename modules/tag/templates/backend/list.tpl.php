<?php 
$start_entry = ($current_page - 1)*20 + 1;
$end_entry = min(array($total, $current_page*20));
?>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header"><?php i18n_echo(array('en' => 'Tag', 'zh' => '标签')); ?></h1>
    </div>
  </div>
  
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading"><?php i18n_echo(array('en' => 'Tag list', 'zh' => '标签列表')) ?></div>
        <div class="panel-body">
          
        <?php echo Message::renderMessages(); ?>
          
<table class="table table-striped table-bordered table-hover dataTable no-footer">
  <thead>
      <tr role="row">
        <th>ID</th>
        <th><?php i18n_echo(array('en' => 'Name', 'zh' => '名称')) ?></th>
        <th><?php i18n_echo(array('en' => 'Actions', 'zh' => '操作')) ?></th>
      </tr>
  </thead>
  <tbody>
    <?php foreach ($cats as $cat): ?>
    <tr>
      <td><?php echo $cat->getId(); ?></td>
      <td><?php echo $cat->getName(); ?></td>
      <td>
        <a href="<?php print_uri('admin/tag/edit/' . $cat->getId()); ?>"><?php i18n_echo(array('en' => 'Edit', 'zh' => '编辑')) ?></a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<div class="row">
  <div class="col-sm-12" style="text-align: right;">
  <?php i18n_echo(array(
      'en' => 'Showing ' . $start_entry . ' to ' . $end_entry . ' of ' . $total . ' entries', 
      'zh' => '显示' . $start_entry . '到' . $end_entry . '条记录，共' . $total . '条记录',
  )); ?>
  </div>
  <div class="col-sm-12" style="text-align: right;">
  <?php echo $pager; ?>
  </div>
</div>
          
        </div>
      </div>
    </div>
  </div>
</div>