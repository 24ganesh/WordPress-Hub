<?php

require_once 'constants.php';

abstract class BaseAdInserter {

    // define properties
    var $number;
    var $wp_options;

    var $option_append_type;
    var $option_paragraph_number;
    var $option_paragraph_number_minimum;
    var $option_excerpt_number;
    var $option_direction_type;
    var $option_float_type;
    var $option_ad_data;
    var $option_ad_general_tag;
    var $option_ad_name;
    var $option_ad_after_day;
    var $option_ad_domain_list;
    var $option_ad_domain_list_type;
    var $option_ad_category_list;
    var $option_ad_category_list_type;
    var $option_widget_settings_home;
    var $option_widget_settings_page;
    var $option_widget_settings_post;
    var $option_widget_settings_category;
    var $option_widget_settings_search;
    var $option_widget_settings_archive;
    var $option_process_php;
    var $option_enable_manual;
    var $option_enable_php_call;

    function BaseAdInserter() {

      $this->number = 0;

      $this->wp_options = array ();

      $this->wp_options[$this->option_ad_name] = AD_NAME;
      $this->wp_options[$this->option_append_type] = AD_SELECT_NONE;
      $this->wp_options[$this->option_paragraph_number] = AD_ZERO_DATA;
      $this->wp_options[$this->option_paragraph_number_minimum] = AD_ZERO_DATA;
      $this->wp_options[$this->option_excerpt_number] = AD_ZERO_DATA;
      $this->wp_options[$this->option_direction_type] = AD_DIRECTION_FROM_TOP;
      $this->wp_options[$this->option_float_type] = AD_ALIGNMENT_NONE;
      $this->wp_options[$this->option_ad_data] = AD_EMPTY_DATA;
      $this->wp_options[$this->option_ad_general_tag] = AD_GENERAL_TAG;
    	$this->wp_options[$this->option_ad_after_day] = AD_ZERO_DATA;
      $this->wp_options[$this->option_ad_domain_list] = AD_EMPTY_DATA;
      $this->wp_options[$this->option_ad_domain_list_type] = AD_BLACK_LIST;
      $this->wp_options[$this->option_ad_category_list] = AD_EMPTY_DATA;
      $this->wp_options[$this->option_ad_category_list_type] = AD_BLACK_LIST;
      $this->wp_options[$this->option_widget_settings_home] = AD_SETTINGS_CHECKED;
      $this->wp_options[$this->option_widget_settings_page] = AD_SETTINGS_NOT_CHECKED;
      $this->wp_options[$this->option_widget_settings_post] = AD_SETTINGS_CHECKED;
      $this->wp_options[$this->option_widget_settings_category] = AD_SETTINGS_CHECKED;
      $this->wp_options[$this->option_widget_settings_search] = AD_SETTINGS_CHECKED;
      $this->wp_options[$this->option_widget_settings_archive] = AD_SETTINGS_CHECKED;
      $this->wp_options[$this->option_process_php]     = AD_SETTINGS_NOT_CHECKED;
      $this->wp_options[$this->option_enable_manual] = AD_SETTINGS_NOT_CHECKED;
      $this->wp_options[$this->option_enable_php_call] = AD_SETTINGS_NOT_CHECKED;
    }

   public function load_options ($options_name){
     $options = ai_get_option ($options_name);
     if ($options != '') $this->wp_options = $options;
    }

   public function get_append_type(){
     $option = $this->wp_options [$this->option_append_type];
     if ($option == '') $option = AD_SELECT_NONE;
     elseif ($option == AD_SELECT_MANUAL) $option = AD_SELECT_NONE;
     return $option;
    }

   public function get_paragraph_number(){
     $option = $this->wp_options [$this->option_paragraph_number];
     if ($option == '') $option = AD_ZERO_DATA;
     return $option;
    }

   public function get_paragraph_number_minimum(){
     $option = $this->wp_options [$this->option_paragraph_number_minimum];
     if ($option == '') $option = AD_ZERO_DATA;
     return $option;
    }

   public function get_excerpt_number(){
     $option = $this->wp_options [$this->option_excerpt_number];
     if ($option == '') $option = AD_ZERO_DATA;
     return $option;
    }

   public function get_direction_type(){
     $option = $this->wp_options [$this->option_direction_type];
     if ($option == '') $option = AD_DIRECTION_FROM_TOP;
     return $option;
    }

   public function get_alignment_type(){
     // Update old field names
     $alignment = $this->wp_options [$this->option_float_type];
     if($alignment == 'Left'){
       $alignment = AD_ALIGNMENT_FLOAT_LEFT;
       $this->wp_options [$this->option_float_type] = $alignment;
     } else
     if($alignment == 'Right'){
       $alignment = AD_ALIGNMENT_FLOAT_RIGHT;
       $this->wp_options [$this->option_float_type] = $alignment;
     }
     if ($alignment == '') $option = AD_ALIGNMENT_NONE;
     return $this->wp_options [$this->option_float_type];
    }

   public function get_alignmet_style($margin = true){
    if ($this->get_alignment_type() == AD_ALIGNMENT_LEFT) {
      if ($margin)
        $style = "text-align:left;margin:8px 0px;"; else
          $style = "text-align:left;";
    }
    elseif ($this->get_alignment_type() == AD_ALIGNMENT_RIGHT) {
      if ($margin)
        $style = "text-align:right;margin:8px 0px;"; else
          $style = "text-align:right;";
    }
    elseif ($this->get_alignment_type() == AD_ALIGNMENT_CENTER) {
      if ($margin)
        $style = "text-align:center;margin-left:auto;margin-right:auto;margin-top:8px;margin-bottom:8px;"; else
          $style = "text-align:center;margin-left:auto;margin-right:auto;";
    }
    elseif ($this->get_alignment_type() == AD_ALIGNMENT_FLOAT_LEFT) {
      if ($margin)
        $style = "float:left;margin:8px 8px 8px 0px;"; else
          $style = "float:left;";
    }
    elseif ($this->get_alignment_type() == AD_ALIGNMENT_FLOAT_RIGHT) {
      if ($margin)
        $style = "float:right;margin:8px 0px 8px 8px;"; else
          $style = "float:right;";
    }
    else {
      if ($margin)
        $style = "margin:8px 0px;";
          $style = "margin:0;";
    }

    return $style;
   }

   public function get_ad_data(){
     $ad_data = $this->wp_options [$this->option_ad_data];
     return $ad_data;
   }

   public function get_display_settings_home(){
     $widget_settings = $this->wp_options[$this->option_widget_settings_home];
     if ($widget_settings == '') $widget_settings = AD_SETTINGS_CHECKED;
     return $widget_settings;
   }

   public function get_display_settings_page(){
     $widget_settings = $this->wp_options[$this->option_widget_settings_page];
     if ($widget_settings == '') $widget_settings = AD_SETTINGS_NOT_CHECKED;
     return $widget_settings;
   }

   public function get_display_settings_post(){
     $widget_settings = $this->wp_options[$this->option_widget_settings_post];
     if ($widget_settings == '') $widget_settings = AD_SETTINGS_CHECKED;
     return $widget_settings;
   }

   public function get_display_settings_category(){
     $widget_settings = $this->wp_options[$this->option_widget_settings_category];
     if ($widget_settings == '') $widget_settings = AD_SETTINGS_CHECKED;
     return $widget_settings;
   }

   public function get_display_settings_search(){
     $widget_settings = $this->wp_options[$this->option_widget_settings_search];
     if ($widget_settings == '') $widget_settings = AD_SETTINGS_CHECKED;
     return $widget_settings;
   }

   public function get_display_settings_archive(){
     $widget_settings = $this->wp_options[$this->option_widget_settings_archive];
     if ($widget_settings == '') $widget_settings = AD_SETTINGS_CHECKED;
     return $widget_settings;
   }

   public function get_process_php (){
     $process_php = $this->wp_options [$this->option_process_php];
     if ($process_php == '') $process_php = AD_SETTINGS_NOT_CHECKED;
     return $process_php;
   }

   public function get_enable_manual (){
     $enable_manual = $this->wp_options [$this->option_enable_manual];
     if ($enable_manual == '') {
       $display_option = $this->wp_options [$this->option_append_type];
       if ($display_option == AD_SELECT_MANUAL)
         $enable_manual = AD_SETTINGS_CHECKED; else
           $enable_manual = AD_SETTINGS_NOT_CHECKED;
     }
     return $enable_manual;
   }

   public function get_enable_php_call (){
     $enable_php_call = $this->wp_options [$this->option_enable_php_call];
     if ($enable_php_call == '') $enable_php_call = AD_SETTINGS_NOT_CHECKED;
     return $enable_php_call;
   }

