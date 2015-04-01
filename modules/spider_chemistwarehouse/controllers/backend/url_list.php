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
    
    // save tags
    $tags = array();
    foreach (Tag::findAll() as $c) {
      $tags[$c->getName()] = $c->getId();
    }
    $ts = trim($_POST['tags'][$idx], ', ');
    if (!empty($ts)) {
      $ts = explode(',', $ts);
      $rtn = array();
      foreach ($ts as $t) {
        $t = trim($t);
        if (array_key_exists($t, $tags)) {
          $cid = $tags[$t];
        } else {
        // create a new tag if not found
          $new_obj = new Tag();
          $new_obj->setName($t);
          $new_obj->save();
          $cid = $new_obj->getId();
        }
        
        $rtn[] = $cid;
      }
      if (!empty($rtn)) {
        $list->setTags(implode(',', $rtn));
      }
    }
    
    // save brand
    $brand = trim($_POST['brand'][$idx], ', ');
    if (!empty($brand)) {
      $b = Brand::findByName($brand);
      // create new brand if does not exist
      if (is_null($b)) {
        $b = new Brand();
        $b->setName($brand);
        $b->save();
      }
      $list->setBrandId($b->getId());
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
$brands = array();
foreach (CwUrlList::findAll() as $url) {
  // prepare tags
  $tags = $url->getTags();
  $ts = array();
  if (!empty($tags)) {
    $tkens = explode(',', $tags);
    foreach ($tkens as $token) {
      $ts[] = Tag::findById(trim($token))->getName();
    }
  }
  $urls_straight[$url->getUrl()] = implode(', ', $ts);
  
  // prepare brand
  $brand = Brand::findById($url->getBrandId());
  if (!is_null($brand)) {
    $brands[$url->getUrl()] = $brand->getName();
  }
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
$tags = Tag::findAll();
$ts = array();
foreach ($tags as $c) {
  $ts[] = '"' . $c->getName() . "\"";
}
$bs = array();
$brds = Brand::findAll();
foreach ($brds as $b) {
  $bs[] = '"' . $b->getName() . "\"";
}
HTML::registerHeaderLower('
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
$(function() {
var availableTags = [
'.implode(",",$ts).'
];
var availableBrands = [
'.implode(",",$bs).'
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




// presentation
$html = new HTML();

$html->renderOut('core/backend/html_header', array('title' => 'Chemist Warehouse base urls'));
$html->output('<div id="wrapper">');

$html->renderOut('core/backend/header');
$html->renderOut('spider_chemistwarehouse/backend/url_list', array(
    'urls' => $urls,
    'urls_straight' => $urls_straight,
    'brands' => $brands
));

$html->output('</div>');

$html->renderOut('core/backend/html_footer');

exit;

