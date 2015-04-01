<?php
include_once __DIR__ . DS . 'BaseVendor.class.php';

/**
 * DB fields for table vendor
 * - id
 * - name
 */
class Vendor extends BaseVendor {
  static function findByName($name, $instance = 'Vendor') {
    global $mysqli;
    $query = 'SELECT * FROM vendor WHERE name=' . DBObject::prepare_val_for_sql($name);
    $result = $mysqli->query($query);
    if ($result && $b = $result->fetch_object()) {
      $obj = new $instance();
      DBObject::importQueryResultToDbObject($b, $obj);
      return $obj;
    }
    return null;
  }
}