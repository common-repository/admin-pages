<?php
global $wpdb;
$prefix = $wpdb->prefix;
?>
<div class="wrap">
	<h1 class="bwap_title"><?php esc_attr_e( 'Admin Pages Settings', 'wp_admin_style' ); ?></h1>
	<div id="bwap_menu">
		<?php
		if( isset( $_GET['bwap'] ) ) {
			if( $_GET['bwap'] == 'e' ) {
				?>
				<div class="bwap_button"><span><div class="dashicons dashicons-edit"></div> Edit Page</span><span class="alignright">click to open</span></div>
				<div class="bwap_content">
					<?php
					if( isset( $_GET['id'] ) ) {
						$id = esc_sql($_GET['id']);
						$result = $wpdb->get_results( "SELECT * FROM ".$prefix."bwadminpages WHERE id=".$id."");
						if( $result ) {
							foreach( $result as $row ) {
							$page_title = $row->page_title;
							$page_content= $row->page_content;
							$menu_position = $row->menu_position;
							$menu_icon = $row->menu_icon;
							$menu_capability = $row->menu_capability;
							//$page_styles = $row->page_styles;
							//$page_styles = strtr($page_styles, array("\r\n" => '', "\r" => '', "\n" => ''));
							$id = $row->id;
							?>
							<p style="font-size: 15px;"><?php echo '<strong>Editing:</strong> '.$page_title; ?></p>
							<form method="post" action="">
								<input type="hidden" name="bwadminpages_edit_page_form_submitted" value="Y" />
								<input type="hidden" name="bwadminpages_edit_page_id" value="<?php echo $id ?>" />
								
								<label for="bwadminpages_page_title">Page Title</label>
								<br />
								<input name="bwadminpages_page_title" id="bwadminpages_page_title" type="text" value="<?php echo $page_title; ?>" class="regular-text" />
								
								<br />
								<br />
								
								<label for="bwadminpages_page_content">Page Content</label>
								<div id="poststuff">
									<?php the_editor(mynl2br($page_content),'bwadminpages_page_content'); ?>
								</div>
								
								<br />
								
								<label for="bwadminpages_menu_position">Menu Position</label>
								<br />
								<input name="bwadminpages_menu_position" id="bwadminpages_menu_position" type="text" value="<?php echo $menu_position; ?>" class="regular-text" />
								<p><a href="https://codex.wordpress.org/Function_Reference/add_menu_page" target="_BLANK">Visit this page for more information on menu position.</a></p>
								
								<br />
								<br />
								
								<label for="bwadminpages_menu_icon">Menu Icon</label>
								<br />
								<input name="bwadminpages_menu_icon" id="bwadminpages_menu_icon" type="text" value="<?php echo $menu_icon; ?>" class="regular-text" />
								<p><a href="https://developer.wordpress.org/resource/dashicons/" target="_BLANK">Visit this page for all icon options.</a></p>
								<br />
								<label for="bwadminpages_menu_capability">Menu Capability (Who can see this page)</label>
								
								<br />
								<br />
								
								<input onclick="enable_disable();" id="bwadminpages_checkbox" type="checkbox" name="bwadminpages_checkbox" value="1">Change who can see this page
								<br />
								<select disabled name="bwadminpages_menu_capability" id="bwadminpages_menu_capability">
									<option value="manage_network">Super Admin</option>
									<option value="activate_plugins">Administrator</option>
									<option value="delete_others_pages">Editor</option>
									<option value="delete_published_posts">Author</option>
									<option value="delete_posts">Contributor</option>
									<option value="read">Subscriber</option>
								</select>
								<p>Currently, <strong><?php echo $page_title ?></strong> is set to be seen by: <strong><?php menu_capability($menu_capability); ?></strong></p>
								
								<br />
								<br />
								
								<input class="button-primary" type="submit" name="bwadminpages_edit_page_submit" value="Save" />
						   </form>
							
							<br />
							
						   <form method="post" action="">
							   <input type="hidden" name="bwadminpages_delete_page_form_submitted" value="Y" />
							   <input type="hidden" name="bwadminpages_delete_page_id" value="<?php echo $id ?>" />
							   <input class="button" type="submit" name="bwadminpages_delete_page_submit" id="bwadminpages_delete_page_submit" value="Delete Page" />
						   </form>
							<?php
							}
						} else {
							echo 'Sorry, that video could not be found. Please try again later';
						}
					} else {
						echo 'Sorry, that video could not be found. Please try again later';
					}
				?>
				</div>
				<?php
				}
			}
		?>
		<div class="bwap_button"><span><div class="dashicons dashicons-plus"></div> New Page</span><span class="alignright">click to open</span></div>
		<div class="bwap_content">
			<form method="post" action="">
				<input type="hidden" name="bwadminpages_new_page_form_submitted" value="Y" />
				
				<label for="bwadminpages_page_title">Page Title</label>
				<br/>
				<input name="bwadminpages_page_title" id="bwadminpages_page_title" type="text" value="" class="regular-text" />
				
				<br />
				<br />
				
				<input class="button-primary" type="submit" name="bwadminpages_page_title_submit" value="Save" />
			</form>
		</div>

		<div class="bwap_button section_last" id="section_last"><span><div class="dashicons dashicons-admin-page"></div> All Pages</span><span class="alignright">click to open</span></div>
		<div class="bwap_content">
			<ul id="bwap_list">
				<?php
				$result = $wpdb->get_results( "SELECT * FROM ".$prefix."bwadminpages");
				$num_rows = $wpdb->num_rows;
				$count = 1;
				if(!$result == "") {
					foreach($result as $row) {
						if($count == $num_rows) {
							echo '<a href="?page=bwadminpages&bwap=e&id='.$row->id.'"><li id="bwap_list_last">'.$row->page_title.'</li></a>';
						} else {
							echo '<a href="?page=bwadminpages&bwap=e&id='.$row->id.'"><li>'.$row->page_title.'</li></a>';
						}
						$count++;
					}
				} else {
					echo '<li>'.esc_attr_e( 'There are no pages', 'wp_admin_style' ).'</li>';
				}
				?>
			</ul>
		</div>
	</div>
</div> <!-- .wrap -->
<script>
function enable_disable() {
	if (document.getElementById('bwadminpages_checkbox').checked == true) {
	  document.getElementById('bwadminpages_menu_capability').removeAttribute('disabled');
	} else {
	  document.getElementById('bwadminpages_menu_capability').setAttribute('disabled','disabled');
	}
}
</script>
