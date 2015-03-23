<div id="page-wrapper">
  <div class="row">
    <div class="col-xs-12">
      <h1 class="page-header">Chemist warehouse</h1>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <div class="panel panel-default">
        <div class="panel-heading">Base urls</div>
        <div class="panel-body">
          
          <div class="form-group pull-right">
            <a href="<?php echo uri('admin/cw/product/queue', false) ?>" class="btn btn-primary">Queue for products crawl</a>
          </div>
          <div class="clearfix"></div>
          
        <?php echo Message::renderMessages(); ?>
           
          
          <?php $i = 0; ?>
          <form id="cw-base-list" action="" method="post">
            <table class="table table-hover">
<?php foreach ($urls as $url): ?>
                <tr style="position: relative;">
                  <td>
                    <span><a href="http://www.chemistwarehouse.com.au/<?php echo $url->href ?>"><?php echo $url->name ?></a> (<?php echo $url->itemNum ?>)</span>
                    <input style="position: absolute; top: 5px; right: 10px;" type="checkbox" name="urls[<?php echo $i ?>]" value="<?php echo $url->href ?>" <?php echo array_key_exists($url->href, $urls_straight) ? 'checked="checked"' : '' ?> />                    
                    <div style="position: absolute; top: 5px; right: 35px;">
                      <input type="text" class="cats" name="categories[<?php echo $i++; ?>]" placeholder="categories" value="<?php echo array_key_exists($url->href, $urls_straight) ? $urls_straight[$url->href] : '' ?>" />
                    </div>
                  </td>
                </tr>
                
                
                <?php foreach ($url->children as $child): ?>
                <tr class="child" style="position: relative;">
                  <td style="padding-left: 40px;">
                    <span><a href="http://www.chemistwarehouse.com.au/<?php echo $child->href ?>"><?php echo $child->name ?></a> (<?php echo $child->itemNum ?>)</span>
                    <input style="position: absolute; top: 5px; right: 10px;" type="checkbox" name="urls[<?php echo $i ?>]" value="<?php echo $child->href ?>" <?php echo array_key_exists($child->href, $urls_straight) ? 'checked="checked"' : '' ?> />
                    <div style="position: absolute; top: 5px; right: 35px;">
                      <input type="text" class="cats" name="categories[<?php echo $i++; ?>]" placeholder="categories" value="<?php echo array_key_exists($child->href, $urls_straight) ? $urls_straight[$child->href] : '' ?>" />
                    </div>
                  </td>
                </tr>
                <?php endforeach; ?>
                
<?php endforeach; ?>
            </table>
            <div class="form-group">
              <input class="btn btn-primary" type="submit" name="submit" value="Submit" />
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $('#cw-base-list input').click(function(e){
    e.stopPropagation();
  });
  
  $('#cw-base-list td').click(function(){
    var tr = $(this).parent();
    var checkbox = $('input', this);
    
    var checked_tobe = checkbox.prop("checked") ? false : true;
    
    if (checked_tobe) {
      if (!checkbox.prop("disabled")) {
        checkbox.prop("checked", true);
      }
      var next_tr = tr.next('tr');
      while (!tr.hasClass('child') && next_tr.length > 0 && next_tr.hasClass('child')) {
        $('input', next_tr).prop("checked", false).prop("disabled", true);
        next_tr = next_tr.next('tr');
      }
    } else {
      checkbox.prop("checked", false);
      var next_tr = tr.next('tr');
      while (!tr.hasClass('child') && next_tr.length > 0 && next_tr.hasClass('child')) {
        $('input', next_tr).prop("checked", false).prop("disabled", false);
        next_tr = next_tr.next('tr');
      }
    }
  });
</script>