<?php
require_once __DIR__ . '/../../../bootstrap.php';

// check cron_key
$settings = Vars::getSettings();
if (isset($_GET['cron_key']) && $settings['queue']['cron_key'] == $_GET['cron_key']) {
  $thread_num = 100;

  Queue::killAllDeadThreads(60);
  for ($i = 0; $i < $thread_num; $i++) {
    Queue::fetchAndProceed();
  }
  
  echo "done";
}


