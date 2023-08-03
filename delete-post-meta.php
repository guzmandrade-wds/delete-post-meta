<?php
/*
 * Plugin Name:       Delete Post Meta
 * Plugin URI:        https://github.com/guzmandrade-wds/delete-post-meta
 * Description:       Delete Post Meta based on meta key.
 * Version:           1.0.0
 * Requires at least: 6.2
 * Requires PHP:      7.4
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
	global $wpdb;
	if ( isset( $_POST['dpm_meta_key_search_nonce'] )
		&& wp_verify_nonce( $_POST['dpm_meta_key_search_nonce'], 'dpm_meta_key_action' )
	) {
		$meta_key_search = isset( $_POST['dpm_meta_key_search'] ) ? sanitize_text_field( $_POST['dpm_meta_key_search'] ) : false;
		if ( $meta_key_search ) {
			$wpdb->query(
				$wpdb->prepare(
					"DELETE from $wpdb->postmeta
					WHERE meta_key = %s",
					$meta_key_search,
				)
			);
		}
	}
	?>
	<div class="wrap"><div id="icon-tools" class="icon32"></div>
		<h2><?php esc_html_e( 'Delete Post Meta', 'delete-post-meta' ); ?></h2>
		<div class="notice notice-warning inline">
			<p><strong><?php esc_html_e( 'Warning:', 'delete-post-meta' ); ?></strong> <?php esc_html_e( 'Use this plugin with caution. It will delete all post meta based on a meta key.', 'delete-post-meta' ); ?></p>
		</div>
		<form method="post">
			<?php wp_nonce_field( 'dpm_meta_key_action', 'dpm_meta_key_search_nonce' ); ?>
			<label for="dpm_meta_key_search">Meta Key:</label>
			<input name="dpm_meta_key_search" id="dpm_meta_key_search" type="text" />

			<input type="submit" class="button button-primary" onclick="return confirm('We are about to delete all post meta based on this meta key. Are you sure?')" value="Delete Post Meta" />
		</form>
	</div>
	<?php
}