   public function get_ad_data_replaced(){

     $general_tag = $this->wp_options[$this->option_ad_general_tag];
     $general_tag = str_replace ("&amp;", " and ", $general_tag);
     $title = $general_tag;
     $short_title = $general_tag;
     $category = $general_tag;
     $short_category = $general_tag;
     $tag = $general_tag;
     $smart_tag = $general_tag;
     if (is_category ()) {
         $categories = get_the_category();
         if (!empty ($categories)) {
           $first_category = reset ($categories);
           $category = str_replace ("&amp;", "and", $first_category->name);
           if ($category == "Uncategorized") $category = $general_tag;
         } else {
             $category = $general_tag;
         }
         if (strpos ($category, ",") !== false) {
           $short_category = trim (substr ($category, 0, strpos ($category, ",")));
         } else $short_category = $category;
         if (strpos ($short_category, "and") !== false) {
           $short_category = trim (substr ($short_category, 0, strpos ($short_category, "and")));
         }

         $title = $category;
         $title = str_replace ("&amp;", "and", $title);
         $short_title = implode (" ", array_slice (explode (" ", $title), 0, 3));
         $tag = $short_title;
         $smart_tag = $short_title;
     } elseif (is_tag ()) {
         $title = single_tag_title('', false);
         $title = str_replace ("&amp;", "and", $title);
         $short_title = implode (" ", array_slice (explode (" ", $title), 0, 3));
         $category = $short_title;
         if (strpos ($category, ",") !== false) {
           $short_category = trim (substr ($category, 0, strpos ($category, ",")));
         } else $short_category = $category;
         if (strpos ($short_category, "and") !== false) {
           $short_category = trim (substr ($short_category, 0, strpos ($short_category, "and")));
         }
         $tag = $short_title;
         $smart_tag = $short_title;
     } elseif (is_search ()) {
         $title = get_search_query();
         $title = str_replace ("&amp;", "and", $title);
         $short_title = implode (" ", array_slice (explode (" ", $title), 0, 3));
         $category = $short_title;
         if (strpos ($category, ",") !== false) {
           $short_category = trim (substr ($category, 0, strpos ($category, ",")));
         } else $short_category = $category;
         if (strpos ($short_category, "and") !== false) {
           $short_category = trim (substr ($short_category, 0, strpos ($short_category, "and")));
         }
         $tag = $short_title;
         $smart_tag = $short_title;
     } elseif (is_page () || is_single ()) {
         $title = get_the_title();
         $title = str_replace ("&amp;", "and", $title);

         $short_title = implode (" ", array_slice (explode (" ", $title), 0, 3));

         $categories = get_the_category();
         if (!empty ($categories)) {
           $first_category = reset ($categories);
           $category = str_replace ("&amp;", "and", $first_category->name);
           if ($category == "Uncategorized") $category = $general_tag;
         } else {
             $category = $short_title;
         }
         if (strpos ($category, ",") !== false) {
           $short_category = trim (substr ($category, 0, strpos ($category, ",")));
         } else $short_category = $category;
         if (strpos ($short_category, "and") !== false) {
           $short_category = trim (substr ($short_category, 0, strpos ($short_category, "and")));
         }

         $tags = get_the_tags();
         if (!empty ($tags)) {

           $first_tag = reset ($tags);
           $tag = $first_tag->name;

           $tag_array = array ();
           foreach ($tags as $tag_data) {
             $tag_array [] = explode (" ", $tag_data->name);
           }

           $selected_tag = '';

           if (count ($tag_array [0]) == 2) $selected_tag = $tag_array [0];
           elseif (count ($tag_array) > 1 && count ($tag_array [1]) == 2) $selected_tag = $tag_array [1];
           elseif (count ($tag_array) > 2 && count ($tag_array [2]) == 2) $selected_tag = $tag_array [2];
           elseif (count ($tag_array) > 3 && count ($tag_array [3]) == 2) $selected_tag = $tag_array [3];
           elseif (count ($tag_array) > 4 && count ($tag_array [4]) == 2) $selected_tag = $tag_array [4];


           if ($selected_tag == '' && count ($tag_array) >= 2 && count ($tag_array [0]) == 1 && count ($tag_array [1]) == 1) {

             if (strpos ($tag_array [0][0], $tag_array [1][0]) !== false) $tag_array = array_slice ($tag_array, 1, count ($tag_array) - 1);
             if (strpos ($tag_array [1][0], $tag_array [0][0]) !== false) $tag_array = array_slice ($tag_array, 1, count ($tag_array) - 1);

             if (count ($tag_array) >= 2 && count ($tag_array [0]) == 1 && count ($tag_array [1]) == 1) {
               $selected_tag = array ($tag_array [0][0], $tag_array [1][0]);
             }
           }

           if ($selected_tag == '') {
             $first_tag = reset ($tags);
             $smart_tag = implode (" ", array_slice (explode (" ", $first_tag->name), 0, 3));
           } else $smart_tag = implode (" ", $selected_tag);

           $smart_tag = str_replace ("&amp;", "and", $smart_tag);

         } else {
             $tag = $category;
             $smart_tag = $category;
         }
     }

     $title = str_replace (array ("'", '"'), array ("&#8217;", "&#8221;"), $title);
     $title = html_entity_decode ($title, ENT_QUOTES, "utf-8");

     $short_title = str_replace (array ("'", '"'), array ("&#8217;", "&#8221;"), $short_title);
     $short_title = html_entity_decode ($short_title, ENT_QUOTES, "utf-8");

     $referrer = $_SERVER['HTTP_REFERER'];
     if (preg_match("/[\.\/](google|yahoo|bing|ask)\.[a-z\.]{2,5}[\/]/i",$referrer,$search_engine)){
        $referrer_query = parse_url($referrer);
        $referrer_query = $referrer_query["query"];
        parse_str ($referrer_query, $value);
        $search_query = $value ["q"];
        if ($search_query == "") {
          $search_query = $value ["p"];
        }
     }
     if ($search_query == "") $search_query = $smart_tag;

     $ad_data = preg_replace ("/{title}/i",          $title,          $this->wp_options[$this->option_ad_data]);
     $ad_data = preg_replace ("/{short_title}/i",    $short_title,    $ad_data);
     $ad_data = preg_replace ("/{category}/i",       $category,       $ad_data);
     $ad_data = preg_replace ("/{short_category}/i", $short_category, $ad_data);
     $ad_data = preg_replace ("/{tag}/i",            $tag,            $ad_data);
     $ad_data = preg_replace ("/{smart_tag}/i",      $smart_tag,      $ad_data);
     $ad_data = preg_replace ("/{search_query}/i",   $search_query,   $ad_data);

     return $ad_data;
   }

   public function get_ad_general_tag(){
     $option = $this->wp_options [$this->option_ad_general_tag];
     if ($option == '') $option = AD_GENERAL_TAG;
     return $option;
   }

	public function get_ad_after_day(){
     $option = $this->wp_options [$this->option_ad_after_day];
     if ($option == '') $option = AD_ZERO_DATA;
     return $option;
   }

  public function get_ad_domain_list(){
      return $this->wp_options [$this->option_ad_domain_list];
   }

  public function get_ad_domain_list_type (){
     $option = $this->wp_options [$this->option_ad_domain_list_type];
     if ($option == '') $option = AD_BLACK_LIST;
     return $option;
   }

	public function get_ad_name(){
     $option = $this->wp_options [$this->option_ad_name];
     if ($option == '') $option = AD_NAME. " " . $this->number;
     return $option;
   }

	public function get_ad_block_cat(){
      return $this->wp_options[$this->option_ad_category_list];
   }

  public function get_ad_block_cat_type(){
     // Update old data
     if($this->wp_options [$this->option_ad_category_list_type] == ''){
       $this->wp_options [$this->option_ad_category_list_type] = AD_BLACK_LIST;
     }

     $option = $this->wp_options [$this->option_ad_category_list_type];
     if ($option == '') $option = AD_BLACK_LIST;
     return $option;
   }
}

class Ad1 extends BaseAdInserter{

   const OPTION_AD_NAME = "ad1_name";
   const OPTION_APPEND_TYPE = "ad1_displayType";
   const OPTION_PARAGRAPH_NUMBER = "ad1_paragraphNumber";
   const OPTION_PARAGRAPH_NUMBER_MINIMUM = "ad1_minimum_paragraphs";
   const OPTION_EXCERPT_NUMBER = "ad1_excerptNumber";
   const OPTION_DIRECTION_TYPE = "ad1_directionType";
   const OPTION_FLOAT_TYPE = "ad1_floatType";
   const OPTION_AD_DATA = "ad1_data";
   const OPTION_AD_GENERAL_TAG = "ad1_general_tag";
   const OPTION_AD_AFTER_DAY = "ad1_after_day";
   const OPTION_AD_DOMAIN_LIST = "ad1_block_user";
   const OPTION_AD_DOMAIN_LIST_TYPE = "ad1_domain_list_type";
   const OPTION_AD_CATEGORY_LIST = "ad1_block_cat";
   const OPTION_AD_CATEGORY_LIST_TYPE = "ad1_block_cat_type";
   const OPTION_WIDGET_SETTINGS_HOME     = "ad1_widget_settings_home";
   const OPTION_WIDGET_SETTINGS_PAGE     = "ad1_widget_settings_page";
   const OPTION_WIDGET_SETTINGS_POST     = "ad1_widget_settings_post";
   const OPTION_WIDGET_SETTINGS_CATEGORY = "ad1_widget_settings_category";
   const OPTION_WIDGET_SETTINGS_SEARCH   = "ad1_widget_settings_search";
   const OPTION_WIDGET_SETTINGS_ARCHIVE  = "ad1_widget_settings_archive";
   const OPTION_PROCESS_PHP              = "ad1_process_php";
   const OPTION_ENABLE_MANUAL            = "ad1_enable_manual";
   const OPTION_ENABLE_PHP_CALL          = "ad1_enable_php_call";

	//constructor
    public function Ad1() {

      $this->option_ad_name = self::OPTION_AD_NAME;
      $this->option_append_type = self::OPTION_APPEND_TYPE;
      $this->option_paragraph_number = self::OPTION_PARAGRAPH_NUMBER;
      $this->option_paragraph_number_minimum = self::OPTION_PARAGRAPH_NUMBER_MINIMUM;
      $this->option_excerpt_number = self::OPTION_EXCERPT_NUMBER;
      $this->option_direction_type = self::OPTION_DIRECTION_TYPE;
      $this->option_float_type = self::OPTION_FLOAT_TYPE;
      $this->option_ad_data = self::OPTION_AD_DATA;
      $this->option_ad_general_tag = self::OPTION_AD_GENERAL_TAG;
      $this->option_ad_after_day = self::OPTION_AD_AFTER_DAY;
      $this->option_ad_domain_list           = self::OPTION_AD_DOMAIN_LIST;
      $this->option_ad_domain_list_type      = self::OPTION_AD_DOMAIN_LIST_TYPE;
      $this->option_ad_category_list         = self::OPTION_AD_CATEGORY_LIST;
      $this->option_ad_category_list_type    = self::OPTION_AD_CATEGORY_LIST_TYPE;
      $this->option_widget_settings_home     = self::OPTION_WIDGET_SETTINGS_HOME;
      $this->option_widget_settings_page     = self::OPTION_WIDGET_SETTINGS_PAGE;
      $this->option_widget_settings_post     = self::OPTION_WIDGET_SETTINGS_POST;
      $this->option_widget_settings_category = self::OPTION_WIDGET_SETTINGS_CATEGORY;
      $this->option_widget_settings_search   = self::OPTION_WIDGET_SETTINGS_SEARCH ;
      $this->option_widget_settings_archive  = self::OPTION_WIDGET_SETTINGS_ARCHIVE;
      $this->option_process_php              = self::OPTION_PROCESS_PHP;
      $this->option_enable_manual            = self::OPTION_ENABLE_MANUAL;
      $this->option_enable_php_call          = self::OPTION_ENABLE_PHP_CALL;

      parent::BaseAdInserter();
      $this->number = 1;
      $this->wp_options[$this->option_ad_name] = AD_NAME." 1";
    }

}

class Ad2 extends BaseAdInserter{

