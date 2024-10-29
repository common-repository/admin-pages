<?php
/*
 *	Plugin Name: Admin Pages
 *	Plugin URI: http://tech-centralhq.com/
 *	Description: Add pages to your admin area with ease
 *	Version: 1.5
 *	Author: Brendan Wolfe
 *	Author URI: http://tech-centralhq.com
 *	License: GPL2
 *
*/
$bwadminpages_version = '1.5';
/*
* Run when activated
*/
include('inc/bwadminpages-dbcreate.php');
register_activation_hook(__FILE__,'bwadminpages_dbcreate');

/*
* Run on every page load to make sure the database is updated with the plugin
*/
if(!get_option('bwadminpages_version')) {
	add_option( 'bwadminpages_version', $bwadminpages_version );
}
if(get_option('bwadminpages_version') != $bwadminpages_version) {
	//$table_name = $wpdb->prefix . 'bwadminpages';
	//$wpdb->query("ALTER TABLE ".$table_name." ADD page_styles varchar(5000) NOT NULL");
	//update_option('bwadminpages_version', $bwadminpages_version);
}

function mynl2br($page_content) {
	//$page_content = nl2br($page_content);
	$page_content = htmlspecialchars_decode($page_content);
    $page_content = implode("",explode("\\",$page_content));
    $page_content = stripslashes(trim($page_content));
	return $page_content;
}
function menu_capability($menu_capability) {
	if($menu_capability == 'manage_network') {
		$menu_capability = 'Super Admin';
	} elseif($menu_capability == 'activate_plugins') {
		$menu_capability = 'Administator';
	} elseif($menu_capability == 'delete_others_pages') {
		$menu_capability = 'Editor';
	} elseif($menu_capability == 'delete_published_posts') {
		$menu_capability = 'Author';
	} elseif($menu_capability == 'delete_posts') {
		$menu_capability = 'Contributor';
	} elseif($menu_capability == 'read') {
		$menu_capability = 'Subscriber';
	}
	echo $menu_capability;
}

/*
* Add a link to plugin in the admin menu
* under 'Settings > Admin pages'
*/
function bwadminpages_menu() {
	/*
	* Use the add_options_page function
	* add_options_page( $page_title, $menu_title, $capability, $menu-slug, $function )
	*/
	
	add_options_page(
		'Admin Pages',
		'Admin Pages',
		'manage_options',
		'bwadminpages',
		'bwadminpages_options_page'
		);
}
add_action( 'admin_menu', 'bwadminpages_menu' );
include('inc/add_pages.php');
add_pages();

function bwadminpages_options_page() {
	if( !current_user_can( 'manage_options' ) ) {
		wp_die( 'You do not have sufficient permission to access this page' );
	}
	
	global $wpdb;
	
	if( isset( $_POST['bwadminpages_new_page_form_submitted'] ) ) {
		
		$hidden_field = esc_html($_POST['bwadminpages_new_page_form_submitted']);
		$hidden_field = esc_sql($hidden_field);
		
		if( $hidden_field == 'Y' ) {
			$bwadminpages_page_title = esc_sql($_POST['bwadminpages_page_title']);
			$bwadminpages_page_content = '';
			$bwadminpages_timestamp = time();
			$bwadminpages_menu_position = '';
			$bwadminpages_menu_icon = 'dashicons-welcome-add-page';
			$bwadminpages_menu_capability = 'activate_plugins';
			$bwadminpages_page_styles = '';
			
			$table_name = $wpdb->prefix . 'bwadminpages';
			
			$wpdb->insert( 
				$table_name, 
				array( 
					'timestamp' => $bwadminpages_timestamp, 
					'page_title' => $bwadminpages_page_title, 
					'page_content' => $bwadminpages_page_content,
					'menu_position' => $bwadminpages_menu_position,
					'menu_icon' => $bwadminpages_menu_icon,
					'menu_capability' => $bwadminpages_menu_capability,
					'page_styles' => $bwadminpages_page_styles
				) 
			);
		}
	}
	if( isset( $_POST['bwadminpages_edit_page_form_submitted'] ) ) {
		
		$hidden_field = esc_html($_POST['bwadminpages_edit_page_form_submitted']);
		$hidden_field = esc_sql($hidden_field);
		
		if( $hidden_field == 'Y' ) {
			$bwadminpages_id = esc_sql($_POST['bwadminpages_edit_page_id']);
			$bwadminpages_page_title = esc_sql($_POST['bwadminpages_page_title']);
			$bwadminpages_page_content = htmlspecialchars($_POST['bwadminpages_page_content']);
			$bwadminpages_menu_position = esc_sql($_POST['bwadminpages_menu_position']);
			$bwadminpages_menu_icon = esc_sql($_POST['bwadminpages_menu_icon']);
			$bwadminpages_page_styles = $_POST['bwadminpages_page_styles'];
			$bwadminpages_timestamp = time();
			
			$table_name = $wpdb->prefix.'bwadminpages';
			
			if($_POST['bwadminpages_checkbox'] == '1') {
				$bwadminpages_menu_capability = esc_sql($_POST['bwadminpages_menu_capability']);
				$wpdb->update( 
					$table_name,
					array( 
						'timestamp' => $bwadminpages_timestamp, 
						'page_title' => $bwadminpages_page_title, 
						'page_content' => $bwadminpages_page_content,
						'menu_position' => $bwadminpages_menu_position,
						'menu_icon' => $bwadminpages_menu_icon,
						'menu_capability' => $bwadminpages_menu_capability,
						'page_styles' => $bwadminpages_page_styles
					),
					array( 'id' => $bwadminpages_id )
				);
			} else {
				$wpdb->update( 
					$table_name,
					array( 
						'timestamp' => $bwadminpages_timestamp, 
						'page_title' => $bwadminpages_page_title, 
						'page_content' => $bwadminpages_page_content,
						'menu_position' => $bwadminpages_menu_position,
						'menu_icon' => $bwadminpages_menu_icon,
						'page_styles' => $bwadminpages_page_styles
					),
					array( 'id' => $bwadminpages_id )
				);
			}
		}
	}
	if( isset( $_POST['bwadminpages_delete_page_form_submitted'] ) ) {
		
		$hidden_field = esc_html($_POST['bwadminpages_delete_page_form_submitted']);
		$hidden_field = esc_sql($hidden_field);
		
		if( $hidden_field == 'Y' ) {
			$bwadminpages_id = esc_sql($_POST['bwadminpages_delete_page_id']);
			
			$table_name = $wpdb->prefix . 'bwadminpages';
			
			$wpdb->delete( 
				$table_name, 
				array( 'id' => $bwadminpages_id )
			);
		}
	}
	
	require( 'inc/options-page-wrapper.php' );
}

function bwadminpages_styles() {
	wp_enqueue_style('bwadminpages_styles', plugins_url('/css/bw-admin-pages.css', __FILE__) );
}
add_action( 'admin_head', 'bwadminpages_styles' );

function bwadminpages_add_js() {
	wp_register_script('bwadminpages_js', plugins_url('/js/bwadminpages_js.js', __FILE__), array('jquery'), true);
	wp_enqueue_script('bwadminpages_js');
}
add_action('admin_enqueue_scripts', 'bwadminpages_add_js');
?>