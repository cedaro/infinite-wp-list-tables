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
 * Version:           2.0.0
 * Author:            Cedaro
 * Author URI:        http://www.cedaro.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       infinite-wp-list-tables
 * Domain Path:       /languages
 * GitHub Plugin URI: cedaro/infinite-wp-list-tables
 */

/**
 * Main plugin class.
 *
 * @package InfiniteWPListTables
 * @since 2.0.0
 */
class Cedaro_Infinite_WP_List_Tables {
	/**
	 * Load the plugin.
	 *
	 * @since 2.0.0
	 */
	public function load() {
		$this->load_textdomain();
		$this->register_hooks();
	}

	/**
	 * Localize the plugin's strings.
	 *
	 * @since 2.0.0
	 */
	public function load_textdomain() {
		$plugin_rel_path = dirname( plugin_basename( __FILE__ ) ) . '/languages';
		load_plugin_textdomain( 'infinite-wp-list-tables', false, $plugin_rel_path );
	}

	/**
	 * Register hooks.
	 *
	 * @since 2.0.0
	 */
	public function register_hooks() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_action( 'admin_head', array( $this, 'print_css' ) );
		add_action( 'admin_print_footer_scripts', array( $this, 'print_script' ) );
	}

	/**
	 * Enqueue and print assets to make WP List Tables support infinite scroll.
	 *
	 * @since 2.0.0
	 */
	public function enqueue_assets( $hook_suffix ) {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script(
			'jquery-infinite-scroll',
			plugin_dir_url( __FILE__ ) . 'assets/js/vendor/jquery.infinitescroll' . $suffix . '.js',
			array( 'jquery' ),
			'2.1.0',
			true
		);

		wp_localize_script( 'jquery-infinite-scroll', '_iwpltSettings', array(
			'l10n'      => array(
				'loadingMessage' => __( 'Loading&hellip;', 'infinite-wp-list-tables' ),
			),
			'selectors' => $this->get_selectors(),
		) );
	}

	/**
	 * Print CSS to support the Infinite Scroll script.
	 *
	 * @since 2.0.0
	 */
	public function print_css() {
		?>
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

	/**
	 * Print the script to initialize Infinite Scroll.
	 *
	 * @since 2.0.0
	 */
	public function print_script() {
		?>
		<script type="text/javascript">
		jQuery(function( $ ) {
			var settings = _iwpltSettings,
				$msg = $( '<tr id="iwplt-loading"><td class="colspanchange"></td></tr>' ),
				$table = $( settings.selectors.table );

			// Ensure the loading message cell spans the appropriate number of columns.
			$msg.find( '.colspanchange' )
				.attr( 'colspan', $table.find( 'thead tr' ).children( ':visible' ).length )
				.append( '<span class="spinner" /> ' )
				.append( settings.l10n.loadingMessage );

			$table.find( settings.selectors.content ).infinitescroll({
				loading: {
					finished: function() {
						$( '#iwplt-loading' ).hide();
					},
					msg: $msg
				},
				navSelector: '.pagination-links',
				nextSelector: '.next-page',
				itemSelector: settings.selectors.item,
				contentSelector: settings.selectors.content,
				maxPage: $( '.total-pages' ).first().text()
			}, function() {
				// Keep the pagination links visible.
				$( '.pagination-links' ).show();
			});
		});
		</script>
		<?php
	}

	/**
	 * Retrieve the selectors for the current screen.
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	protected function get_selectors() {
		$screen_id = get_current_screen()->id;

		$selectors = array(
			'content' => '#the-list',
			'item'    => '#the-list tr',
			'table'   => '.wp-list-table',
		);

		// Comment List Table
		if ( 'edit-comments' == $screen_id ) {
			$selectors = array(
				'content' => '#the-comment-list',
				'item'    => '#the-comment-list tr',
				'table'   => 'table.comments',
			);
		}

		// BuddyPress Activity List Table
		if ( 'toplevel_page_bp-activity' == $screen_id ) {
			$selectors = array(
				'content' => '#the-comment-list',
				'item'    => '#the-comment-list tr',
				'table'   => 'table.activities',
			);
		}

		// BuddyPress Group List Table
		if ( 'toplevel_page_bp-groups' == $screen_id ) {
			$selectors = array(
				'content' => '#the-comment-list',
				'item'    => '#the-comment-list tr',
				'table'   => 'table.groups',
			);
		}

		return apply_filters( 'infinite_wp_list_tables_selectors', $selectors );
	}
}

/**
 * Initialize the plugin.
 */
$infinite_wp_list_tables = new Cedaro_Infinite_WP_List_Tables();
add_action( 'plugins_loaded', array( $infinite_wp_list_tables, 'load' ) );
