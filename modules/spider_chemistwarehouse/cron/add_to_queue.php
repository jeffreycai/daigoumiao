<?php
require_once __DIR__ . '/../../../bootstrap.php';

// check cron_key
$settings = Vars::getSettings();
if (isset($_GET['cron_key']) && $settings['queue']['cron_key'] == $_GET['cron_key']) {
  dispatch('spider_chemistwarehouse/backend/product_queue');
  echo "Done";
}