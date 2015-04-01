<?php

if (!module_enabled('queue')) {
  die('Please enable queue module');
}

$messages = array();
$queued_num = 0;
foreach (CwUrlList::findAll() as $url) {
  try {
    $brand_id = $url->getBrandId();

    // how many product list pages do we need to crawl?
    $html = file_get_contents('http://www.chemistwarehouse.com.au/' . $url->getUrl() . '&perPage=120');
    if (!$html) {
      throw new Exception('Failed to read url: ' . $url->getUrl());
    }
    
    $matches = array();
    $total;
    preg_match('/(\d+)\s*Results/', $html, $matches);
    if (isset($matches[1])) {
      $total = $matches[1];
    } else {
      throw new Exception('Can not get total record # on page: ' . $url->getUrl());
    }
    $page_num = ceil($total / 120);
    
    // ok, we now crawl those product pages
    for ($i = 0; $i < $page_num; $i++) {
      
      
      Queue::addToQueque('CW product list', 'CW crawl product list page', 'cw_crawl_product', array(
          'url' => 'http://www.chemistwarehouse.com.au/' . $url->getUrl() . '&perPage=120&page=' . ($i+1),
          'tags' => $url->getTags(),
          'brand' => empty($brand_id) ? null : $brand_id,
      ), Queue::PRIORITY_HIGH);
      $queued_num++;
    }
  } catch(Exception $e) {
    $messages[] = new Message(Message::INFO, $e->getMessage());
  }
}

if (sizeof($messages)) {
  Message::register($messages);
} else {
  Message::register(new Message(Message::SUCCESS, "$queued_num product list pages queued."));
}
HTML::forwardBackToReferer();