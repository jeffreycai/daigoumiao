<?php
require_once "BaseItem.class.php";

class Item extends BaseItem {
  static function findByOriginalId($oid, $instance = 'Item') {
    global $mysqli;
    $query = 'SELECT * FROM item WHERE original_id=' . $oid;
    $result = $mysqli->query($query);
    if ($result && $b = $result->fetch_object()) {
      $obj = new $instance();
      DBObject::importQueryResultToDbObject($b, $obj);
      return $obj;
    }
    return null;
  }
}