   const OPTION_AD_NAME = "ad2_name";
   const OPTION_APPEND_TYPE = "ad2_displayType";
   const OPTION_PARAGRAPH_NUMBER = "ad2_paragraphNumber";
   const OPTION_PARAGRAPH_NUMBER_MINIMUM = "ad2_minimum_paragraphs";
   const OPTION_EXCERPT_NUMBER = "ad2_excerptNumber";
   const OPTION_DIRECTION_TYPE = "ad2_directionType";
   const OPTION_FLOAT_TYPE = "ad2_floatType";
   const OPTION_AD_DATA = "ad2_data";
   const OPTION_AD_GENERAL_TAG = "ad2_general_tag";
   const OPTION_AD_AFTER_DAY = "ad2_after_day";
   const OPTION_AD_DOMAIN_LIST = "ad2_block_user";
   const OPTION_AD_DOMAIN_LIST_TYPE = "ad2_domain_list_type";
   const OPTION_AD_CATEGORY_LIST = "ad2_block_cat";
   const OPTION_AD_CATEGORY_LIST_TYPE = "ad2_block_cat_type";
   const OPTION_WIDGET_SETTINGS_HOME     = "ad2_widget_settings_home";
   const OPTION_WIDGET_SETTINGS_PAGE     = "ad2_widget_settings_page";
   const OPTION_WIDGET_SETTINGS_POST     = "ad2_widget_settings_post";
   const OPTION_WIDGET_SETTINGS_CATEGORY = "ad2_widget_settings_category";
   const OPTION_WIDGET_SETTINGS_SEARCH   = "ad2_widget_settings_search";
   const OPTION_WIDGET_SETTINGS_ARCHIVE  = "ad2_widget_settings_archive";
   const OPTION_PROCESS_PHP              = "ad2_process_php";
   const OPTION_ENABLE_MANUAL            = "ad2_enable_manual";
   const OPTION_ENABLE_PHP_CALL          = "ad2_enable_php_call";

	//constructor
    public function Ad2() {

      $this->option_ad_name = self::OPTION_AD_NAME;
      $this->option_append_type = self::OPTION_APPEND_TYPE;
      $this->option_paragraph_number = self::OPTION_PARAGRAPH_NUMBER;
      $this->option_paragraph_number_minimum = self::OPTION_PARAGRAPH_NUMBER_MINIMUM;
      $this->option_excerpt_number = self::OPTION_EXCERPT_NUMBER;
      $this->option_direction_type = self::OPTION_DIRECTION_TYPE;
      $this->option_float_type = self::OPTION_FLOAT_TYPE;
      $this->option_ad_data = self::OPTION_AD_DATA;
      $this->option_ad_general_tag = self::OPTION_AD_GENERAL_TAG;
      $this->option_ad_after_day = self::OPTION_AD_AFTER_DAY;
      $this->option_ad_domain_list           = self::OPTION_AD_DOMAIN_LIST;
      $this->option_ad_domain_list_type      = self::OPTION_AD_DOMAIN_LIST_TYPE;
      $this->option_ad_category_list         = self::OPTION_AD_CATEGORY_LIST;
      $this->option_ad_category_list_type    = self::OPTION_AD_CATEGORY_LIST_TYPE;
      $this->option_widget_settings_home     = self::OPTION_WIDGET_SETTINGS_HOME;
      $this->option_widget_settings_page     = self::OPTION_WIDGET_SETTINGS_PAGE;
      $this->option_widget_settings_post     = self::OPTION_WIDGET_SETTINGS_POST;
      $this->option_widget_settings_category = self::OPTION_WIDGET_SETTINGS_CATEGORY;
      $this->option_widget_settings_search   = self::OPTION_WIDGET_SETTINGS_SEARCH ;
      $this->option_widget_settings_archive  = self::OPTION_WIDGET_SETTINGS_ARCHIVE;
      $this->option_process_php              = self::OPTION_PROCESS_PHP;
      $this->option_enable_manual            = self::OPTION_ENABLE_MANUAL;
      $this->option_enable_php_call          = self::OPTION_ENABLE_PHP_CALL;

      parent::BaseAdInserter();
      $this->number = 2;
      $this->wp_options[$this->option_ad_name] = AD_NAME." 2";
    }

}

class Ad3 extends BaseAdInserter{

   const OPTION_AD_NAME = "ad3_name";
   const OPTION_APPEND_TYPE = "ad3_displayType";
   const OPTION_PARAGRAPH_NUMBER = "ad3_paragraphNumber";
   const OPTION_PARAGRAPH_NUMBER_MINIMUM = "ad3_minimum_paragraphs";
   const OPTION_EXCERPT_NUMBER = "ad3_excerptNumber";
   const OPTION_DIRECTION_TYPE = "ad3_directionType";
   const OPTION_FLOAT_TYPE = "ad3_floatType";
   const OPTION_AD_DATA = "ad3_data";
   const OPTION_AD_GENERAL_TAG = "ad3_general_tag";
   const OPTION_AD_AFTER_DAY = "ad3_after_day";
   const OPTION_AD_DOMAIN_LIST = "ad3_block_user";
   const OPTION_AD_DOMAIN_LIST_TYPE = "ad3_domain_list_type";
   const OPTION_AD_CATEGORY_LIST = "ad3_block_cat";
   const OPTION_AD_CATEGORY_LIST_TYPE = "ad3_block_cat_type";
   const OPTION_WIDGET_SETTINGS_HOME     = "ad3_widget_settings_home";
   const OPTION_WIDGET_SETTINGS_PAGE     = "ad3_widget_settings_page";
   const OPTION_WIDGET_SETTINGS_POST     = "ad3_widget_settings_post";
   const OPTION_WIDGET_SETTINGS_CATEGORY = "ad3_widget_settings_category";
   const OPTION_WIDGET_SETTINGS_SEARCH   = "ad3_widget_settings_search";
   const OPTION_WIDGET_SETTINGS_ARCHIVE  = "ad3_widget_settings_archive";
   const OPTION_PROCESS_PHP              = "ad3_process_php";
   const OPTION_ENABLE_MANUAL            = "ad3_enable_manual";
   const OPTION_ENABLE_PHP_CALL          = "ad3_enable_php_call";

	//constructor
    public function Ad3() {

      $this->option_ad_name = self::OPTION_AD_NAME;
      $this->option_append_type = self::OPTION_APPEND_TYPE;
      $this->option_paragraph_number = self::OPTION_PARAGRAPH_NUMBER;
      $this->option_paragraph_number_minimum = self::OPTION_PARAGRAPH_NUMBER_MINIMUM;
      $this->option_excerpt_number = self::OPTION_EXCERPT_NUMBER;
      $this->option_direction_type = self::OPTION_DIRECTION_TYPE;
      $this->option_float_type = self::OPTION_FLOAT_TYPE;
      $this->option_ad_data = self::OPTION_AD_DATA;
      $this->option_ad_general_tag = self::OPTION_AD_GENERAL_TAG;
      $this->option_ad_after_day = self::OPTION_AD_AFTER_DAY;
      $this->option_ad_domain_list           = self::OPTION_AD_DOMAIN_LIST;
      $this->option_ad_domain_list_type      = self::OPTION_AD_DOMAIN_LIST_TYPE;
      $this->option_ad_category_list         = self::OPTION_AD_CATEGORY_LIST;
      $this->option_ad_category_list_type    = self::OPTION_AD_CATEGORY_LIST_TYPE;
      $this->option_widget_settings_home     = self::OPTION_WIDGET_SETTINGS_HOME;
      $this->option_widget_settings_page     = self::OPTION_WIDGET_SETTINGS_PAGE;
      $this->option_widget_settings_post     = self::OPTION_WIDGET_SETTINGS_POST;
      $this->option_widget_settings_category = self::OPTION_WIDGET_SETTINGS_CATEGORY;
      $this->option_widget_settings_search   = self::OPTION_WIDGET_SETTINGS_SEARCH ;
      $this->option_widget_settings_archive  = self::OPTION_WIDGET_SETTINGS_ARCHIVE;
      $this->option_process_php              = self::OPTION_PROCESS_PHP;
      $this->option_enable_manual            = self::OPTION_ENABLE_MANUAL;
      $this->option_enable_php_call          = self::OPTION_ENABLE_PHP_CALL;

      parent::BaseAdInserter();
      $this->number = 3;
      $this->wp_options[$this->option_ad_name] = AD_NAME." 3";
    }

}

class Ad4 extends BaseAdInserter{

   const OPTION_AD_NAME = "ad4_name";
   const OPTION_APPEND_TYPE = "ad4_displayType";
   const OPTION_PARAGRAPH_NUMBER = "ad4_paragraphNumber";
   const OPTION_PARAGRAPH_NUMBER_MINIMUM = "ad4_minimum_paragraphs";
   const OPTION_EXCERPT_NUMBER = "ad4_excerptNumber";
   const OPTION_DIRECTION_TYPE = "ad4_directionType";
   const OPTION_FLOAT_TYPE = "ad4_floatType";
   const OPTION_AD_DATA = "ad4_data";
   const OPTION_AD_GENERAL_TAG = "ad4_general_tag";
   const OPTION_AD_AFTER_DAY = "ad4_after_day";
   const OPTION_AD_DOMAIN_LIST = "ad4_block_user";
   const OPTION_AD_DOMAIN_LIST_TYPE = "ad4_domain_list_type";
   const OPTION_AD_CATEGORY_LIST = "ad4_block_cat";
   const OPTION_AD_CATEGORY_LIST_TYPE = "ad4_block_cat_type";
   const OPTION_WIDGET_SETTINGS_HOME     = "ad4_widget_settings_home";
   const OPTION_WIDGET_SETTINGS_PAGE     = "ad4_widget_settings_page";
   const OPTION_WIDGET_SETTINGS_POST     = "ad4_widget_settings_post";
   const OPTION_WIDGET_SETTINGS_CATEGORY = "ad4_widget_settings_category";
   const OPTION_WIDGET_SETTINGS_SEARCH   = "ad4_widget_settings_search";
   const OPTION_WIDGET_SETTINGS_ARCHIVE  = "ad4_widget_settings_archive";
   const OPTION_PROCESS_PHP              = "ad4_process_php";
   const OPTION_ENABLE_MANUAL            = "ad4_enable_manual";
   const OPTION_ENABLE_PHP_CALL          = "ad4_enable_php_call";

