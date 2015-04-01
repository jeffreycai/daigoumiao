<?php 
$items = Item::findAllWithPage(1, 4);
?>

<div class="block" id="user-info">
  <h2>热门母婴类产品</h2>
  <div class="row">
<?php foreach ($items as $item): ?>
    <div class="col-xs-6">
      <img src="<?php echo $item->getThumbnail() ?>" class="img-responsive" alt="<?php echo $item->getTitleEn() ?>" />
    </div>
<?php endforeach; ?>
  </div>
</div>