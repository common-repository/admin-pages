<?php

function bwadminpages_dbcreate() {
	global $bwadminpages_version;
	
	add_option( 'bwadminpages_version', $bwadminpages_version );
	
	global $wpdb;
	
	$table_name = $wpdb->prefix . "bwadminpages"; 
	
	$charset_collate = $wpdb->get_charset_collate();
	
	$sql = "CREATE TABLE $table_name (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  timestamp varchar(30) NOT NULL,
	  page_title varchar(100) NOT NULL,
	  page_content varchar(10000) NOT NULL,
	  menu_position int(10) NOT NULL,
	  menu_icon varchar(100) NOT NULL,
	  menu_capability varchar(100) NOT NULL,
	  page_styles varchar(10000) NOT NULL,
	  UNIQUE KEY id (id)
	) $charset_collate;";
	
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}
?>