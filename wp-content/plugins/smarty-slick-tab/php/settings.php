<?php
// Generate the Slick Tab settings page
if ( !class_exists('Slick_Tab_Settings') ) {	
	class slick_tab_Settings {
		function __construct() {
		}
		function init() {
		}	
		function slick_tab_ouput_string($string) {
		    $string = str_replace('&', '&amp;', $string);
		    $string = str_replace('"', '&quot;', $string);
		    $string = str_replace("'", '&#39;', $string);
		    $string = str_replace('<', '&lt;', $string);
		    $string = str_replace('>', '&gt;', $string);
		    return $string;
		} // end function slick_tab_output_string
		
		/* 
		 * Adds Settings page for Slick Tab.
		 */
		function settings_page( ) {
			global $slick_tab, $wp_roles;
			$msg = null;
			if( array_key_exists( 'updated', $_GET ) && $_GET['updated']=='true' ) { $msg = __('Settings Saved', 'slick_tab'); }
			?>

			
<script type="application/javascript">
jQuery(function(){
		// The General Advanced and Support tabs
		jQuery( "#tabs" ).tabs();
});
</script>

<div class="wrap">
<h2><?php _e('', 'slick_tab') ?></h2>
<?php if($msg) : ?>
	<div class="updated fade" id="message">
		<p><strong><?php echo $msg ?></strong></p>
	</div>
<?php endif; ?>
<form method="post" action="options.php">	
<div id="tabs">
	<ul>
		<li><a href="#general">General</a></li>
		<li><a href="#advanced">Advanced</a></li>
		<li><a href="#support">Support & Donate</a></li>
	</ul>
<div style="width: 200px; right: 0; float: right; position: fixed; margin: 0 15px 20px 0; background: #f3f3f3; border: 1px solid #dfdfdf; padding: 15px; color: #008000; font-size: 11px;">
<h3 style="margin: 0 0 10px 0; border-bottom: 1px dashed #008000;">More Free Plugins:</h3>
<ul>
	<li><a href="http://ataulswebdesigns.com/social-share-buttons-plugin/" target="_blank">My Social Share Buttons</a></li>
	<li><a href="http://ataulswebdesigns.com/seo-permalinks-modifier-plugin/" target="_blank">SEO Permalinks Modifier</a></li>
	<li><a href="http://ataulswebdesigns.com/content-links-modifier-plugin/" target="_blank">Content Links Modifier</a></li>

</ul>
<h3 style="margin: 0 0 10px 0; border-bottom: 1px dashed #008000;">Also Stay Connected:</h3>
<a href="https://plus.google.com/109526129815752833990/">Google+</a> | <a href="http://facebook.com/awd.team">Facebook</a> | <a href="http://www.twitter.com/awdblog">Twitter</a>

</div>	
	<div id="general">
						<?php settings_fields( $slick_tab->options_group ); ?>	
		
						<table class="form-table">
							<tr valign="top">
								<th scope="row"><strong><?php _e('Mode', 'slick-tab') ?></strong></th>
								<td>
									<p>
										<label for="cssonly">
											<?php _e('CSS Only Mode:', 'slick-tab') ?>
										</label>
										
										<input class="cssonly" type="radio" name="<?php  echo $slick_tab->get_plugin_option_fullname('cssonly') ?>" value=1 <?php if($slick_tab->get_plugin_option('cssonly') == 1) echo 'checked="yes"'; ?> /> Yes
										<input class="integratedcss" type="radio" name="<?php  echo $slick_tab->get_plugin_option_fullname('cssonly') ?>" value=0 <?php if($slick_tab->get_plugin_option('cssonly') == 0) echo 'checked="yes"'; ?> /> No
										
										<br />
										<span class="description"><?php _e('You can switch to css only mode and use cssonly.css to set up your Slick Tab.', 'slick-tab') ?></span>
										<br />
										<span class="description"><?php _e('Note: If in CSS only mode, make sure you fill out the remaining settings that you will be using in your css as they are necessary for calculations and such', 'slick-tab') ?></span>
									</p>
								</td>
								</th>
							</tr>
							<tr valign="top">
								<th scope="row"><strong><?php _e('Startup Settings', 'slick-tab') ?></strong></th>
								<td>	 
										<p>
										<label for="slick_tab_position">
										<?php _e('', 'slick-tab') ?>
											<input type="radio" name="<?php  echo $slick_tab->get_plugin_option_fullname('slick_tab_position') ?>" value="left" <?php if($slick_tab->get_plugin_option('slick_tab_position') == 'left') echo 'checked="yes"'; ?> /> Left
											<input type="radio" name="<?php  echo $slick_tab->get_plugin_option_fullname('slick_tab_position') ?>" value="right" <?php if($slick_tab->get_plugin_option('slick_tab_position') == 'right') echo 'checked="yes"'; ?> /> Right
										</label> <br />
										
										
											<label for="show_on_load">
												<input type="checkbox" name="<?php  echo $slick_tab->get_plugin_option_fullname('show_on_load') ?>" id="show_on_load" value="1" <?php checked($slick_tab->get_plugin_option('show_on_load')); ?>/>
												<?php _e('Start in open Slick Tab view', 'slick-tab') ?>
											</label> <br />
											<span class="description"><?php _e('Determines whether the Slick Tab content is initially shown when the page is loaded.', 'slick-tab') ?></span>
										</p>
										
										<div id='timer' class =	
											<?php 
												$timer = $slick_tab->get_plugin_option('show_on_load');
												if ($timer == true) {
													echo "shown";
												} else {
													echo "hidden";
												}
											?>		
											<label for="enable_timer">
												<input type="checkbox" name="<?php  echo $slick_tab->get_plugin_option_fullname('enable_timer') ?>" id="enable_timer" value="1" <?php checked($slick_tab->get_plugin_option('enable_timer')); ?>/>
												<?php _e('Enable Autohide Timer', 'slick-tab') ?>
											</label>		
											<span id='autohide' class=
												<?php 
													$timer = $slick_tab->get_plugin_option('enable_timer');
													if ($timer == true) {
														echo "shown";
													} else {
														echo "hidden";
													}
												?>		
										
													<label for="timer">
														<?php _e('', 'slick-tab') ?>
													</label>
													:<input name="<?php  echo $slick_tab->get_plugin_option_fullname('timer') ?>" value="<?php  echo $slick_tab->get_plugin_option('timer') ?>" id="timer" maxlength="6" size="5" />seconds
											</span>
										</div>
<script type='application/javascript'> //TODO: Internet Explorer support for these toggles change to text/javascript when ready
var jQuery;
jQuery("input:checkbox[id*=show_on_load]").click(function () {
	"use strict";
	if (jQuery(('#timer.hidden').length)) {
		jQuery('#timer').toggleClass('hidden');
		return;
	} else if (jQuery(('#timer.shown').length)) {
		jQuery('#timer').toggleClass('shown');
		return;
	}
});
jQuery("input:checkbox[id*=enable_timer]").click(function () {
	"use strict";
	if (jQuery(('#autohide.hidden').length)) {
		jQuery('#autohide').toggleClass('hidden');
		return;
	} else if (jQuery(('#autohide.shown').length)) {
		jQuery('#autohide').toggleClass('shown');
		return;
	}
});
</script>	
								</td>
							</tr>
							<tr valign="top">
								<th scope="row"><strong><?php _e('slick Content Settings', 'slick-tab') ?></strong></th>
								<td>
									<p>
										<label for="borders">
											<?php _e('Use Borders:', 'slick-tab') ?>
										</label>
										<input class="no_borders" type="radio" name="<?php  echo $slick_tab->get_plugin_option_fullname('borders') ?>" value=0 <?php if($slick_tab->get_plugin_option('borders') == 0) echo 'checked="yes"'; ?> /> No
										<input class="yes_borders" type="radio" name="<?php  echo $slick_tab->get_plugin_option_fullname('borders') ?>" value=1 <?php if($slick_tab->get_plugin_option('borders') ==1) echo 'checked="yes"'; ?> /> Yes
										<span class="border_size">										
											<label for="border_size">
												<?php _e('-> Border Thickness:', 'slick-tab') ?>
											</label>
											<input class="border_size" name="<?php  echo $slick_tab->get_plugin_option_fullname('border_size') ?>" value= "<?php  echo $slick_tab->get_plugin_option('border_size') ?>" id="border_size" size="2" />px
										</span>
										<br />
										<label for="open_width">
											<?php _e('slick width:', 'slick-tab') ?>
										</label>
										<input name="<?php  echo $slick_tab->get_plugin_option_fullname('open_width') ?>" value= "<?php  echo $slick_tab->get_plugin_option('open_width') ?>" id="open_width" maxlength=<?php if($slick_tab->get_plugin_option('window_unit') == '%') echo '3'; else echo '5'; ?> size="2" />
										
										<label for="open_height">
											<?php _e('slick height:', 'slick-tab') ?>
										</label>
										<input name="<?php  echo $slick_tab->get_plugin_option_fullname('open_height') ?>" value= "<?php  echo $slick_tab->get_plugin_option('open_height') ?>" id="open_height" maxlength=<?php if($slick_tab->get_plugin_option('window_unit') == '%') echo '3'; else echo '5'; ?> size="2" />			
										
										<label for="window_unit">
												<input type="radio" name="<?php  echo $slick_tab->get_plugin_option_fullname('window_unit') ?>" value="px" <?php if($slick_tab->get_plugin_option('window_unit') == 'px') echo 'checked="yes"'; ?> /> px
												<input type="radio" name="<?php  echo $slick_tab->get_plugin_option_fullname('window_unit') ?>" value="%" <?php if($slick_tab->get_plugin_option('window_unit') == '%') echo 'checked="yes"'; ?> /> %
										</label> 
										<div class="peripheral">

										<label for="open_top">
											<?php _e('Vertical position from top:', 'slick-tab') ?>
										</label>
										
										<input name="<?php  echo $slick_tab->get_plugin_option_fullname('open_top') ?>" value= "<?php  echo $slick_tab->get_plugin_option('open_top') ?>" id="open_top" maxlength=<?php if($slick_tab->get_plugin_option('window_unit') == '%') echo '2'; else echo '5'; ?> size="1" />%
										<br />
										</div>
										<span class="description"><?php _e('The size and vertical positioning settings.<br /> Width and Height values can be dealt with either in percentages or pixels.', 'slick-tab') ?></span>
									</p>
									
									<p>
										<label for="template_pick">
											<?php _e('Template:', 'slick-tab') ?>
										</label>
										<input type=hidden name="<?php  echo $slick_tab->get_plugin_option_fullname('template_pick') ?>"  value="<?php  echo $slick_tab->get_plugin_option('template_pick') ?>" id="template_pick" size="90">
							
											<select name="template_select" value=<?php  echo $slick_tab->get_plugin_option('template_pick') ?> id='template_select'>	
												<option id='subscribe' value='Subscribe'>Subscribe</option>
												<option id='wplogin' value='WPLogin'>WPLogin</option>
												<option id='widget' value='Widget'>Widget</option>
												<option id='custom' value='Custom'>Custom</option>
											</select>
										</input>
									</p>
									<div id="Widget" class="hidden">
										<span class="description"><?php _e('Slick Tab Widget Area Enabled.', 'slick-tab') ?></span>
									</div>
									
									<div id="Custom" class="hidden">	    
									    <label for="window_url">
										<?php _e('Window Url Path:', 'slick-tab') ?>
										</label>
										<input name="<?php  echo $slick_tab->get_plugin_option_fullname('window_url') ?>"  value="<?php  echo $slick_tab->get_plugin_option('window_url') ?>" id="window_url" size="90" />
										<br />
										<span class="description"><?php _e('example: http://www.yoursite.com/path_to/target.php', 'slick-tab') ?></span>
									</div>
								</p>
<script type="text/javascript">
"use strict";
var myOptions, val, oldSelection, i;
function testValue(newOption) {
	for (i = 0; i < myOptions.length; i = i + 1) {
		if (newOption === myOptions[i]) {
			jQuery("#" + newOption).show();
			if (newOption !== "Custom") {
				//set the new template window url
				jQuery("#window_url").val("<?php echo get_option('siteurl'); ?>" + "/wp-content/plugins/slick-tab/templates/" + newOption + ".php");
			}
		} else {
			jQuery("#" + myOptions[i]).hide();
		}
	}
}
oldSelection = "<?php  echo $slick_tab->get_plugin_option('template_pick') ?>";
jQuery("#template_select").bind(jQuery.browser.msie ? 'propertychange' : 'change', function (e) {
	e.preventDefault(); // Your code here 
	var selectValue, selectOption;
	//selectValue = jQuery('#template_select').val();
	selectValue = document.getElementById('template_select').value;
	selectOption = jQuery("#template_select option[value=" + selectValue + "]").text();
	jQuery("#template_pick").val(selectOption);
	jQuery("#template_select").click(testValue(selectOption));
});
jQuery("#template_select").change(function () {
	var selectValue, selectOption;
	selectValue = jQuery('#template_select').val();
	//selectValue = document.getElementById('template_select').value;
	selectOption = jQuery("#template_select option[value=" + selectValue + "]").text();
	jQuery("#template_pick").val(selectOption);
	jQuery("#template_select").change(testValue(selectOption));
});
myOptions = [];
jQuery("#template_select").find('option').each(function () {
	val = jQuery(this).text();
	myOptions.push(val);
});
testValue(oldSelection);
jQuery("select[name=template_select] option[value=" + oldSelection + "]").attr("selected", true);
</script>
<script type="text/javascript">
 
  jQuery(document).ready(function() {
	if( jQuery(".no_borders").attr('checked')){
			jQuery('.border_size').hide();
	} else {
			jQuery('.border_size').show();
	}
	jQuery(".yes_borders").click(function(){
		jQuery('.border_size').show();
		});
	jQuery(".no_borders").click(function(){
		jQuery('.border_size').val("0");
		jQuery('.border_size').hide();
		});
	
	if( jQuery(".tab_image").attr('checked')){
			jQuery('.tab_size').hide();
	} else {
			jQuery('.tab_size').show();
	}
	jQuery(".tab_title").click(function(){
		jQuery('.tab_size').show();
		});
	jQuery(".tab_image").click(function(){
		jQuery('.tab_size').hide();
		});
    jQuery('#bgcolorpicker').hide();
	jQuery('#bgcolorpicker').farbtastic(function(color){
		jQuery('#background').val(color);
		jQuery('#background').css('background', color);
	});
    jQuery("#background").click(function(){jQuery('#bgcolorpicker').slickToggle()});
	jQuery('#tabcolorpicker').hide();
	jQuery('#tabcolorpicker').farbtastic(function(color){
		jQuery('#tab_color').val(color);
		jQuery('#tab_color').css('background', color);
	});
    jQuery("#tab_color").click(function(){jQuery('#tabcolorpicker').slickToggle()});
	
	if( jQuery(".cssonly").attr('checked')){
		jQuery('.peripheral').hide();
	} else {
		jQuery('.peripheral').show();
	}
	jQuery(".cssonly").click(function(){jQuery('.peripheral').hide()});
	jQuery(".integratedcss").click(function(){jQuery('.peripheral').show()});
  });
 
</script>					
								</td>
							</tr>
							<tr valign="top" class="peripheral">
								<th scope="row"><strong><?php _e('Background Settings', 'slick-tab') ?></strong></th>
								<td>
									<p>
										<label for="background">
											<?php _e('Background (Path or Color):', 'slick-tab') ?>
										</label>
										<input name="<?php  echo $slick_tab->get_plugin_option_fullname('background') ?>" value="<?php  echo $slick_tab->get_plugin_option('background') ?>" id="background" size="78" />
										<br />
										<span class="description"><?php _e('You can use the color picker or simply use the image location eg. http://www.yoursite.com/background.jpg', 'slick-tab') ?></span>
										<div id="bgcolorpicker"></div>
									</p>
									<p>
										<label for="opacity">
											<?php _e('Opacity:', 'slick-tab') ?>
										</label>
										
										<input type="range"  min="0" max="100" name="<?php  echo $slick_tab->get_plugin_option_fullname('opacity') ?>" value="<?php  echo $slick_tab->get_plugin_option('opacity') ?>" id="opacity" maxlength=<?php if($slick_tab->get_plugin_option('window_unit') == '%') echo '3'; else echo '5'; ?> size="2" onchange="showValue(this.value)" />
										<span id="range"><?php  echo $slick_tab->get_plugin_option('opacity') ?></span>
<script type="text/javascript">
function showValue(newValue) {
	"use strict";
	document.getElementById("range").innerHTML = newValue;
}
</script>
										<br />
										<span class="description"><?php _e('The background opacity.<br />  Any value between 0 (transparent) and 100 (opaque)', 'slick-tab') ?></span>
									</p>
									
								</td>
							</tr>					
							<tr valign="top" class="peripheral">
								<th scope="row"><strong><?php _e('TAB Settings', 'slick-tab') ?></strong></th>
								<td>
									<p>
										<label for="tab_top">
											<?php _e('Position from top:', 'slick-tab') ?>
										</label>
										<input name="<?php  echo $slick_tab->get_plugin_option_fullname('tab_top') ?>" value="<?php  echo $slick_tab->get_plugin_option('tab_top') ?>" id="tab_top" maxlength="3" size="2" />%
										<br />
										<span class="description"><?php _e('Vertical tab position relative to slick content height.<br /> Use any value between 0 (top of slick) and 100 (bottom of slick)', 'slick-tab') ?></span>
									</p>
								</td>
							</tr>									
						</table>
						
				</div>

	
	
	
	<div id="support">
		<table class="form-table">
							<tr valign="left">
									<th scope="row">
										<div id="rate" align="right">
												<?php					
											if (function_exists('get_transient')) {
											  require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
											
											  // First, try to access the data, check the cache.
											  if (false === ($api = get_transient('slick-tab'))) {
											    // The cache data doesn't exist or it's expired.
											
											    $api = plugins_api('plugin_information', array('slug' => stripslashes( 'slick-tab' ) ));
												
											    if ( !is_wp_error($api) ) {
											      // cache isn't up to date, write this fresh information to it now to avoid the query for xx time.
											      $myexpire = 60 * 15; // Cache data for 15 minutes
											      set_transient('slick-tab', $api, $myexpire);
											    }
											  }
											  
											  if ( !is_wp_error($api) ) {
												  $plugins_allowedtags = array('a' => array('href' => array(), 'title' => array(), 'target' => array()),
																			'abbr' => array('title' => array()), 'acronym' => array('title' => array()),
																			'code' => array(), 'pre' => array(), 'em' => array(), 'strong' => array(),
																			'div' => array(), 'p' => array(), 'ul' => array(), 'ol' => array(), 'li' => array(),
																			'h1' => array(), 'h2' => array(), 'h3' => array(), 'h4' => array(), 'h5' => array(), 'h6' => array(),
																			'img' => array('src' => array(), 'class' => array(), 'alt' => array()));
												  //Sanitize HTML
												  foreach ( (array)$api->sections as $section_name => $content )
													$api->sections[$section_name] = wp_kses($content, $plugins_allowedtags);
												  foreach ( array('version', 'author', 'requires', 'tested', 'homepage', 'downloaded', 'slug') as $key )
													$api->$key = wp_kses($api->$key, $plugins_allowedtags);
											
											      if ( ! empty($api->downloaded) ) {
											        echo sprintf(__('Downloaded %s times', 'slick-tab'),number_format_i18n($api->downloaded));
											        echo '.';
											      } ?>
												      <?php if ( ! empty($api->rating) ) : ?>
													  <div class="star-holder" title="<?php echo $this->slick_tab_ouput_string(sprintf(__('(Average rating based on %s ratings)', 'slick-tab'),number_format_i18n($api->num_ratings))); ?>">
													  <div class="star star-rating" style="width: <?php echo $this->slick_tab_ouput_string($api->rating) ?>px"></div>
													  <div class="star star5"></div>
													  <div class="star star4"></div>
													  <div class="star star3"></div>
													  <div class="star star2"></div>
													  <div class="star star1"></div>
													  </div>
													  <small><?php echo sprintf(__('(Average rating based on %s ratings)', 'slick-tab'),number_format_i18n($api->num_ratings)); ?> <a target="_blank" href="http://wordpress.org/extend/plugins/<?php echo $api->slug ?>/"> <?php _e('Rate This Plugin', 'slick-tab') ?></a></small>
												      <br />
												    <?php endif;
												} // if ( !is_wp_error($api)
											}// end if (function_exists('get_transient'
													?>
										</div>
										<div id='donation' align="center">
											<strong><a href='#' onclick="window.open('http://ataulswebdesigns.com/donate/')">» Donate to this plugin</a></strong>
										</div>
										
										
									</th>
									
									<td>
								<br /><span><strong>Thank you for using Slick Tab! Follow Me on <span style="color: #008000;"><a href="https://plus.google.com/109526129815752833990/" target="_blank"><span style="color: #008000;">Google+</span></a></span>.</strong>
										<br /><em>Please take a moment to Rate, Blog and spread the word to help support this plugin.</em>
										<br />Suggestions, Issues? Check out the <input type="button" value="Support Blog" class="button-secondary" onclick="window.open('http://ataulswebdesigns.com/')"</input> and ask your questions. 
										</span>
										
									</td>
							</tr>
					
		</table><br />					
	</div>
	
	
	
	
	<div id="advanced">
						<?php settings_fields( $slick_tab->options_group ); ?>						
						<table class="form-table">
							<tr valign="top">
								<th scope="row"><strong><?php _e('Visual Settings', 'slick-tab') ?></strong></th>
								<td>	
								<p>
											<label for="credentials">
												<?php _e('Show slicktab to:', 'slick-tab') ?><br />
												<input type="radio" name="<?php  echo $slick_tab->get_plugin_option_fullname('credentials') ?>" value="all" <?php if($slick_tab->get_plugin_option('credentials') == 'all') echo 'checked="yes"'; ?> /> Everyone<br />
												<input type="radio" name="<?php  echo $slick_tab->get_plugin_option_fullname('credentials') ?>" value="auth" <?php if($slick_tab->get_plugin_option('credentials') == 'auth') echo 'checked="yes"'; ?> /> Only users that are logged in<br />
												<input type="radio" name="<?php  echo $slick_tab->get_plugin_option_fullname('credentials') ?>" value="unauth" <?php if($slick_tab->get_plugin_option('credentials') == 'unauth') echo 'checked="yes"'; ?> /> Only visitors that are logged out<br />
											</label>
										</p> 
										<p>
											<?php _e('Include slicktab on:', 'slick-tab') ?><br />
											<input type="radio" name="<?php  echo $slick_tab->get_plugin_option_fullname('list_pick') ?>" value="shortcode" <?php if($slick_tab->get_plugin_option('list_pick') == 'shortcode') echo 'checked="yes"'; ?> />
											<label for="shortcode">
											<?php _e('Use the [slicktab] shortcode.', 'slick-tab') ?>
											</label><br />
											
											<input type="radio" name="<?php  echo $slick_tab->get_plugin_option_fullname('list_pick') ?>" value="all" <?php if($slick_tab->get_plugin_option('list_pick') == 'all') echo 'checked="yes"'; ?> />
											<label for="include_all">
											<?php _e('Include on all pages.', 'slick-tab') ?>
											</label><br />
											
											<input type="radio" name="<?php  echo $slick_tab->get_plugin_option_fullname('list_pick') ?>" value="include" <?php if($slick_tab->get_plugin_option('list_pick') == 'include') echo 'checked="yes"'; ?> />
											<label for="include_list">
												<?php _e('Include only on page ID(s):', 'slick-tab') ?>
											</label>
											<input name="<?php  echo $slick_tab->get_plugin_option_fullname('include_list') ?>" value="<?php  echo $slick_tab->get_plugin_option('include_list') ?>" id="include_list" maxlength="100" size="5" /> <br />
											
											<input type="radio" name="<?php  echo $slick_tab->get_plugin_option_fullname('list_pick') ?>" value="exclude" <?php if($slick_tab->get_plugin_option('list_pick') == 'exclude') echo 'checked="yes"'; ?> />
											<label for="exclude_list">
											<?php _e('Exclude from page ID(s):', 'slick-tab') ?>
											</label>
											<input name="<?php  echo $slick_tab->get_plugin_option_fullname('exclude_list') ?>" value="<?php  echo $slick_tab->get_plugin_option('exclude_list') ?>" id="exclude_list" maxlength="100" size="5" /><br />
											<span class="description"><?php _e('example: 2, 3, 55', 'slick-tab') ?></span><br />
											<label for="disable_pages">
											<?php _e('Disable pages:', 'slick-tab') ?>
											</label>
											<input name="<?php  echo $slick_tab->get_plugin_option_fullname('disabled_pages') ?>" value="<?php  echo $slick_tab->get_plugin_option('disabled_pages') ?>" id="disabled_pages" maxlength="100" size="50" /><br />
											<span class="description"><?php _e('example: template.php', 'slick-tab') ?></span><br />
										</p>
										<p>
											<label for="include_method">
												<?php _e('Include Method:', 'slick-tab') ?>
												<input type="radio" name="<?php  echo $slick_tab->get_plugin_option_fullname('include_method') ?>" value="php" <?php if($slick_tab->get_plugin_option('include_method') == 'php') echo 'checked="yes"'; ?> /> PHP
												<input type="radio" name="<?php  echo $slick_tab->get_plugin_option_fullname('include_method') ?>" value="js" <?php if($slick_tab->get_plugin_option('include_method') == 'js') echo 'checked="yes"'; ?> /> jQuery
											</label> <br />
											<span class="description"><?php _e('Use PHP include method for forms, jQuery can load an external URL', 'slick-tab') ?>
											
										</p> 
										<p>
											<label for="animation_speed">
												<?php _e('Closing Speed:', 'slick-tab') ?>
											</label>
											<input name="<?php  echo $slick_tab->get_plugin_option_fullname('animation_speed') ?>" value="<?php  echo $slick_tab->get_plugin_option('animation_speed') ?>" id="animation_speed" maxlength="6" size="5" />seconds
											<br />
											<span class="description"><?php _e('Set how long it takes for the tab to close.', 'slick-tab') ?>
											
										</p> 
								</td>
							</tr>
							<tr valign="top">
								<th scope="row"><strong><?php _e('TAB Settings', 'slick-tab') ?></strong></th>
								<td>
									<p>
									<input class="tab_image" type="radio" name="<?php  echo $slick_tab->get_plugin_option_fullname('tab_type') ?>" value=1 <?php if($slick_tab->get_plugin_option('tab_type') == 1) echo 'checked="yes"'; ?> /> 	
										<label for="tab_image">
											<?php _e('Tab Image', 'slick-tab') ?>
										</label>
									</p>
									<p>
									<input class="tab_title" type="radio" name="<?php  echo $slick_tab->get_plugin_option_fullname('tab_type') ?>" value=0 <?php if($slick_tab->get_plugin_option('tab_type') == 0) echo 'checked="yes"'; ?> /> 
										<label for="tab_title_close">
											<?php _e('Tab Title - Closed View:', 'slick-tab') ?>
										</label>
										<input name="<?php  echo $slick_tab->get_plugin_option_fullname('tab_title_open') ?>" value="<?php echo $slick_tab->get_plugin_option('tab_title_open') ?>" id="tab_title_open" size="5" />
										<label for="tab_title_open">
											<?php _e('Opened View:', 'slick-tab') ?>
										</label>
										<input name="<?php  echo $slick_tab->get_plugin_option_fullname('tab_title_close') ?>" value="<?php echo $slick_tab->get_plugin_option('tab_title_close') ?>" id="tab_title_close" size="5" />
									</p>
									<p class="tab_size">
										<label for="tab_height">
											<?php _e('Vertical TAB Size:', 'slick-tab') ?>
										</label>
										<input name="<?php  echo $slick_tab->get_plugin_option_fullname('tab_height') ?>" value="<?php echo $slick_tab->get_plugin_option('tab_height') ?>" id="tab_height" size="3" />px
									</p>
									<p class="tab_size">
										<label for="tab_width">
											<?php _e('Horizontal TAB Size:', 'slick-tab') ?>
										</label>
										<input name="<?php  echo $slick_tab->get_plugin_option_fullname('tab_width') ?>" value="<?php echo $slick_tab->get_plugin_option('tab_width') ?>" id="tab_width" size="3" />px
									</p>
									<p class="peripheral">
										<label for="tab_color">
											<?php _e('Color:', 'slick-tab') ?>
										</label>
										<input name="<?php  echo $slick_tab->get_plugin_option_fullname('tab_color') ?>" value="<?php echo $slick_tab->get_plugin_option('tab_color') ?>" id="tab_color" size="8" />
									    <br />
										<span class="description" <?php _e('Set the color of the tab as well as ALL the borders.', 'slick-tab') ?>
										<div id="tabcolorpicker"></div>	
									</p>
								</td>
							</tr>									
						</table>

				</div>
	</div>
		<p class="submit">
			<input type="hidden" name="<?php echo $slick_tab->get_plugin_option_fullname('version') ?>" value="<?php echo ($slick_tab->get_plugin_option('version')) ?>" />
	        <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'slick-tab') ?>" />  
		</p>
	</form>
</div>


<?php		
		}
	}
}