<?php
$page = isset($_GET['page']) ? $_GET['page'] : 1;
if (!preg_match('/^\d+$/', $page)) {
  dispatch('core/backend/404');
  exit;
}


$ts = Tag::findAll();
$tags = array();
foreach ($ts as $tag) {
  $tags[] = '"' . $tag . '"';
}
$bs = Brand::findAll();
$brands = array();
foreach ($bs as $brand) {
  $brands[] = '"' . $brand . '"';
}

HTML::registerHeaderLower('
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
$(function() {
var availableTags = [
'.implode(",",$tags).'
];
var availableBrands = [
'.implode(",",$brands).'
];
function split( val ) {
return val.split( /,\s*/ );
}
function extractLast( term ) {
return split( term ).pop();
}
$( ".tags" )
// don\'t navigate away from the field on tab when selecting an item
    .bind("keydown", function(event) {
      if (event.keyCode === $.ui.keyCode.TAB &&
              $(this).autocomplete("instance").menu.active) {
        event.preventDefault();
      }
    })
            .autocomplete({
      minLength: 0,
      source: function(request, response) {
        // delegate back to autocomplete, but extract the last term
        response($.ui.autocomplete.filter(
                availableTags, extractLast(request.term)));
      },
      focus: function() {
        // prevent value inserted on focus
        return false;
      },
      select: function(event, ui) {
        var terms = split(this.value);
        // remove the current input
        terms.pop();
        // add the selected item
        terms.push(ui.item.value);
        // add placeholder to get the comma-and-space at the end
        terms.push("");
        this.value = terms.join(", ");
        return false;
      }
    });
    
$( ".brand" )
// don\'t navigate away from the field on tab when selecting an item
    .bind("keydown", function(event) {
      if (event.keyCode === $.ui.keyCode.TAB &&
              $(this).autocomplete("instance").menu.active) {
        event.preventDefault();
      }
    })
            .autocomplete({
      minLength: 0,
      source: function(request, response) {
        // delegate back to autocomplete, but extract the last term
        response($.ui.autocomplete.filter(
                availableBrands, extractLast(request.term)));
      },
      focus: function() {
        // prevent value inserted on focus
        return false;
      },
      select: function(event, ui) {
        var terms = split(this.value);
        // remove the current input
        terms.pop();
        // add the selected item
        terms.push(ui.item.value);
        // add placeholder to get the comma-and-space at the end
        terms.push("");
        this.value = terms.join(", ");
        return false;
      }
    });


  });
</script>
');






$html = new HTML();

$html->renderOut('core/backend/html_header', array(
  'title' => i18n(array('en' => 'Item list', 'zh' => '产品列表')),
), true);
$html->output('<div id="wrapper">');
$html->renderOut('core/backend/header');



$total = 0;
$items = array();
$per_page = 60;
$where = array();
if (isset($_GET['title_zh_missing']) && $_GET['title_zh_missing']) {
  $where[] = "(title_zh IS NULL OR title_zh = '')";
}
if (isset($_GET['keyword']) && $_GET['keyword'] != "") {
  $keyword = strip_tags($_GET['keyword']);
  $tokens = explode(' ', $keyword);
  $w = array();
  foreach ($tokens as $token) {
    $token = trim($token);
    if ($token != '') {
      $w[] = "title_zh LIKE '%".mysql_escape_string($token)."%'";
      $w[] = "title_en LIKE '%".mysql_escape_string($token)."%'";
    }
  }
  $where[] = "(".implode(' OR ', $w).")";
}
if (!empty($where)) {
  $where = " WHERE " . implode(' AND ', $where) . " ";
} else {
  $where = "";
}
global $mysqli;
$query_count = "SELECT COUNT(*) as 'count' FROM item $where";
$query = "SELECT * FROM item $where ORDER BY updated_at ASC LIMIT " . ($page - 1) * $per_page . ", " . $per_page;
if ($result = $mysqli->query($query_count)) {
  $total = $result->fetch_object()->count;
}
if ($result = $mysqli->query($query)) {
  while ($record = $result->fetch_object()) {
    $item = new Item();
    DBObject::importQueryResultToDbObject($record, $item);
    $items[] = $item;
  }
}

$total_page = ceil($total / $per_page);
$html->renderOut('site/backend/item_list', array(
    'items' => $items,
    'current_page' => $page,
    'per_page' => $per_page,
    'total_page' => $total_page,
    'total' => $total,
    'pager' => $html->render('core/components/pagination', array('total' => $total_page, 'page' => $page))
), true);


$html->output('</div>');

$html->renderOut('core/backend/html_footer');

exit;

