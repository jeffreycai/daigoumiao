<?php
require_once "BaseSubProduct.class.php";

class SubProduct extends BaseSubProduct {
  static function findAllByProductId($pid) {
    global $mysqli;
    $query = 'SELECT * FROM sub_product WHERE product_id=' . $pid;
    $result = $mysqli->query($query);
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $obj = new SubProduct();
      DBObject::importQueryResultToDbObject($b, $obj);
      $rtn[] = $obj;
    }
    return $rtn;
  }
}
