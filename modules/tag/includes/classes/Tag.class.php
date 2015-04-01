<?php
include_once __DIR__ . DS . 'BaseTag.class.php';

/**
 * DB fields for table tag
 * - id
 * - name
 */
class Tag extends BaseTag {
  static function findByName($name, $instance = 'Tag') {
    global $mysqli;
    $query = 'SELECT * FROM tag WHERE name=' . DBObject::prepare_val_for_sql($name);
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