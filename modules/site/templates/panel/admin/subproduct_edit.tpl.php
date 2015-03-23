<div class="row">
  <div class="col-lg-12">
    <div class="wrapper wrapper-content">
      <div class="row">
        
        
        <div class="col-lg-12">
          <div class="ibox float-e-margins">
            <div class="ibox-content">
              
              <?php echo Message::renderMessages(); ?>
              
<form action="" method="POST">
  <table class="table table-bordered" id="edit">
    <thead>
      <tr>
        <th>参数</th>
        <th>价格</th>
        <th>上架?</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
        <?php $i = 0; ?>
        <?php if (sizeof($subproducts)): ?>
          <?php foreach ($subproducts as $subproduct): ?>
          <tr>
            <td><input class="form-control" type="text" name="subproduct[<?php echo $i ?>][attribute]" required="required" value="<?php echo $subproduct->getAttribute() ?>" /></td>
            <td><input class="form-control" type="text" name="subproduct[<?php echo $i ?>][price]" placeholder="使用默认价格" value="<?php echo $subproduct->getPrice() ?>" /></td>
            <td><input class="form-control" type="checkbox" name="subproduct[<?php echo $i ?>][active]" <?php echo $subproduct->getActive() ? 'checked="checked"' : '' ?> value="1" /></td>
            <td><a href="#" class="btn btn-<?php echo ($i!=0) ? 'danger' : 'primary' ?>"><i class="fa fa-<?php echo ($i !=0) ? 'minus' : 'plus' ?>-circle"></i></a></td>
          </tr>
          <?php $i++; endforeach; ?>
        <?php else: ?>
        <tr>
            <td><input class="form-control" type="text" name="subproduct[<?php echo $i ?>][attribute]" required="required" /></td>
            <td><input class="form-control" type="text" name="subproduct[<?php echo $i ?>][price]" placeholder="使用默认价格" /></td>
            <td><input class="form-control" type="checkbox" name="subproduct[<?php echo $i ?>][active]" value="1" /></td>
            <td><a class="btn btn-primary add" href="#"><i class="fa fa-plus-circle"></i></a></td>
        </tr>
        <?php $i++; endif; ?>
    </tbody>
  </table>
  <input class="btn btn-primary" type="submit" name="submit" value="更新" />
</form>
            </div>
          </div>
        </div>
        
        
        
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  var i = <?php echo $i ?>;
  // "add" button action
  $("table .fa-plus-circle").parent().on('click', function(){
    $("#edit").append('<tr><td><input class="form-control" type="text" name="subproduct['+i+'][attribute]" required="required" /></td><td><input class="form-control" type="text" name="subproduct['+i+'][price]" placeholder="使用默认价格" /></td><td><input class="form-control" type="checkbox" checked="checked" name="subproduct['+i+'][active]" value="1" /></td><td><a href="#" class="btn btn-danger remove"><i class="fa fa-minus-circle"></i></a></td></tr>');
    i++;
    return false;
  });
  // "minus" button action
  $(document).on('click', 'table a.remove', function(){
    $(this).parents('tr').first().remove();
    return false;
  });
  $("table .fa-minus-circle").parent().on('click', function(){
    $(this).parents('tr').first().remove();
    return false;
  });
</script>






