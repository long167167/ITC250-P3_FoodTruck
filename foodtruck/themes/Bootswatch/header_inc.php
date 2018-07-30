<?php
//theme specific functions
include 'bootswatch_functions.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--Bootstrap themes use style settings to change look and feel -->
    <link rel="stylesheet" href="<?=THEME_PATH;?>css/<?=$config->style;?>" media="screen">
    <link rel="stylesheet" href="<?=THEME_PATH;?>css/bootswatch.min.css">
	<link rel="stylesheet" href="<?=THEME_PATH;?>css/bootswatch-overrides.css">
    <!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
				<?php
				echo bootswatchFeedback();  //feedback on form operations - see bootswatch_functions.php
			?>
