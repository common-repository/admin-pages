<?php
function add_pages() {
    global $wpdb, $sf_admin_pages_result;
    $prefix = $wpdb->prefix;
    $result = $wpdb->get_results( "SELECT * FROM ".$prefix."bwadminpages");
    $sf_admin_pages_result = $result;
    if( $result ) {
         foreach( $result as $row ) {
             $page_title = $row->page_title;
             $page_content= $row->page_content;
             $menu_position = $row->menu_position;
             $menu_icon = $row->menu_icon;
             $menu_capability = $row->menu_capability;
             $id = $row->id;
             $function_name = 'bwadminpages_'.$id;
             $func = $function_name;
             $function_options = trim($func.'_options');
             $func_options = $function_options;
         }
    }
}

add_action( 'admin_menu', 'add_sf_all_adminpages' );
function add_sf_all_adminpages() {
    global $sf_admin_pages_result;
    if( $sf_admin_pages_result ) {
         foreach( $sf_admin_pages_result as $row ) {
             $page_title = $row->page_title;
             $page_content= $row->page_content;
             $menu_position = $row->menu_position;
             $menu_icon = $row->menu_icon;
             $menu_capability = $row->menu_capability;
             $id = $row->id;
             $function_name = 'bwadminpages_'.$id;
             $func = $function_name;
             $function_options = trim($func.'_options');
             $func_options = $function_options;
             add_menu_page( $page_title, $page_title, $menu_capability, 'bwadminpages_'.$id, 'sf_bwadminpages_show_page', $menu_icon, $menu_position );
         }
     }
}

function sf_bwadminpages_show_page() {
    global $wpdb;
    $screen = get_current_screen();
    $pageid = $screen->id;
    $pageid = str_ireplace('toplevel_page_bwadminpages_', '', $pageid);
    $prefix = $wpdb->prefix;
    $result = $wpdb->get_results( "SELECT * FROM ".$prefix."bwadminpages WHERE id = ".$pageid);
    if ( $result ) {
        foreach( $result as $row ) {
            $page_title = $row->page_title;
            $page_content= $row->page_content;
            $menu_position = $row->menu_position;
            $menu_icon = $row->menu_icon;
            $menu_capability = $row->menu_capability;
            $id = $row->id;
            $function_name = 'bwadminpages_'.$id;
            $func = $function_name;
            $function_options = trim($func.'_options');
            $func_options = $function_options;
        }
        echo '<div class="wrap">';
        echo do_shortcode(mynl2br($page_content));
        echo '</div>';
    }
}
?>
