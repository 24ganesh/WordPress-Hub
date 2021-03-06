<?php
class installerDbUpdaterBup {
	static public function runUpdate() {
		self::update_001();
		self::update_002();
		self::update_003();
	}
	
	static public function update_001() {
		global $wpdb;
		$wpPrefix = $wpdb->prefix;
		
		dbBup::query("INSERT INTO `".$wpPrefix.BUP_DB_PREF."options` (`id`,`code`,`value`,`label`,`description`,`htmltype_id`,`params`,`cat_id`,`sort_order`,`value_type`) VALUES 
			(NULL,'count_folder','','Count folder','Count folder',1,'',0,0,''),
			(NULL,'exclude','upgrade,cache','Exclude','Exclude directories',1,'',0,0,'')
			;");
		dbBup::query("INSERT INTO `".$wpPrefix.BUP_DB_PREF."options` (`id`,`code`,`value`,`label`,`description`,`htmltype_id`,`params`,`cat_id`,`sort_order`,`value_type`) VALUES 
			(NULL,'sch_enable','0','Enable shedule','Enable shedule',1,'',0,0,''),
			(NULL,'sch_every_hour','0','Schedule every hour','Schedule every hour',1,'',0,0,'every'),
			(NULL,'sch_every_day','0','Schedule every day','Schedule every day',1,'',0,0,'every'),
			(NULL,'sch_every_day_twice','0','Schedule every day twice','Schedule every day twice',1,'',0,0,'every'),
			(NULL,'sch_every_week','0','Schedule every week','Schedule every week',1,'',0,0,'every'),
			(NULL,'sch_every_month','0','Schedule every month','Schedule every month',1,'',0,0,'every'),
			(NULL,'sch_time','a:1:{i:1;i:0;}','Schedule time backup','Schedule time backup',1,'',0,0,''),
			(NULL,'sch_dest','1','Destination backup','Destination backup',1,'',0,0,'')
			;");
	}
	
	static public function update_002() {
		global $wpdb;
		$wpPrefix = $wpdb->prefix;
		
		dbBup::query("INSERT INTO `".$wpPrefix.BUP_DB_PREF."modules` (id, code, active, type_id, params, has_tab, label, description) VALUES
		    (NULL, 'promo_ready',1,1,'',0,'Promo ready','')
		  ;");	
	
		dbBup::query("INSERT INTO `".$wpPrefix.BUP_DB_PREF."options` (`id`,`code`,`value`,`label`,`description`,`htmltype_id`,`params`,`cat_id`,`sort_order`,`value_type`) VALUES 
			(NULL,'email','','Email','Email',1,'',0,0,'')
			;");	
	}
	
	static public function update_003() {
		global $wpdb;
		$wpPrefix = $wpdb->prefix;
		
		dbBup::query("INSERT INTO `".$wpPrefix.BUP_DB_PREF."options` (`id`,`code`,`value`,`label`,`description`,`htmltype_id`,`params`,`cat_id`,`sort_order`,`value_type`) VALUES 
			(NULL,'glb_dest','ftp','Manual destination','Manual destination',1,'',0,0,'')");
		dbBup::query("INSERT INTO `".$wpPrefix.BUP_DB_PREF."modules` (id, code, active, type_id, params, has_tab, label, description) VALUES
		    (NULL, 'logger',1,1,'',0,'System logger','')
		  ;");	

		dbBup::query("INSERT INTO `".$wpPrefix.BUP_DB_PREF."options` (`id`,`code`,`value`,`label`,`description`,`htmltype_id`,`params`,`cat_id`,`sort_order`,`value_type`) VALUES 
			(NULL,'force_update','0','Force Update','Force Update',1,'',0,0,'')");

		dbBup::query("INSERT INTO `".$wpPrefix.BUP_DB_PREF."options` (`id`,`code`,`value`,`label`,`description`,`htmltype_id`,`params`,`cat_id`,`sort_order`,`value_type`) VALUES 
			(NULL,'safe_update','1','Safe Update','Safe Update',1,'',0,0,'')");
		

		dbBup::query("INSERT INTO `".$wpPrefix.BUP_DB_PREF."options` (`id`,`code`,`value`,`label`,`description`,`htmltype_id`,`params`,`cat_id`,`sort_order`,`value_type`) VALUES 
			(NULL,'replace_newer','1','Replace Newer','Replace newer files or not',1,'',0,0,'')");
	}
	
}