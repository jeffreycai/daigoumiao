<?php

define('STATIC_CACHE_DIR', FILE_DIR . DS . 'static_cache');
if (!is_dir(STATIC_CACHE_DIR)) {
  mkdir(STATIC_CACHE_DIR);
}
if (!is_writable(STATIC_CACHE_DIR)) {
  die('Please set static_cache module cache folder to writable.');
}

global $static_cache_enabled;
$static_cache_enabled = false;

// only enable this module when it's prod
if (ENV == 'prod' && !is_cli()) {
  $url = get_request_uri(false);
  $filename = make_cache_filename($url);
  
  // if it is cached, return the cached version
  $file = STATIC_CACHE_DIR . DS . $filename;

  if ($file = shell_exec('find ' . $file . '*')) {
    $file = trim($file);
    
    $tokens = explode('_', basename($file));
    $expire = $tokens[1];

    if (time() > $expire) {
      unlink($file);
      $static_cache_enabled = true;
      ob_start();
    } else {
      echo file_get_contents($file);
      exit;
    }

  // if not cached, start buffering to create the cache file
  } else {
    $static_cache_enabled = true;
    ob_start();
  }
}

