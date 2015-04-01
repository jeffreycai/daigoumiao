<?php 
$start_entry = ($current_page - 1)*$per_page + 1;
$end_entry = min(array($total, $current_page*$per_page));
?>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header"><?php i18n_echo(array('en' => 'Items', 'zh' => '产品')); ?></h1>
    </div>
  </div>
  
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading"><?php i18n_echo(array('en' => 'Item list', 'zh' => '产品列表')) ?></div>
        <div class="panel-body">
          <div class="row" style="margin-bottom: 10px;">
            <div class='col-xs-12'>
              <a class='btn btn-default btn-sm' href="<?php echo uri('admin/items/list') ?>">显示所有产品</a>
              <a class="btn btn-default btn-sm <?php echo array_key_exists('title_zh_missing', $_GET) ? 'active' : '' ?>" href="<?php echo update_query_string(array(
                  'title_zh_missing' => 1
              )) ?>">只显示无中文标题</a>
            </div>
          </div>
          <div class="row" style="margin-bottom: 10px;">
            <div class='col-xs-12'>
              <form id="search" class="form-inline" method="GET" action="<?php echo get_cur_page_url() ?>">
                <div class="form-group">
                  <input type="text" class="form-control" name="keyword" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>" />
                </div>
                <?php if (isset($_GET['title_zh_missing'])): ?> 
                  <input type="hidden" name="title_zh_missing" value="<?php echo $_GET['title_zh_missing'] ?>" />
                <?php endif; ?>
                
                <button type="submit" class="btn btn-primary">搜索</button>
              </form>
            </div>
          </div>
          
        <?php echo Message::renderMessages(); ?>
          
<?php foreach ($items as $item): ?>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="thumbnail">
              <div style="position: relative;">
                <div style="position: absolute; bottom: 0px; left: 0px; background-color: #777; color: #EEE; padding: 5px; opacity: 0.5; width:100%;"><?php echo $item->getTitleEn() ?></div>
                <img style="width: 100%;" src="<?php echo $item->getOriginalImage() ?>" />
              </div>
              
              <div class="caption">
                <form action="<?php echo uri('admin/item/' . $item->getId() . '/update', false) ?>" method="POST" class="item-update" id="item-update-<?php echo $item->getId() ?>">
                  <div class="form-group">
                    <input class="form-control" type="text" name="title_zh" value="<?php echo $item->getTitleZh() ?>" placeholder="Title Zh" />
                  </div>    
                  <div class="form-group">
                    <input class="form-control brand" type="text" name="brand" value="<?php $brand = $item->getBrand(); echo $brand ? $brand->getName() : ''  ?>" placeholder="Brand" />
                  </div>
                  <div class="form-group">
                    <input class="form-control tags" type="text" name="tags" value="<?php $tags = $item->getTags(); echo empty($tags) ? '' : implode(', ', $tags) ?>" placeholder="Tags" />
                  </div>
                  <input class="btn btn-default" type="submit" name="submit" value="Update" />
                </form>
              </div>
            </div>
          </div>
<?php endforeach ?>

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

<script type="text/javascript">
  $(".item-update input[type=submit]").click(function(){
    var form = $(this).parents('form').first();
    var fid = form.attr("id");
    $(this).prop("disabled", true).val("Update..");
    $.post(form.attr('action'), form.serialize(), function(data){
      $("#" + fid + " input[type=submit]").prop("disabled", false).val("Update");
      // if success, ie. data is an object
      if (data.constructor === {}.constructor) {
        $("#" + fid + " input[type=submit]").removeClass('btn-default').addClass('btn-success');
        $("#" + fid + " input[name=brand]").val(data.brand);
        $("#" + fid + " input[name=tags]").val(data.tags);
        $("#" + fid + " input[name=title_zh]").val(data.title_zh);
      // if failed
      } else {
        $("#" + fid + " input[type=submit]").removeClass('btn-default').addClass('btn-danger');
      }
    });
    return false;
  });
</script>