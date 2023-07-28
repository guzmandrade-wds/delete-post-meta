<?php
/*
 * Plugin Name:       Delete Post Meta
 * Plugin URI:        https://github.com/guzmandrade-wds/delete-post-meta
 * Description:       Delete Post Meta based on meta key.
 * Version:           1.0.0
 * Requires at least: 6.2
 * Requires PHP:      8.0
 * Author:            Mauricio Andrade
 * Author URI:        https://profiles.wordpress.org/h4l9k/
 * License:           GPL v3 or later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       delete-post-meta
 */

add_action( 'admin_menu', 'dpm_register_submenu_page' );

/**
 * Registers a submenu page for the 'tools.php' admin page.
 *
 * @return null
 */
function dpm_register_submenu_page() {
	add_submenu_page(
		'tools.php',
		__( 'Delete Post Meta', 'delete-post-meta' ),
		__( 'Delete Post Meta', 'delete-post-meta' ),
		'activate_plugins',
		'delete-post-meta',
		'dpm_main_callback'
	);
}

/**
 * Main callback function. If the dpm_meta_key_search value is not false, it calls `delete_metadata` to delete
 * all post meta based on the meta key.
 *
 * @return null
 */
function dpm_main_callback() {
	if ( isset( $_POST['dpm_meta_key_search_nonce'] )
		&& wp_verify_nonce( $_POST['dpm_meta_key_search_nonce'], 'dpm_meta_key_action' )
	) {
		$meta_key_search = isset( $_POST['dpm_meta_key_search'] ) ? sanitize_text_field( $_POST['dpm_meta_key_search'] ) : false;

		if ( $meta_key_search ) {
			/**
			 * @link https://developer.wordpress.org/reference/functions/delete_metadata/
			 * Accepts 'post', 'comment', 'term', 'user', or any other object type with an associated meta table.
			 */
			$object_type = apply_filters( 'dpm_meta_key_object_type', 'post' );
			delete_metadata( $object_type, 0, $meta_key_search, null, true );
		}
	}
	?>
	<div class="wrap"><div id="icon-tools" class="icon32"></div>
		<h2>Delete Post Meta</h2>
		<div class="notice notice-warning inline">
			<p><strong>Warning:</strong> Use this plugin with caution. It will delete all post meta based on a meta key.</p>
		</div>
		<form method="post">
			<?php wp_nonce_field( 'dpm_meta_key_action', 'dpm_meta_key_search_nonce' ); ?>
			<label for="dpm_meta_key_search">Meta Key:</label>
			<input name="dpm_meta_key_search" id="dpm_meta_key_search" type="text" />

			<button type="submit" class="button button-primary">Delete Post Meta</button>
		</form>
	</div>
	<?php
}
