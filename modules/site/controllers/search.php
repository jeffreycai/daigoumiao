<?php
// get vars from $_GET
$keywords = isset($_GET['keywords']) ? strip_tags(trim($_GET['keywords'])) : "";
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$per_page = 32;

// build query
$tokens = explode(" ", $keywords);
$where = array();
foreach ($tokens as $token) {
  $token = trim($token);
  $where[] = "title_zh LIKE '%" . mysql_escape_string($token) . "%'";
}
$where[] = "title_zh IS NOT NULL AND title_zh != ''";
$where = "(" . implode(" OR ", $where) . ")";
$where = " WHERE $where ";

global $mysqli;
$query = "SELECT * FROM item" . $where . " LIMIT " . ($page - 1) * $per_page . ", " . $per_page;
$query_count = "SELECT COUNT(*) as count FROM item" . $where;

// execute query_count and get total
$result = $mysqli->query($query_count);
$total = $result->fetch_object()->count;
$total_page = ceil($total / $per_page);
// execute query and get $items
$result = $mysqli->query($query);
$items = array();
if ($result) {
  while ($record = $result->fetch_object()) {
    $item = new Item();
    DBObject::importQueryResultToDbObject($record, $item);
    $items[] = $item;
  }
}


// presentation

$html = new HTML();

$html->renderOut('site/html_header', array(
    'title' => '商品搜索结果 - ' . $keywords . ' :: ' . $settings['sitename'],
    'body_class' => 'search'
));
$html->renderOut('site/block/topnav');
//$html->renderOut('site/block/hero_home');
$html->renderOut('site/block/header', array(
    'title' => '搜索结果'
));
$html->renderOut('site/layout/fullpage', array(
    'main_region' => $html->render('site/layout/region/blocks', array(
        'blocks' => array(
            'search_box' => $html->render('site/block/search_box'),
            'items' => $html->render('site/block/items', array(
                'items' => $items,
                'current_page' => $page,
                'total_page' => $total_page,
                'total' => $total,
                'pager' => $html->render('site/components/pagination', array('total' => $total_page, 'page' => $page)),
                'perpage' => $per_page,
//                'title' => '标签 - ' . $tag->getName() 
            )),
            'taxonomy_nav' => $html->render('site/block/taxonomy_nav'),
        )
    )),
));
$html->renderOut('site/block/footer');
$html->renderOut('site/html_footer');