	//constructor
    public function Ad4() {

      $this->option_ad_name = self::OPTION_AD_NAME;
      $this->option_append_type = self::OPTION_APPEND_TYPE;
      $this->option_paragraph_number = self::OPTION_PARAGRAPH_NUMBER;
      $this->option_paragraph_number_minimum = self::OPTION_PARAGRAPH_NUMBER_MINIMUM;
      $this->option_excerpt_number = self::OPTION_EXCERPT_NUMBER;
      $this->option_direction_type = self::OPTION_DIRECTION_TYPE;
      $this->option_float_type = self::OPTION_FLOAT_TYPE;
      $this->option_ad_data = self::OPTION_AD_DATA;
      $this->option_ad_general_tag = self::OPTION_AD_GENERAL_TAG;
      $this->option_ad_after_day = self::OPTION_AD_AFTER_DAY;
      $this->option_ad_domain_list           = self::OPTION_AD_DOMAIN_LIST;
      $this->option_ad_domain_list_type      = self::OPTION_AD_DOMAIN_LIST_TYPE;
      $this->option_ad_category_list         = self::OPTION_AD_CATEGORY_LIST;
      $this->option_ad_category_list_type    = self::OPTION_AD_CATEGORY_LIST_TYPE;
      $this->option_widget_settings_home     = self::OPTION_WIDGET_SETTINGS_HOME;
      $this->option_widget_settings_page     = self::OPTION_WIDGET_SETTINGS_PAGE;
      $this->option_widget_settings_post     = self::OPTION_WIDGET_SETTINGS_POST;
      $this->option_widget_settings_category = self::OPTION_WIDGET_SETTINGS_CATEGORY;
      $this->option_widget_settings_search   = self::OPTION_WIDGET_SETTINGS_SEARCH ;
      $this->option_widget_settings_archive  = self::OPTION_WIDGET_SETTINGS_ARCHIVE;
      $this->option_process_php              = self::OPTION_PROCESS_PHP;
      $this->option_enable_manual            = self::OPTION_ENABLE_MANUAL;
      $this->option_enable_php_call          = self::OPTION_ENABLE_PHP_CALL;

      parent::BaseAdInserter();
      $this->number = 4;
      $this->wp_options[$this->option_ad_name] = AD_NAME." 4";
    }

}

class Ad5 extends BaseAdInserter{

   const OPTION_AD_NAME = "ad5_name";
   const OPTION_APPEND_TYPE = "ad5_displayType";
   const OPTION_PARAGRAPH_NUMBER = "ad5_paragraphNumber";
   const OPTION_PARAGRAPH_NUMBER_MINIMUM = "ad5_minimum_paragraphs";
   const OPTION_EXCERPT_NUMBER = "ad5_excerptNumber";
   const OPTION_DIRECTION_TYPE = "ad5_directionType";
   const OPTION_FLOAT_TYPE = "ad5_floatType";
   const OPTION_AD_DATA = "ad5_data";
   const OPTION_AD_GENERAL_TAG = "ad5_general_tag";
   const OPTION_AD_AFTER_DAY = "ad5_after_day";
   const OPTION_AD_DOMAIN_LIST = "ad5_block_user";
   const OPTION_AD_DOMAIN_LIST_TYPE = "ad5_domain_list_type";
   const OPTION_AD_CATEGORY_LIST = "ad5_block_cat";
   const OPTION_AD_CATEGORY_LIST_TYPE = "ad5_block_cat_type";
   const OPTION_WIDGET_SETTINGS_HOME     = "ad5_widget_settings_home";
   const OPTION_WIDGET_SETTINGS_PAGE     = "ad5_widget_settings_page";
   const OPTION_WIDGET_SETTINGS_POST     = "ad5_widget_settings_post";
   const OPTION_WIDGET_SETTINGS_CATEGORY = "ad5_widget_settings_category";
   const OPTION_WIDGET_SETTINGS_SEARCH   = "ad5_widget_settings_search";
   const OPTION_WIDGET_SETTINGS_ARCHIVE  = "ad5_widget_settings_archive";
   const OPTION_PROCESS_PHP              = "ad5_process_php";
   const OPTION_ENABLE_MANUAL            = "ad5_enable_manual";
   const OPTION_ENABLE_PHP_CALL          = "ad5_enable_php_call";

  //constructor
    public function Ad5() {

      $this->option_ad_name = self::OPTION_AD_NAME;
      $this->option_append_type = self::OPTION_APPEND_TYPE;
      $this->option_paragraph_number = self::OPTION_PARAGRAPH_NUMBER;
      $this->option_paragraph_number_minimum = self::OPTION_PARAGRAPH_NUMBER_MINIMUM;
      $this->option_excerpt_number = self::OPTION_EXCERPT_NUMBER;
      $this->option_direction_type = self::OPTION_DIRECTION_TYPE;
      $this->option_float_type = self::OPTION_FLOAT_TYPE;
      $this->option_ad_data = self::OPTION_AD_DATA;
      $this->option_ad_general_tag = self::OPTION_AD_GENERAL_TAG;
      $this->option_ad_after_day = self::OPTION_AD_AFTER_DAY;
      $this->option_ad_domain_list           = self::OPTION_AD_DOMAIN_LIST;
      $this->option_ad_domain_list_type      = self::OPTION_AD_DOMAIN_LIST_TYPE;
      $this->option_ad_category_list         = self::OPTION_AD_CATEGORY_LIST;
      $this->option_ad_category_list_type    = self::OPTION_AD_CATEGORY_LIST_TYPE;
      $this->option_widget_settings_home     = self::OPTION_WIDGET_SETTINGS_HOME;
      $this->option_widget_settings_page     = self::OPTION_WIDGET_SETTINGS_PAGE;
      $this->option_widget_settings_post     = self::OPTION_WIDGET_SETTINGS_POST;
      $this->option_widget_settings_category = self::OPTION_WIDGET_SETTINGS_CATEGORY;
      $this->option_widget_settings_search   = self::OPTION_WIDGET_SETTINGS_SEARCH ;
      $this->option_widget_settings_archive  = self::OPTION_WIDGET_SETTINGS_ARCHIVE;
      $this->option_process_php              = self::OPTION_PROCESS_PHP;
      $this->option_enable_manual            = self::OPTION_ENABLE_MANUAL;
      $this->option_enable_php_call          = self::OPTION_ENABLE_PHP_CALL;

      parent::BaseAdInserter();
      $this->number = 5;
      $this->wp_options[$this->option_ad_name] = AD_NAME." 5";
    }

}

class Ad6 extends BaseAdInserter{

   const OPTION_AD_NAME = "ad6_name";
   const OPTION_APPEND_TYPE = "ad6_displayType";
   const OPTION_PARAGRAPH_NUMBER = "ad6_paragraphNumber";
   const OPTION_PARAGRAPH_NUMBER_MINIMUM = "ad6_minimum_paragraphs";
   const OPTION_EXCERPT_NUMBER = "ad6_excerptNumber";
   const OPTION_DIRECTION_TYPE = "ad6_directionType";
   const OPTION_FLOAT_TYPE = "ad6_floatType";
   const OPTION_AD_DATA = "ad6_data";
   const OPTION_AD_GENERAL_TAG = "ad6_general_tag";
   const OPTION_AD_AFTER_DAY = "ad6_after_day";
   const OPTION_AD_DOMAIN_LIST = "ad6_block_user";
   const OPTION_AD_DOMAIN_LIST_TYPE = "ad6_domain_list_type";
   const OPTION_AD_CATEGORY_LIST = "ad6_block_cat";
   const OPTION_AD_CATEGORY_LIST_TYPE = "ad6_block_cat_type";
   const OPTION_WIDGET_SETTINGS_HOME     = "ad6_widget_settings_home";
   const OPTION_WIDGET_SETTINGS_PAGE     = "ad6_widget_settings_page";
   const OPTION_WIDGET_SETTINGS_POST     = "ad6_widget_settings_post";
   const OPTION_WIDGET_SETTINGS_CATEGORY = "ad6_widget_settings_category";
   const OPTION_WIDGET_SETTINGS_SEARCH   = "ad6_widget_settings_search";
   const OPTION_WIDGET_SETTINGS_ARCHIVE  = "ad6_widget_settings_archive";
   const OPTION_PROCESS_PHP              = "ad6_process_php";
   const OPTION_ENABLE_MANUAL            = "ad6_enable_manual";
   const OPTION_ENABLE_PHP_CALL          = "ad6_enable_php_call";

  //constructor
    public function Ad6() {

      $this->option_ad_name = self::OPTION_AD_NAME;
      $this->option_append_type = self::OPTION_APPEND_TYPE;
      $this->option_paragraph_number = self::OPTION_PARAGRAPH_NUMBER;
      $this->option_paragraph_number_minimum = self::OPTION_PARAGRAPH_NUMBER_MINIMUM;
      $this->option_excerpt_number = self::OPTION_EXCERPT_NUMBER;
      $this->option_direction_type = self::OPTION_DIRECTION_TYPE;
      $this->option_float_type = self::OPTION_FLOAT_TYPE;
      $this->option_ad_data = self::OPTION_AD_DATA;
      $this->option_ad_general_tag = self::OPTION_AD_GENERAL_TAG;
      $this->option_ad_after_day = self::OPTION_AD_AFTER_DAY;
      $this->option_ad_domain_list           = self::OPTION_AD_DOMAIN_LIST;
      $this->option_ad_domain_list_type      = self::OPTION_AD_DOMAIN_LIST_TYPE;
      $this->option_ad_category_list         = self::OPTION_AD_CATEGORY_LIST;
      $this->option_ad_category_list_type    = self::OPTION_AD_CATEGORY_LIST_TYPE;
      $this->option_widget_settings_home     = self::OPTION_WIDGET_SETTINGS_HOME;
      $this->option_widget_settings_page     = self::OPTION_WIDGET_SETTINGS_PAGE;
      $this->option_widget_settings_post     = self::OPTION_WIDGET_SETTINGS_POST;
      $this->option_widget_settings_category = self::OPTION_WIDGET_SETTINGS_CATEGORY;
      $this->option_widget_settings_search   = self::OPTION_WIDGET_SETTINGS_SEARCH ;
      $this->option_widget_settings_archive  = self::OPTION_WIDGET_SETTINGS_ARCHIVE;
      $this->option_process_php              = self::OPTION_PROCESS_PHP;
      $this->option_enable_manual            = self::OPTION_ENABLE_MANUAL;
      $this->option_enable_php_call          = self::OPTION_ENABLE_PHP_CALL;

      parent::BaseAdInserter();
      $this->number = 6;
      $this->wp_options[$this->option_ad_name] = AD_NAME." 6";
    }

}

class Ad7 extends BaseAdInserter{

