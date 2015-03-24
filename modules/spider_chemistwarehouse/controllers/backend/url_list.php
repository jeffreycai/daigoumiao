<?php

// handle submission
if (isset($_POST['submit'])) {
  // validation
  if (!isset($_POST['urls']) || empty($_POST)) {
    Message::register(new Message(Message::DANGER, 'please check at least one '));
    HTML::forwardBackToReferer();
  }
  
  CwUrlList::truncate();
  foreach($_POST['urls'] as $idx => $url) {
    $list = new CwUrlList();
    $list->setUrl($url);
//    $list->save();
    
    $categories = array();
    foreach (Category::findAll() as $c) {
      $categories[$c->getName()] = $c->getId();
    }
    $cats = trim($_POST['categories'][$idx], ', ');
    if (!empty($cats)) {
      $cats = explode(',', $cats);
      $rtn = array();
      foreach ($cats as $cat) {
        $cat = trim($cat);
        $cid = $categories[$cat];
        $rtn[] = $cid;
      }
      if (!empty($rtn)) {
        $list->setCategories(implode(',', $rtn));
      }
    }
    $list->save();
  }
  Message::register(new Message(Message::SUCCESS, 'Base list updated'));
  HTML::forwardBackToReferer();
}

// crawl the page to get base urls
$crawler = new Crawler();
$html = $crawler->read("http://www.chemistwarehouse.com.au/categories.asp");
$tokens = array();
preg_match_all('/\d+px;"><a href="category\.asp\?id=\d+&cname=[^"]+" >[^<]+<\/a>\&nbsp;\&nbsp;\(\d+\)/', $html, $tokens);
$urls = array();
$urls_straight = array(); 
foreach (CwUrlList::findAll() as $url) {
  $categories = $url->getCategories();
  $cats = array();
  if (!empty($categories)) {
    $ts = explode(',', $categories);
    foreach ($ts as $token) {
      $cats[] = Category::findById(trim($token))->getName();
    }
  }
  $urls_straight[$url->getUrl()] = implode(', ', $cats);
}

$parent_node;
$previous_level = 0;
foreach ($tokens[0] as $token) {
  $url = new stdClass;
  $ts = array();
  preg_match('/(\d+)px;"><a href="(category\.asp\?id=\d+&cname=[^"]+)" >([^<]+)<\/a>\&nbsp;\&nbsp;\((\d+)\)/', $token, $ts);
  $level;
  switch($ts[1]) {
    case "10":
      $level = 0; break;
    case "40":
      $level = 1; break;
    default:
      $level = 2; break;
  }
  $url->level = $level;
  $url->href = $ts[2];
  $url->name = $ts[3];
  $url->itemNum = $ts[4];
  $url->children = array();
  
  // add node
  if ($level == 1) {
    $parent_node->children[] = $url;
  } else if ($level == 0) {
    $urls[] = $url;
  }
  
  // deside who is current node
  if ($level == 0) {
    $parent_node = $url;
  }
  $previous_level = $level;
}

// register jquery ui
$categories = Category::findAll();
$cats = array();
foreach ($categories as $c) {
  $cats[] = '"' . $c->getName() . "\"";
}
HTML::registerHeaderLower('
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
 <script>
$(function() {
var availableTags = [
'.implode(",",$cats).'
];
function split( val ) {
return val.split( /,\s*/ );
}
function extractLast( term ) {
return split( term ).pop();
}
$( ".cats" )
// don\'t navigate away from the field on tab when selecting an item
.bind( "keydown", function( event ) {
if ( event.keyCode === $.ui.keyCode.TAB &&
$( this ).autocomplete( "instance" ).menu.active ) {
event.preventDefault();
}
})
.autocomplete({
minLength: 0,
source: function( request, response ) {
// delegate back to autocomplete, but extract the last term
response( $.ui.autocomplete.filter(
availableTags, extractLast( request.term ) ) );
},
focus: function() {
// prevent value inserted on focus
return false;
},
select: function( event, ui ) {
var terms = split( this.value );
// remove the current input
terms.pop();
// add the selected item
terms.push( ui.item.value );
// add placeholder to get the comma-and-space at the end
terms.push( "" );
this.value = terms.join( ", " );
return false;
}
});
});
</script>
');




// presentation
$html = new HTML();

$html->renderOut('core/backend/html_header', array('title' => 'Chemist Warehouse base urls'));
$html->output('<div id="wrapper">');

$html->renderOut('core/backend/header');
$html->renderOut('spider_chemistwarehouse/backend/url_list', array(
    'urls' => $urls,
    'urls_straight' => $urls_straight
));

$html->output('</div>');

$html->renderOut('core/backend/html_footer');

exit;

