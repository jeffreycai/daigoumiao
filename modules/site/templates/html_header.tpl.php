<!DOCTYPE html>
<!--[if IEMobile 7]><html class="iem7"  lang="<?php echo get_language(); ?>" dir="ltr"><![endif]-->
<!--[if lte IE 6]><html class="lt-ie9 lt-ie8 lt-ie7"  lang="<?php echo get_language(); ?>" dir="ltr"><![endif]-->
<!--[if (IE 7)&(!IEMobile)]><html class="lt-ie9 lt-ie8"  lang="<?php echo get_language(); ?>" dir="ltr"><![endif]-->
<!--[if IE 8]><html class="lt-ie9"  lang="<?php echo get_language(); ?>" dir="ltr"><![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)]><!--><html lang="<?php echo get_language(); ?>" dir="ltr"><!--<![endif]-->

<head profile="http://www.w3.org/1999/xhtml/vocab">
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
<link rel="shortcut icon" href="<?php echo uri("favicon", false) ?>/favicon.ico?v=2" />
<link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo uri("favicon", false) ?>/apple-touch-icon-57x57.png" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo uri("favicon", false) ?>/apple-touch-icon-114x114.png" />
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo uri("favicon", false) ?>/apple-touch-icon-72x72.png" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo uri("favicon", false) ?>/apple-touch-icon-144x144.png" />
<link rel="apple-touch-icon-precomposed" sizes="60x60" href="<?php echo uri("favicon", false) ?>/apple-touch-icon-60x60.png" />
<link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo uri("favicon", false) ?>/apple-touch-icon-120x120.png" />
<link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?php echo uri("favicon", false) ?>/apple-touch-icon-76x76.png" />
<link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo uri("favicon", false) ?>/apple-touch-icon-152x152.png" />
<link rel="icon" type="image/png" href="<?php echo uri("favicon", false) ?>/favicon-196x196.png" sizes="196x196" />
<link rel="icon" type="image/png" href="<?php echo uri("favicon", false) ?>/favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/png" href="<?php echo uri("favicon", false) ?>/favicon-64x64.png" sizes="64x64" />
<link rel="icon" type="image/png" href="<?php echo uri("favicon", false) ?>/favicon-48x48.png" sizes="48x48" />
<link rel="icon" type="image/png" href="<?php echo uri("favicon", false) ?>/favicon-32x32.png" sizes="32x32" />
<link rel="icon" type="image/png" href="<?php echo uri("favicon", false) ?>/favicon-24x24.png" sizes="24x24" />
<link rel="icon" type="image/png" href="<?php echo uri("favicon", false) ?>/favicon-16x16.png" sizes="16x16" />
<link rel="icon" type="image/png" href="<?php echo uri("favicon", false) ?>/favicon-128x128.png" sizes="128x128" />
<meta name="msapplication-square70x70logo" content="<?php echo uri("favicon", false) ?>/mstile-70x70.png" />
<meta name="msapplication-square150x150logo" content="<?php echo uri("favicon", false) ?>/mstile-150x150.png" />
<meta name="msapplication-wide310x150logo" content="<?php echo uri("favicon", false) ?>/mstile-310x150.png" />
<meta name="msapplication-square310x310logo" content="<?php echo uri("favicon", false) ?>/mstile-310x310.png" />
<meta name="application-name" content="澳洲实价网"/>
<meta name="msapplication-TileColor" content="#ffffff"/>
  
  <link rel="shortcut icon" href="/favicon.ico" type="image/vnd.microsoft.icon" />
  
  <title><?php echo $title; ?></title>

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
  var site = jQuery();
  site.settings = <?php echo HTML::renderSettingsInJson() ?>;
  site.settings.subroot = '<?php echo get_sub_root(); ?>';
</script>
<?php HTML::renderOutHeaderUpperRegistry(); ?>  
<?php Asset::printTopAssets('frontend'); ?>
<?php HTML::renderOutHeaderLowerRegistry(); ?>
  
</head>

<body class="<?php if (isset($body_class)) {echo $body_class; }?>">
  
<?php if (is_frontend()): ?>
<!-- ga -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-61450072-1', 'auto');
  ga('send', 'pageview');

</script>
<?php endif; ?>