   const OPTION_AD_NAME = "ad7_name";
   const OPTION_APPEND_TYPE = "ad7_displayType";
   const OPTION_PARAGRAPH_NUMBER = "ad7_paragraphNumber";
   const OPTION_PARAGRAPH_NUMBER_MINIMUM = "ad7_minimum_paragraphs";
   const OPTION_EXCERPT_NUMBER = "ad7_excerptNumber";
   const OPTION_DIRECTION_TYPE = "ad7_directionType";
   const OPTION_FLOAT_TYPE = "ad7_floatType";
   const OPTION_AD_DATA = "ad7_data";
   const OPTION_AD_GENERAL_TAG = "ad7_general_tag";
   const OPTION_AD_AFTER_DAY = "ad7_after_day";
   const OPTION_AD_DOMAIN_LIST = "ad7_block_user";
   const OPTION_AD_DOMAIN_LIST_TYPE = "ad7_domain_list_type";
   const OPTION_AD_CATEGORY_LIST = "ad7_block_cat";
   const OPTION_AD_CATEGORY_LIST_TYPE = "ad7_block_cat_type";
   const OPTION_WIDGET_SETTINGS_HOME     = "ad7_widget_settings_home";
   const OPTION_WIDGET_SETTINGS_PAGE     = "ad7_widget_settings_page";
   const OPTION_WIDGET_SETTINGS_POST     = "ad7_widget_settings_post";
   const OPTION_WIDGET_SETTINGS_CATEGORY = "ad7_widget_settings_category";
   const OPTION_WIDGET_SETTINGS_SEARCH   = "ad7_widget_settings_search";
   const OPTION_WIDGET_SETTINGS_ARCHIVE  = "ad7_widget_settings_archive";
   const OPTION_PROCESS_PHP              = "ad7_process_php";
   const OPTION_ENABLE_MANUAL            = "ad7_enable_manual";
   const OPTION_ENABLE_PHP_CALL          = "ad7_enable_php_call";

  //constructor
    public function Ad7() {

      $this->option_ad_name = self::OPTION_AD_NAME;
      $this->option_append_type = self::OPTION_APPEND_TYPE;
      $this->option_paragraph_number = self::OPTION_PARAGRAPH_NUMBER;
      $this->option_paragraph_number_minimum = self::OPTION_PARAGRAPH_NUMBER_MINIMUM;
      $this->option_excerpt_number = self::OPTION_EXCERPT_NUMBER;
      $this->option_direction_type = self::OPTION_DIRECTION_TYPE;
      $this->option_float_type = self::OPTION_FLOAT_TYPE;
      $this->option_ad_data = self::OPTION_AD_DATA;
      $this->option_ad_general_tag = self::OPTION_AD_GENERAL_TAG;
      $this->option_ad_after_day = self::OPTION_AD_AFTER_DAY;
      $this->option_ad_domain_list           = self::OPTION_AD_DOMAIN_LIST;
      $this->option_ad_domain_list_type      = self::OPTION_AD_DOMAIN_LIST_TYPE;
      $this->option_ad_category_list         = self::OPTION_AD_CATEGORY_LIST;
      $this->option_ad_category_list_type    = self::OPTION_AD_CATEGORY_LIST_TYPE;
      $this->option_widget_settings_home     = self::OPTION_WIDGET_SETTINGS_HOME;
      $this->option_widget_settings_page     = self::OPTION_WIDGET_SETTINGS_PAGE;
      $this->option_widget_settings_post     = self::OPTION_WIDGET_SETTINGS_POST;
      $this->option_widget_settings_category = self::OPTION_WIDGET_SETTINGS_CATEGORY;
      $this->option_widget_settings_search   = self::OPTION_WIDGET_SETTINGS_SEARCH ;
      $this->option_widget_settings_archive  = self::OPTION_WIDGET_SETTINGS_ARCHIVE;
      $this->option_process_php              = self::OPTION_PROCESS_PHP;
      $this->option_enable_manual            = self::OPTION_ENABLE_MANUAL;
      $this->option_enable_php_call          = self::OPTION_ENABLE_PHP_CALL;

      parent::BaseAdInserter();
      $this->number = 7;
      $this->wp_options[$this->option_ad_name] = AD_NAME." 7";
    }

}

class Ad8 extends BaseAdInserter{

   const OPTION_AD_NAME = "ad8_name";
   const OPTION_APPEND_TYPE = "ad8_displayType";
   const OPTION_PARAGRAPH_NUMBER = "ad8_paragraphNumber";
   const OPTION_PARAGRAPH_NUMBER_MINIMUM = "ad8_minimum_paragraphs";
   const OPTION_EXCERPT_NUMBER = "ad8_excerptNumber";
   const OPTION_DIRECTION_TYPE = "ad8_directionType";
   const OPTION_FLOAT_TYPE = "ad8_floatType";
   const OPTION_AD_DATA = "ad8_data";
   const OPTION_AD_GENERAL_TAG = "ad8_general_tag";
   const OPTION_AD_AFTER_DAY = "ad8_after_day";
   const OPTION_AD_DOMAIN_LIST = "ad8_block_user";
   const OPTION_AD_DOMAIN_LIST_TYPE = "ad8_domain_list_type";
   const OPTION_AD_CATEGORY_LIST = "ad8_block_cat";
   const OPTION_AD_CATEGORY_LIST_TYPE = "ad8_block_cat_type";
   const OPTION_WIDGET_SETTINGS_HOME     = "ad8_widget_settings_home";
   const OPTION_WIDGET_SETTINGS_PAGE     = "ad8_widget_settings_page";
   const OPTION_WIDGET_SETTINGS_POST     = "ad8_widget_settings_post";
   const OPTION_WIDGET_SETTINGS_CATEGORY = "ad8_widget_settings_category";
   const OPTION_WIDGET_SETTINGS_SEARCH   = "ad8_widget_settings_search";
   const OPTION_WIDGET_SETTINGS_ARCHIVE  = "ad8_widget_settings_archive";
   const OPTION_PROCESS_PHP              = "ad8_process_php";
   const OPTION_ENABLE_MANUAL            = "ad8_enable_manual";
   const OPTION_ENABLE_PHP_CALL          = "ad8_enable_php_call";

  //constructor
    public function Ad8() {

      $this->option_ad_name = self::OPTION_AD_NAME;
      $this->option_append_type = self::OPTION_APPEND_TYPE;
      $this->option_paragraph_number = self::OPTION_PARAGRAPH_NUMBER;
      $this->option_paragraph_number_minimum = self::OPTION_PARAGRAPH_NUMBER_MINIMUM;
      $this->option_excerpt_number = self::OPTION_EXCERPT_NUMBER;
      $this->option_direction_type = self::OPTION_DIRECTION_TYPE;
      $this->option_float_type = self::OPTION_FLOAT_TYPE;
      $this->option_ad_data = self::OPTION_AD_DATA;
      $this->option_ad_general_tag = self::OPTION_AD_GENERAL_TAG;
      $this->option_ad_after_day = self::OPTION_AD_AFTER_DAY;
      $this->option_ad_domain_list           = self::OPTION_AD_DOMAIN_LIST;
      $this->option_ad_domain_list_type      = self::OPTION_AD_DOMAIN_LIST_TYPE;
      $this->option_ad_category_list         = self::OPTION_AD_CATEGORY_LIST;
      $this->option_ad_category_list_type    = self::OPTION_AD_CATEGORY_LIST_TYPE;
      $this->option_widget_settings_home     = self::OPTION_WIDGET_SETTINGS_HOME;
      $this->option_widget_settings_page     = self::OPTION_WIDGET_SETTINGS_PAGE;
      $this->option_widget_settings_post     = self::OPTION_WIDGET_SETTINGS_POST;
      $this->option_widget_settings_category = self::OPTION_WIDGET_SETTINGS_CATEGORY;
      $this->option_widget_settings_search   = self::OPTION_WIDGET_SETTINGS_SEARCH ;
      $this->option_widget_settings_archive  = self::OPTION_WIDGET_SETTINGS_ARCHIVE;
      $this->option_process_php              = self::OPTION_PROCESS_PHP;
      $this->option_enable_manual            = self::OPTION_ENABLE_MANUAL;
      $this->option_enable_php_call          = self::OPTION_ENABLE_PHP_CALL;

      parent::BaseAdInserter();
      $this->number = 8;
      $this->wp_options[$this->option_ad_name] = AD_NAME." 8";
    }

}

class Ad9 extends BaseAdInserter{

   const OPTION_AD_NAME = "ad9_name";
   const OPTION_APPEND_TYPE = "ad9_displayType";
   const OPTION_PARAGRAPH_NUMBER = "ad9_paragraphNumber";
   const OPTION_PARAGRAPH_NUMBER_MINIMUM = "ad9_minimum_paragraphs";
   const OPTION_EXCERPT_NUMBER = "ad9_excerptNumber";
   const OPTION_DIRECTION_TYPE = "ad9_directionType";
   const OPTION_FLOAT_TYPE = "ad9_floatType";
   const OPTION_AD_DATA = "ad9_data";
   const OPTION_AD_GENERAL_TAG = "ad9_general_tag";
   const OPTION_AD_AFTER_DAY = "ad9_after_day";
   const OPTION_AD_DOMAIN_LIST = "ad9_block_user";
   const OPTION_AD_DOMAIN_LIST_TYPE = "ad9_domain_list_type";
   const OPTION_AD_CATEGORY_LIST = "ad9_block_cat";
   const OPTION_AD_CATEGORY_LIST_TYPE = "ad9_block_cat_type";
   const OPTION_WIDGET_SETTINGS_HOME     = "ad9_widget_settings_home";
   const OPTION_WIDGET_SETTINGS_PAGE     = "ad9_widget_settings_page";
   const OPTION_WIDGET_SETTINGS_POST     = "ad9_widget_settings_post";
   const OPTION_WIDGET_SETTINGS_CATEGORY = "ad9_widget_settings_category";
   const OPTION_WIDGET_SETTINGS_SEARCH   = "ad9_widget_settings_search";
   const OPTION_WIDGET_SETTINGS_ARCHIVE  = "ad9_widget_settings_archive";
   const OPTION_PROCESS_PHP              = "ad9_process_php";
   const OPTION_ENABLE_MANUAL            = "ad9_enable_manual";
   const OPTION_ENABLE_PHP_CALL          = "ad9_enable_php_call";

