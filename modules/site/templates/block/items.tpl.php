<?php 
$start_entry = ($current_page - 1)*$perpage + 1;
$end_entry = min(array($total, $current_page*$perpage));
?>

<div class="block" id="block-items">
  
  <?php if ($pager): ?>
  <div class="row">
    <div class="col-sm-12" style="text-align: center;">
    <?php echo $pager; ?>
    </div>
  </div>
  <?php endif; ?>
  
  <div class="row">
    <?php if (isset($title)): ?>
    <div class="col-xs-12">
    <h2><?php echo $title ?></h2>
    </div>
    <?php endif; ?>
    
<?php if (empty($items)): ?>
    <div class="col-xs-12">
    <p>没有找到任何商品</p>
    </div>
<?php endif; ?>
    
<?php foreach($items as $item): ?>
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
      <div class="card">
        <div class="thumb">
          <img src="<?php echo $item->getOriginalImage() ?>" alt="<?php echo $item->getTitleZh() ?>" />
          <?php if (($brand = $item->getBrand()) && $brand->getId() != 1): ?>
          <div class="label label-light vendor"><?php echo $brand ?></div>
          <?php endif; ?>
        </div>
        <h3><?php echo $item->getTitleZh() ?></h3>
        <p class="price">$<?php echo $item->getPrice() ?> (约 ￥<?php echo round($item->getPrice() * 5, 2) ?>)</p>
        <div class="info">
          <h4>商品英文名称</h4>
          <div class="title-en">
          <?php echo $item->getTitleEn() ?>
          </div>
          <h4>商家</h4>
          Chemist Warehouse
        </div>
        <div class="actions">
          <a href="<?php echo uri('goto/' . $item->getId() . '?name=' . urlencode($item->getTitleEn()), false) ?>" target="_blank" class="btn btn-sm btn-danger">官网链接</a>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
<?php endforeach; ?>
  </div>
  
  <?php if ($pager): ?>
  <div class="row">
    <div class="col-sm-12" style="text-align: center;">
    <?php echo $pager; ?>
    </div>
  </div>
  <?php endif; ?>
  
</div>

