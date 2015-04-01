<div class="block" id="block-search-box">
  <div class="row">
    <div class="col-lg-8 col-lg-push-2 col-sm-8 col-sm-push-2">
    <div class="input-group">
      <form action="<?php echo uri('items/search') ?>" method="GET">
        <input type="text" class="form-control" name="keywords" placeholder="搜索产品" required value="<?php echo isset($_GET['keywords']) ? $_GET['keywords'] : '' ?>" />
        <i class="fa fa-search"></i>
        
        <script type="text/javascript">
          $("#block-search-box i").click(function(){
            $(this).parents('form').submit();
          });
        </script>
        
      </form>
    </div>
    </div>
  </div>
</div>