  //constructor
    public function Ad9() {

      $this->option_ad_name = self::OPTION_AD_NAME;
      $this->option_append_type = self::OPTION_APPEND_TYPE;
      $this->option_paragraph_number = self::OPTION_PARAGRAPH_NUMBER;
      $this->option_paragraph_number_minimum = self::OPTION_PARAGRAPH_NUMBER_MINIMUM;
      $this->option_excerpt_number = self::OPTION_EXCERPT_NUMBER;
      $this->option_direction_type = self::OPTION_DIRECTION_TYPE;
      $this->option_float_type = self::OPTION_FLOAT_TYPE;
      $this->option_ad_data = self::OPTION_AD_DATA;
      $this->option_ad_general_tag = self::OPTION_AD_GENERAL_TAG;
      $this->option_ad_after_day = self::OPTION_AD_AFTER_DAY;
      $this->option_ad_domain_list           = self::OPTION_AD_DOMAIN_LIST;
      $this->option_ad_domain_list_type      = self::OPTION_AD_DOMAIN_LIST_TYPE;
      $this->option_ad_category_list         = self::OPTION_AD_CATEGORY_LIST;
      $this->option_ad_category_list_type    = self::OPTION_AD_CATEGORY_LIST_TYPE;
      $this->option_widget_settings_home     = self::OPTION_WIDGET_SETTINGS_HOME;
      $this->option_widget_settings_page     = self::OPTION_WIDGET_SETTINGS_PAGE;
      $this->option_widget_settings_post     = self::OPTION_WIDGET_SETTINGS_POST;
      $this->option_widget_settings_category = self::OPTION_WIDGET_SETTINGS_CATEGORY;
      $this->option_widget_settings_search   = self::OPTION_WIDGET_SETTINGS_SEARCH ;
      $this->option_widget_settings_archive  = self::OPTION_WIDGET_SETTINGS_ARCHIVE;
      $this->option_process_php              = self::OPTION_PROCESS_PHP;
      $this->option_enable_manual            = self::OPTION_ENABLE_MANUAL;
      $this->option_enable_php_call          = self::OPTION_ENABLE_PHP_CALL;

      parent::BaseAdInserter();
      $this->number = 9;
      $this->wp_options[$this->option_ad_name] = AD_NAME." 9";
    }

}

class Ad10 extends BaseAdInserter{

   const OPTION_AD_NAME = "ad10_name";
   const OPTION_APPEND_TYPE = "ad10_displayType";
   const OPTION_PARAGRAPH_NUMBER = "ad10_paragraphNumber";
   const OPTION_PARAGRAPH_NUMBER_MINIMUM = "ad10_minimum_paragraphs";
   const OPTION_EXCERPT_NUMBER = "ad10_excerptNumber";
   const OPTION_DIRECTION_TYPE = "ad10_directionType";
   const OPTION_FLOAT_TYPE = "ad10_floatType";
   const OPTION_AD_DATA = "ad10_data";
   const OPTION_AD_GENERAL_TAG = "ad10_general_tag";
   const OPTION_AD_AFTER_DAY = "ad10_after_day";
   const OPTION_AD_DOMAIN_LIST = "ad10_block_user";
   const OPTION_AD_DOMAIN_LIST_TYPE = "ad10_domain_list_type";
   const OPTION_AD_CATEGORY_LIST = "ad10_block_cat";
   const OPTION_AD_CATEGORY_LIST_TYPE = "ad10_block_cat_type";
   const OPTION_WIDGET_SETTINGS_HOME     = "ad10_widget_settings_home";
   const OPTION_WIDGET_SETTINGS_PAGE     = "ad10_widget_settings_page";
   const OPTION_WIDGET_SETTINGS_POST     = "ad10_widget_settings_post";
   const OPTION_WIDGET_SETTINGS_CATEGORY = "ad10_widget_settings_category";
   const OPTION_WIDGET_SETTINGS_SEARCH   = "ad10_widget_settings_search";
   const OPTION_WIDGET_SETTINGS_ARCHIVE  = "ad10_widget_settings_archive";
   const OPTION_PROCESS_PHP              = "ad10_process_php";
   const OPTION_ENABLE_MANUAL            = "ad10_enable_manual";
   const OPTION_ENABLE_PHP_CALL          = "ad10_enable_php_call";

  //constructor
    public function Ad10() {

      $this->option_ad_name = self::OPTION_AD_NAME;
      $this->option_append_type = self::OPTION_APPEND_TYPE;
      $this->option_paragraph_number = self::OPTION_PARAGRAPH_NUMBER;
      $this->option_paragraph_number_minimum = self::OPTION_PARAGRAPH_NUMBER_MINIMUM;
      $this->option_excerpt_number = self::OPTION_EXCERPT_NUMBER;
      $this->option_direction_type = self::OPTION_DIRECTION_TYPE;
      $this->option_float_type = self::OPTION_FLOAT_TYPE;
      $this->option_ad_data = self::OPTION_AD_DATA;
      $this->option_ad_general_tag = self::OPTION_AD_GENERAL_TAG;
      $this->option_ad_after_day = self::OPTION_AD_AFTER_DAY;
      $this->option_ad_domain_list           = self::OPTION_AD_DOMAIN_LIST;
      $this->option_ad_domain_list_type      = self::OPTION_AD_DOMAIN_LIST_TYPE;
      $this->option_ad_category_list         = self::OPTION_AD_CATEGORY_LIST;
      $this->option_ad_category_list_type    = self::OPTION_AD_CATEGORY_LIST_TYPE;
      $this->option_widget_settings_home     = self::OPTION_WIDGET_SETTINGS_HOME;
      $this->option_widget_settings_page     = self::OPTION_WIDGET_SETTINGS_PAGE;
      $this->option_widget_settings_post     = self::OPTION_WIDGET_SETTINGS_POST;
      $this->option_widget_settings_category = self::OPTION_WIDGET_SETTINGS_CATEGORY;
      $this->option_widget_settings_search   = self::OPTION_WIDGET_SETTINGS_SEARCH ;
      $this->option_widget_settings_archive  = self::OPTION_WIDGET_SETTINGS_ARCHIVE;
      $this->option_process_php              = self::OPTION_PROCESS_PHP;
      $this->option_enable_manual            = self::OPTION_ENABLE_MANUAL;
      $this->option_enable_php_call          = self::OPTION_ENABLE_PHP_CALL;

      parent::BaseAdInserter();
      $this->number = 10;
      $this->wp_options[$this->option_ad_name] = AD_NAME." 10";
    }

}

class Ad11 extends BaseAdInserter{

   const OPTION_AD_NAME = "ad11_name";
   const OPTION_APPEND_TYPE = "ad11_displayType";
   const OPTION_PARAGRAPH_NUMBER = "ad11_paragraphNumber";
   const OPTION_PARAGRAPH_NUMBER_MINIMUM = "ad11_minimum_paragraphs";
   const OPTION_EXCERPT_NUMBER = "ad11_excerptNumber";
   const OPTION_DIRECTION_TYPE = "ad11_directionType";
   const OPTION_FLOAT_TYPE = "ad11_floatType";
   const OPTION_AD_DATA = "ad11_data";
   const OPTION_AD_GENERAL_TAG = "ad11_general_tag";
   const OPTION_AD_AFTER_DAY = "ad11_after_day";
   const OPTION_AD_DOMAIN_LIST = "ad11_block_user";
   const OPTION_AD_DOMAIN_LIST_TYPE = "ad11_domain_list_type";
   const OPTION_AD_CATEGORY_LIST = "ad11_block_cat";
   const OPTION_AD_CATEGORY_LIST_TYPE = "ad11_block_cat_type";
   const OPTION_WIDGET_SETTINGS_HOME     = "ad11_widget_settings_home";
   const OPTION_WIDGET_SETTINGS_PAGE     = "ad11_widget_settings_page";
   const OPTION_WIDGET_SETTINGS_POST     = "ad11_widget_settings_post";
   const OPTION_WIDGET_SETTINGS_CATEGORY = "ad11_widget_settings_category";
   const OPTION_WIDGET_SETTINGS_SEARCH   = "ad11_widget_settings_search";
   const OPTION_WIDGET_SETTINGS_ARCHIVE  = "ad11_widget_settings_archive";
   const OPTION_PROCESS_PHP              = "ad11_process_php";
   const OPTION_ENABLE_MANUAL            = "ad11_enable_manual";
   const OPTION_ENABLE_PHP_CALL          = "ad11_enable_php_call";

  //constructor
    public function Ad11() {

      $this->option_ad_name = self::OPTION_AD_NAME;
      $this->option_append_type = self::OPTION_APPEND_TYPE;
      $this->option_paragraph_number = self::OPTION_PARAGRAPH_NUMBER;
      $this->option_paragraph_number_minimum = self::OPTION_PARAGRAPH_NUMBER_MINIMUM;
      $this->option_excerpt_number = self::OPTION_EXCERPT_NUMBER;
      $this->option_direction_type = self::OPTION_DIRECTION_TYPE;
      $this->option_float_type = self::OPTION_FLOAT_TYPE;
      $this->option_ad_data = self::OPTION_AD_DATA;
      $this->option_ad_general_tag = self::OPTION_AD_GENERAL_TAG;
      $this->option_ad_after_day = self::OPTION_AD_AFTER_DAY;
      $this->option_ad_domain_list           = self::OPTION_AD_DOMAIN_LIST;
      $this->option_ad_domain_list_type      = self::OPTION_AD_DOMAIN_LIST_TYPE;
      $this->option_ad_category_list         = self::OPTION_AD_CATEGORY_LIST;
      $this->option_ad_category_list_type    = self::OPTION_AD_CATEGORY_LIST_TYPE;
      $this->option_widget_settings_home     = self::OPTION_WIDGET_SETTINGS_HOME;
      $this->option_widget_settings_page     = self::OPTION_WIDGET_SETTINGS_PAGE;
      $this->option_widget_settings_post     = self::OPTION_WIDGET_SETTINGS_POST;
      $this->option_widget_settings_category = self::OPTION_WIDGET_SETTINGS_CATEGORY;
      $this->option_widget_settings_search   = self::OPTION_WIDGET_SETTINGS_SEARCH ;
      $this->option_widget_settings_archive  = self::OPTION_WIDGET_SETTINGS_ARCHIVE;
      $this->option_process_php              = self::OPTION_PROCESS_PHP;
      $this->option_enable_manual            = self::OPTION_ENABLE_MANUAL;
      $this->option_enable_php_call          = self::OPTION_ENABLE_PHP_CALL;

      parent::BaseAdInserter();
      $this->number = 11;
      $this->wp_options[$this->option_ad_name] = AD_NAME." 11";
    }

}

class Ad12 extends BaseAdInserter{

