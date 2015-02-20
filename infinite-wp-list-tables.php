<?php
/**
 * Infinite WP List Tables
 *
 * @package   InfiniteWPListTables
 * @author    Brady Vercher
 * @link      http://www.cedaro.com/
 * @copyright Copyright (c) 2015 Cedaro, Inc.
 * @license   GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name:       Infinite WP List Tables
 * Plugin URI:        https://github.com/cedaro/infinite-wp-list-tables
 * Description:       Infinite scroll support for WP List Tables in the WordPress admin panel.
 * Version:           1.0.0
 * Author:            Cedaro
 * Author URI:        http://www.cedaro.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       infinite-wp-list-tables
 * Domain Path:       /languages
 * GitHub Plugin URI: cedaro/infinite-wp-list-tables
 */

/**
 * Enqueue and print assets to make WP List Tables support infinite scroll.
 *
 * @since 1.0.0
 */
function cedaro_infinite_wp_list_tables() {
	wp_enqueue_script(
		'jquery-infinite-scroll',
		plugin_dir_url( __FILE__ ) . 'assets/js/vendor/jquery.infinitescroll.min.js',
		array( 'jquery' ),
		'2.1.0',
		true
	);

	wp_localize_script( 'jquery-infinite-scroll', 'iwpltL10n', array(
		'loadingMessage' => __( 'Loading&hellip;', 'infinite-wp-list-tables' ),
	) );
	?>

	<script type="text/javascript">
	jQuery(function( $ ) {
		var $msg = $( '<tr id="iwplt-loading"><td class="colspanchange"></td></tr>' );

		// Ensure the loading message cell spans the appropriate number of columns.
		$msg.find( '.colspanchange' )
			.attr( 'colspan', $( '.wp-list-table thead tr' ).children( ':visible' ).length )
			.append( '<span class="spinner"></span> ' )
			.append( iwpltL10n.loadingMessage );

		$( '#the-list' ).infinitescroll({
			loading: {
				finished: function() {
					$( '#iwplt-loading' ).hide();
				},
				msg: $msg
			},
			navSelector: '.pagination-links',
			nextSelector: '.next-page',
			itemSelector: '#the-list tr',
			contentSelector: '#the-list',
			maxPage: $( '.total-pages' ).first().text()
		});
	});
	</script>

	<style type="text/css">
	tr#iwplt-loading td {
		padding: 10px;
		vertical-align: middle;
	}

	tr#iwplt-loading .spinner {
		display: inline-block;
		float: none;
		margin-top: 0;
		vertical-align: middle;
	}
	</style>
	<?php
}
add_action( 'admin_footer', 'cedaro_infinite_wp_list_tables' );
