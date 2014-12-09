<?php 
global $include_method; 
if ($include_method !== 'php') {
	 require_once("../../../../wp-load.php");
} ?><div id="slick_tab_widget_area" align="center">
<?php 
 if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Slick Tab Widget Area')) : 
 endif;
?></div>