   const OPTION_AD_NAME = "ad12_name";
   const OPTION_APPEND_TYPE = "ad12_displayType";
   const OPTION_PARAGRAPH_NUMBER = "ad12_paragraphNumber";
   const OPTION_PARAGRAPH_NUMBER_MINIMUM = "ad12_minimum_paragraphs";
   const OPTION_EXCERPT_NUMBER = "ad12_excerptNumber";
   const OPTION_DIRECTION_TYPE = "ad12_directionType";
   const OPTION_FLOAT_TYPE = "ad12_floatType";
   const OPTION_AD_DATA = "ad12_data";
   const OPTION_AD_GENERAL_TAG = "ad12_general_tag";
   const OPTION_AD_AFTER_DAY = "ad12_after_day";
   const OPTION_AD_DOMAIN_LIST = "ad12_block_user";
   const OPTION_AD_DOMAIN_LIST_TYPE = "ad12_domain_list_type";
   const OPTION_AD_CATEGORY_LIST = "ad12_block_cat";
   const OPTION_AD_CATEGORY_LIST_TYPE = "ad12_block_cat_type";
   const OPTION_WIDGET_SETTINGS_HOME     = "ad12_widget_settings_home";
   const OPTION_WIDGET_SETTINGS_PAGE     = "ad12_widget_settings_page";
   const OPTION_WIDGET_SETTINGS_POST     = "ad12_widget_settings_post";
   const OPTION_WIDGET_SETTINGS_CATEGORY = "ad12_widget_settings_category";
   const OPTION_WIDGET_SETTINGS_SEARCH   = "ad12_widget_settings_search";
   const OPTION_WIDGET_SETTINGS_ARCHIVE  = "ad12_widget_settings_archive";
   const OPTION_PROCESS_PHP              = "ad12_process_php";
   const OPTION_ENABLE_MANUAL            = "ad12_enable_manual";
   const OPTION_ENABLE_PHP_CALL          = "ad12_enable_php_call";

  //constructor
    public function Ad12() {

      $this->option_ad_name = self::OPTION_AD_NAME;
      $this->option_append_type = self::OPTION_APPEND_TYPE;
      $this->option_paragraph_number = self::OPTION_PARAGRAPH_NUMBER;
      $this->option_paragraph_number_minimum = self::OPTION_PARAGRAPH_NUMBER_MINIMUM;
      $this->option_excerpt_number = self::OPTION_EXCERPT_NUMBER;
      $this->option_direction_type = self::OPTION_DIRECTION_TYPE;
      $this->option_float_type = self::OPTION_FLOAT_TYPE;
      $this->option_ad_data = self::OPTION_AD_DATA;
      $this->option_ad_general_tag = self::OPTION_AD_GENERAL_TAG;
      $this->option_ad_after_day = self::OPTION_AD_AFTER_DAY;
      $this->option_ad_domain_list           = self::OPTION_AD_DOMAIN_LIST;
      $this->option_ad_domain_list_type      = self::OPTION_AD_DOMAIN_LIST_TYPE;
      $this->option_ad_category_list         = self::OPTION_AD_CATEGORY_LIST;
      $this->option_ad_category_list_type    = self::OPTION_AD_CATEGORY_LIST_TYPE;
      $this->option_widget_settings_home     = self::OPTION_WIDGET_SETTINGS_HOME;
      $this->option_widget_settings_page     = self::OPTION_WIDGET_SETTINGS_PAGE;
      $this->option_widget_settings_post     = self::OPTION_WIDGET_SETTINGS_POST;
      $this->option_widget_settings_category = self::OPTION_WIDGET_SETTINGS_CATEGORY;
      $this->option_widget_settings_search   = self::OPTION_WIDGET_SETTINGS_SEARCH ;
      $this->option_widget_settings_archive  = self::OPTION_WIDGET_SETTINGS_ARCHIVE;
      $this->option_process_php              = self::OPTION_PROCESS_PHP;
      $this->option_enable_manual            = self::OPTION_ENABLE_MANUAL;
      $this->option_enable_php_call          = self::OPTION_ENABLE_PHP_CALL;

      parent::BaseAdInserter();
      $this->number = 12;
      $this->wp_options[$this->option_ad_name] = AD_NAME." 12";
    }

}

class Ad13 extends BaseAdInserter{

   const OPTION_AD_NAME = "ad13_name";
   const OPTION_APPEND_TYPE = "ad13_displayType";
   const OPTION_PARAGRAPH_NUMBER = "ad13_paragraphNumber";
   const OPTION_PARAGRAPH_NUMBER_MINIMUM = "ad13_minimum_paragraphs";
   const OPTION_EXCERPT_NUMBER = "ad13_excerptNumber";
   const OPTION_DIRECTION_TYPE = "ad13_directionType";
   const OPTION_FLOAT_TYPE = "ad13_floatType";
   const OPTION_AD_DATA = "ad13_data";
   const OPTION_AD_GENERAL_TAG = "ad13_general_tag";
   const OPTION_AD_AFTER_DAY = "ad13_after_day";
   const OPTION_AD_DOMAIN_LIST = "ad13_block_user";
   const OPTION_AD_DOMAIN_LIST_TYPE = "ad13_domain_list_type";
   const OPTION_AD_CATEGORY_LIST = "ad13_block_cat";
   const OPTION_AD_CATEGORY_LIST_TYPE = "ad13_block_cat_type";
   const OPTION_WIDGET_SETTINGS_HOME     = "ad13_widget_settings_home";
   const OPTION_WIDGET_SETTINGS_PAGE     = "ad13_widget_settings_page";
   const OPTION_WIDGET_SETTINGS_POST     = "ad13_widget_settings_post";
   const OPTION_WIDGET_SETTINGS_CATEGORY = "ad13_widget_settings_category";
   const OPTION_WIDGET_SETTINGS_SEARCH   = "ad13_widget_settings_search";
   const OPTION_WIDGET_SETTINGS_ARCHIVE  = "ad13_widget_settings_archive";
   const OPTION_PROCESS_PHP              = "ad13_process_php";
   const OPTION_ENABLE_MANUAL            = "ad13_enable_manual";
   const OPTION_ENABLE_PHP_CALL          = "ad13_enable_php_call";

  //constructor
    public function Ad13() {

      $this->option_ad_name = self::OPTION_AD_NAME;
      $this->option_append_type = self::OPTION_APPEND_TYPE;
      $this->option_paragraph_number = self::OPTION_PARAGRAPH_NUMBER;
      $this->option_paragraph_number_minimum = self::OPTION_PARAGRAPH_NUMBER_MINIMUM;
      $this->option_excerpt_number = self::OPTION_EXCERPT_NUMBER;
      $this->option_direction_type = self::OPTION_DIRECTION_TYPE;
      $this->option_float_type = self::OPTION_FLOAT_TYPE;
      $this->option_ad_data = self::OPTION_AD_DATA;
      $this->option_ad_general_tag = self::OPTION_AD_GENERAL_TAG;
      $this->option_ad_after_day = self::OPTION_AD_AFTER_DAY;
      $this->option_ad_domain_list           = self::OPTION_AD_DOMAIN_LIST;
      $this->option_ad_domain_list_type      = self::OPTION_AD_DOMAIN_LIST_TYPE;
      $this->option_ad_category_list         = self::OPTION_AD_CATEGORY_LIST;
      $this->option_ad_category_list_type    = self::OPTION_AD_CATEGORY_LIST_TYPE;
      $this->option_widget_settings_home     = self::OPTION_WIDGET_SETTINGS_HOME;
      $this->option_widget_settings_page     = self::OPTION_WIDGET_SETTINGS_PAGE;
      $this->option_widget_settings_post     = self::OPTION_WIDGET_SETTINGS_POST;
      $this->option_widget_settings_category = self::OPTION_WIDGET_SETTINGS_CATEGORY;
      $this->option_widget_settings_search   = self::OPTION_WIDGET_SETTINGS_SEARCH ;
      $this->option_widget_settings_archive  = self::OPTION_WIDGET_SETTINGS_ARCHIVE;
      $this->option_process_php              = self::OPTION_PROCESS_PHP;
      $this->option_enable_manual            = self::OPTION_ENABLE_MANUAL;
      $this->option_enable_php_call          = self::OPTION_ENABLE_PHP_CALL;

      parent::BaseAdInserter();
      $this->number = 13;
      $this->wp_options[$this->option_ad_name] = AD_NAME." 13";
    }

}

class Ad14 extends BaseAdInserter{

   const OPTION_AD_NAME = "ad14_name";
   const OPTION_APPEND_TYPE = "ad14_displayType";
   const OPTION_PARAGRAPH_NUMBER = "ad14_paragraphNumber";
   const OPTION_PARAGRAPH_NUMBER_MINIMUM = "ad14_minimum_paragraphs";
   const OPTION_EXCERPT_NUMBER = "ad14_excerptNumber";
   const OPTION_DIRECTION_TYPE = "ad14_directionType";
   const OPTION_FLOAT_TYPE = "ad14_floatType";
   const OPTION_AD_DATA = "ad14_data";
   const OPTION_AD_GENERAL_TAG = "ad14_general_tag";
   const OPTION_AD_AFTER_DAY = "ad14_after_day";
   const OPTION_AD_DOMAIN_LIST = "ad14_block_user";
   const OPTION_AD_DOMAIN_LIST_TYPE = "ad14_domain_list_type";
   const OPTION_AD_CATEGORY_LIST = "ad14_block_cat";
   const OPTION_AD_CATEGORY_LIST_TYPE = "ad14_block_cat_type";
   const OPTION_WIDGET_SETTINGS_HOME     = "ad14_widget_settings_home";
   const OPTION_WIDGET_SETTINGS_PAGE     = "ad14_widget_settings_page";
   const OPTION_WIDGET_SETTINGS_POST     = "ad14_widget_settings_post";
   const OPTION_WIDGET_SETTINGS_CATEGORY = "ad14_widget_settings_category";
   const OPTION_WIDGET_SETTINGS_SEARCH   = "ad14_widget_settings_search";
   const OPTION_WIDGET_SETTINGS_ARCHIVE  = "ad14_widget_settings_archive";
   const OPTION_PROCESS_PHP              = "ad14_process_php";
   const OPTION_ENABLE_MANUAL            = "ad14_enable_manual";
   const OPTION_ENABLE_PHP_CALL          = "ad14_enable_php_call";

