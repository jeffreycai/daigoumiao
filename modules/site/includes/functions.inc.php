<?php
/**
 * Function to extract digits xx.xx from string, eg. $AU xxxx.xx
 * @param type $str
 * @return type
 */
function get_price_from_str($str) {
  $matches = array();
  preg_match('/(\d+\.\d+)/', $str, $matches);
  $price = trim($matches[1], '0');
  return $price;
}