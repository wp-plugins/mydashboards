<?php
/*
Plugin Name: My Dashboards
Plugin URI: http://www.vjcatkick.com/?page_id=10392
Description: Display my dashboards below Dashboard menu at your administration panel.
Version: 0.1.0
Author: V.J.Catkick
Author URI: http://www.vjcatkick.com/
*/

add_action('admin_menu', 'my_dashboards_add_pages');


function my_dashboards_add_pages() {
	$my_dashboards_max_links = 5;

	$options = get_option('widget_mydashboards');
	$widget_mydashboards_add_admin = $options['widget_mydashboards_add_admin'];

	$admin_url = '';
	if( $widget_mydashboards_add_admin ) { $admin_url .= 'wp-admin/'; }

	for( $i=1; $i<=$my_dashboards_max_links; $i++) {
		$widget_mydashboards_blogtitle_tmp = $options['widget_mydashboards_blogtitle_'.$i];
		$widget_mydashboards_url_tmp = $options['widget_mydashboards_url_'.$i];
		if( strlen( $widget_mydashboards_blogtitle_tmp ) > 0 && strlen( $widget_mydashboards_url_tmp ) > 0 ) {
			add_submenu_page('index.php', $widget_mydashboards_blogtitle_tmp, '&#187;&nbsp;'.$widget_mydashboards_blogtitle_tmp, 8, $widget_mydashboards_url_tmp.$admin_url );
		} /* if */
	} /* for */

	add_options_page('My Dashboards', 'My Dashboards', 8, 'mydashboards_options', 'my_dashboards_options_page');
} /* my_dashboards_add_pages() */

function my_dashboards_options_page() {
	$my_dashboards_max_links = 5;
	$output = '';

	$options = $newoptions = get_option('widget_mydashboards');
	if ( $_POST["widget_mydashboards_submit"] ) {
		for( $i=1; $i<=$my_dashboards_max_links; $i++) {
			$newoptions['widget_mydashboards_blogtitle_'.$i] = $_POST["widget_mydashboards_blogtitle_".$i];
			$newoptions['widget_mydashboards_url_'.$i] = $_POST["widget_mydashboards_url_".$i];
		} /* for */
		$newoptions['widget_mydashboards_add_admin'] = (boolean)$_POST["widget_mydashboards_add_admin"];
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('widget_mydashboards', $options);
	}

	$widget_mydashboards_add_admin = $options['widget_mydashboards_add_admin'];

	$output .= '<h2>My Dashboards</h2>';
	$output .= '<form action="" method="post" id="widget_mydashboards_form" style="margin: auto; width: 600px; ">';
	for( $i=1;$i<=$my_dashboards_max_links;$i++ ) {
		$widget_mydashboards_blogtitle_tmp = $options['widget_mydashboards_blogtitle_'.$i];
		$widget_mydashboards_url_tmp = $options['widget_mydashboards_url_'.$i];
	
		$output .= 'Title '.$i.': ';
		$output .= '<input style="width: 150px;" id="widget_mydashboards_blogtitle_'.$i.'" name="widget_mydashboards_blogtitle_'.$i.'" type="text" value="'.$widget_mydashboards_blogtitle_tmp.'" /><br />';
		$output .='URL '.$i.': ';
		$output .= '<input style="width: 300px;" id="widget_mydashboards_url_'.$i.'" name="widget_mydashboards_url_'.$i.'" type="text" value="'.$widget_mydashboards_url_tmp.'" /><br /><br />';

	} /* for */

	$output .= '<input id="widget_mydashboards_add_admin" name="widget_mydashboards_add_admin" type="checkbox" value="1" ';
	if( $widget_mydashboards_add_admin ) $output .= 'checked';
	$output .= '/> Automatically add \'wp-admin/\' at end of each URL you\'ve entered.<br />';

	$output .= '<p class="submit"><input type="submit" name="widget_mydashboards_submit" value="'. 'Update options &raquo;' .'" /></p>';
	$output .= '</form>';

	echo $output;
} /* my_dashboards_options_page() */


?>