  //constructor
    public function Ad14() {

      $this->option_ad_name = self::OPTION_AD_NAME;
      $this->option_append_type = self::OPTION_APPEND_TYPE;
      $this->option_paragraph_number = self::OPTION_PARAGRAPH_NUMBER;
      $this->option_paragraph_number_minimum = self::OPTION_PARAGRAPH_NUMBER_MINIMUM;
      $this->option_excerpt_number = self::OPTION_EXCERPT_NUMBER;
      $this->option_direction_type = self::OPTION_DIRECTION_TYPE;
      $this->option_float_type = self::OPTION_FLOAT_TYPE;
      $this->option_ad_data = self::OPTION_AD_DATA;
      $this->option_ad_general_tag = self::OPTION_AD_GENERAL_TAG;
      $this->option_ad_after_day = self::OPTION_AD_AFTER_DAY;
      $this->option_ad_domain_list           = self::OPTION_AD_DOMAIN_LIST;
      $this->option_ad_domain_list_type      = self::OPTION_AD_DOMAIN_LIST_TYPE;
      $this->option_ad_category_list         = self::OPTION_AD_CATEGORY_LIST;
      $this->option_ad_category_list_type    = self::OPTION_AD_CATEGORY_LIST_TYPE;
      $this->option_widget_settings_home     = self::OPTION_WIDGET_SETTINGS_HOME;
      $this->option_widget_settings_page     = self::OPTION_WIDGET_SETTINGS_PAGE;
      $this->option_widget_settings_post     = self::OPTION_WIDGET_SETTINGS_POST;
      $this->option_widget_settings_category = self::OPTION_WIDGET_SETTINGS_CATEGORY;
      $this->option_widget_settings_search   = self::OPTION_WIDGET_SETTINGS_SEARCH ;
      $this->option_widget_settings_archive  = self::OPTION_WIDGET_SETTINGS_ARCHIVE;
      $this->option_process_php              = self::OPTION_PROCESS_PHP;
      $this->option_enable_manual            = self::OPTION_ENABLE_MANUAL;
      $this->option_enable_php_call          = self::OPTION_ENABLE_PHP_CALL;

      parent::BaseAdInserter();
      $this->number = 14;
      $this->wp_options[$this->option_ad_name] = AD_NAME." 14";
    }

}

class Ad15 extends BaseAdInserter{

   const OPTION_AD_NAME = "ad15_name";
   const OPTION_APPEND_TYPE = "ad15_displayType";
   const OPTION_PARAGRAPH_NUMBER = "ad15_paragraphNumber";
   const OPTION_PARAGRAPH_NUMBER_MINIMUM = "ad15_minimum_paragraphs";
   const OPTION_EXCERPT_NUMBER = "ad15_excerptNumber";
   const OPTION_DIRECTION_TYPE = "ad15_directionType";
   const OPTION_FLOAT_TYPE = "ad15_floatType";
   const OPTION_AD_DATA = "ad15_data";
   const OPTION_AD_GENERAL_TAG = "ad15_general_tag";
   const OPTION_AD_AFTER_DAY = "ad15_after_day";
   const OPTION_AD_DOMAIN_LIST = "ad15_block_user";
   const OPTION_AD_DOMAIN_LIST_TYPE = "ad15_domain_list_type";
   const OPTION_AD_CATEGORY_LIST = "ad15_block_cat";
   const OPTION_AD_CATEGORY_LIST_TYPE = "ad15_block_cat_type";
   const OPTION_WIDGET_SETTINGS_HOME     = "ad15_widget_settings_home";
   const OPTION_WIDGET_SETTINGS_PAGE     = "ad15_widget_settings_page";
   const OPTION_WIDGET_SETTINGS_POST     = "ad15_widget_settings_post";
   const OPTION_WIDGET_SETTINGS_CATEGORY = "ad15_widget_settings_category";
   const OPTION_WIDGET_SETTINGS_SEARCH   = "ad15_widget_settings_search";
   const OPTION_WIDGET_SETTINGS_ARCHIVE  = "ad15_widget_settings_archive";
   const OPTION_PROCESS_PHP              = "ad15_process_php";
   const OPTION_ENABLE_MANUAL            = "ad15_enable_manual";
   const OPTION_ENABLE_PHP_CALL          = "ad15_enable_php_call";

  //constructor
    public function Ad15() {

      $this->option_ad_name = self::OPTION_AD_NAME;
      $this->option_append_type = self::OPTION_APPEND_TYPE;
      $this->option_paragraph_number = self::OPTION_PARAGRAPH_NUMBER;
      $this->option_paragraph_number_minimum = self::OPTION_PARAGRAPH_NUMBER_MINIMUM;
      $this->option_excerpt_number = self::OPTION_EXCERPT_NUMBER;
      $this->option_direction_type = self::OPTION_DIRECTION_TYPE;
      $this->option_float_type = self::OPTION_FLOAT_TYPE;
      $this->option_ad_data = self::OPTION_AD_DATA;
      $this->option_ad_general_tag = self::OPTION_AD_GENERAL_TAG;
      $this->option_ad_after_day = self::OPTION_AD_AFTER_DAY;
      $this->option_ad_domain_list           = self::OPTION_AD_DOMAIN_LIST;
      $this->option_ad_domain_list_type      = self::OPTION_AD_DOMAIN_LIST_TYPE;
      $this->option_ad_category_list         = self::OPTION_AD_CATEGORY_LIST;
      $this->option_ad_category_list_type    = self::OPTION_AD_CATEGORY_LIST_TYPE;
      $this->option_widget_settings_home     = self::OPTION_WIDGET_SETTINGS_HOME;
      $this->option_widget_settings_page     = self::OPTION_WIDGET_SETTINGS_PAGE;
      $this->option_widget_settings_post     = self::OPTION_WIDGET_SETTINGS_POST;
      $this->option_widget_settings_category = self::OPTION_WIDGET_SETTINGS_CATEGORY;
      $this->option_widget_settings_search   = self::OPTION_WIDGET_SETTINGS_SEARCH ;
      $this->option_widget_settings_archive  = self::OPTION_WIDGET_SETTINGS_ARCHIVE;
      $this->option_process_php              = self::OPTION_PROCESS_PHP;
      $this->option_enable_manual            = self::OPTION_ENABLE_MANUAL;
      $this->option_enable_php_call          = self::OPTION_ENABLE_PHP_CALL;

      parent::BaseAdInserter();
      $this->number = 15;
      $this->wp_options[$this->option_ad_name] = AD_NAME." 15";
    }

}

class Ad16 extends BaseAdInserter{

   const OPTION_AD_NAME = "ad16_name";
   const OPTION_APPEND_TYPE = "ad16_displayType";
   const OPTION_PARAGRAPH_NUMBER = "ad16_paragraphNumber";
   const OPTION_PARAGRAPH_NUMBER_MINIMUM = "ad16_minimum_paragraphs";
   const OPTION_EXCERPT_NUMBER = "ad16_excerptNumber";
   const OPTION_DIRECTION_TYPE = "ad16_directionType";
   const OPTION_FLOAT_TYPE = "ad16_floatType";
   const OPTION_AD_DATA = "ad16_data";
   const OPTION_AD_GENERAL_TAG = "ad16_general_tag";
   const OPTION_AD_AFTER_DAY = "ad16_after_day";
   const OPTION_AD_DOMAIN_LIST = "ad16_block_user";
   const OPTION_AD_DOMAIN_LIST_TYPE = "ad16_domain_list_type";
   const OPTION_AD_CATEGORY_LIST = "ad16_block_cat";
   const OPTION_AD_CATEGORY_LIST_TYPE = "ad16_block_cat_type";
   const OPTION_WIDGET_SETTINGS_HOME     = "ad16_widget_settings_home";
   const OPTION_WIDGET_SETTINGS_PAGE     = "ad16_widget_settings_page";
   const OPTION_WIDGET_SETTINGS_POST     = "ad16_widget_settings_post";
   const OPTION_WIDGET_SETTINGS_CATEGORY = "ad16_widget_settings_category";
   const OPTION_WIDGET_SETTINGS_SEARCH   = "ad16_widget_settings_search";
   const OPTION_WIDGET_SETTINGS_ARCHIVE  = "ad16_widget_settings_archive";
   const OPTION_PROCESS_PHP              = "ad16_process_php";
   const OPTION_ENABLE_MANUAL            = "ad16_enable_manual";
   const OPTION_ENABLE_PHP_CALL          = "ad16_enable_php_call";

  //constructor
    public function Ad16() {

      $this->option_ad_name = self::OPTION_AD_NAME;
      $this->option_append_type = self::OPTION_APPEND_TYPE;
      $this->option_paragraph_number = self::OPTION_PARAGRAPH_NUMBER;
      $this->option_paragraph_number_minimum = self::OPTION_PARAGRAPH_NUMBER_MINIMUM;
      $this->option_excerpt_number = self::OPTION_EXCERPT_NUMBER;
      $this->option_direction_type = self::OPTION_DIRECTION_TYPE;
      $this->option_float_type = self::OPTION_FLOAT_TYPE;
      $this->option_ad_data = self::OPTION_AD_DATA;
      $this->option_ad_general_tag = self::OPTION_AD_GENERAL_TAG;
      $this->option_ad_after_day = self::OPTION_AD_AFTER_DAY;
      $this->option_ad_domain_list           = self::OPTION_AD_DOMAIN_LIST;
      $this->option_ad_domain_list_type      = self::OPTION_AD_DOMAIN_LIST_TYPE;
      $this->option_ad_category_list         = self::OPTION_AD_CATEGORY_LIST;
      $this->option_ad_category_list_type    = self::OPTION_AD_CATEGORY_LIST_TYPE;
      $this->option_widget_settings_home     = self::OPTION_WIDGET_SETTINGS_HOME;
      $this->option_widget_settings_page     = self::OPTION_WIDGET_SETTINGS_PAGE;
      $this->option_widget_settings_post     = self::OPTION_WIDGET_SETTINGS_POST;
      $this->option_widget_settings_category = self::OPTION_WIDGET_SETTINGS_CATEGORY;
      $this->option_widget_settings_search   = self::OPTION_WIDGET_SETTINGS_SEARCH ;
      $this->option_widget_settings_archive  = self::OPTION_WIDGET_SETTINGS_ARCHIVE;
      $this->option_process_php              = self::OPTION_PROCESS_PHP;
      $this->option_enable_manual            = self::OPTION_ENABLE_MANUAL;
      $this->option_enable_php_call          = self::OPTION_ENABLE_PHP_CALL;

      parent::BaseAdInserter();
      $this->number = 16;
      $this->wp_options[$this->option_ad_name] = AD_NAME." 16";
    }

}
