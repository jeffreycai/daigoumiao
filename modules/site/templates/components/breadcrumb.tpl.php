<div class="block" id="block-breadcrumb">
  <div class="col-xs-12">
    <ol class="breadcrumb">
<?php foreach ($items as $name => $uri): ?>
      <li>
        <?php if ($uri): ?> 
        <a href="<?php echo $uri ?>"><?php echo $name ?></a>
        <?php else: ?>
        <?php echo $name ?>
        <?php endif; ?>
      </li>
<?php endforeach; ?>
    </ol>
  </div>
</div>