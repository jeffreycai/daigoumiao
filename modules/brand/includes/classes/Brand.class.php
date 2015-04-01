<?php
include_once __DIR__ . DS . 'BaseBrand.class.php';

/**
 * DB fields for table brand
 * - id
 * - name
 */
class Brand extends BaseBrand {
  static function findByName($name, $instance = 'Brand') {
    global $mysqli;
    $query = 'SELECT * FROM brand WHERE name=' . DBObject::prepare_val_for_sql($name);
    $result = $mysqli->query($query);
    if ($result && $b = $result->fetch_object()) {
      $obj = new $instance();
      DBObject::importQueryResultToDbObject($b, $obj);
      return $obj;
    }
    return null;
  }
  
  public function __toString() {
    return $this->getName();
  }
}