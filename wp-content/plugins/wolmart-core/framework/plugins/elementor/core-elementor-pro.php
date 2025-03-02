<?php
/**
 * Elementor Pro Compatibility
 *
 * @package Wolmart WordPress Framework
 * @since 1.0
 */
defined( 'ABSPATH' ) || die;

use ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager;

if ( ! class_exists( 'Wolmart_Elementor_Pro' ) ) :
	class Wolmart_Elementor_Pro extends Wolmart_Base {

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'elementor/theme/register_locations', array( $this, 'register_locations' ) );
			add_action( 'elementor/theme/register_locations', array( $this, 'remove_header_footer_locations' ), 105 );
			add_action( 'wolmart_elementor_pro_header_location', array( $this, 'do_header' ) );
			add_action( 'wolmart_elementor_pro_footer_location', array( $this, 'do_footer' ) );
		}

		/**
		 * @param Locations_Manager $manager
		 */
		public function register_locations( $manager ) {
			$manager->register_core_location( 'header' );
			$manager->register_core_location( 'footer' );

			$module  = ElementorPro\Modules\ThemeBuilder\Module::instance();
			$headers = $module->get_conditions_manager()->get_documents_for_location( 'header' );
			$footers = $module->get_conditions_manager()->get_documents_for_location( 'footer' );
			if ( ! empty( $headers ) ) {
				$GLOBALS['wolmart_layout']['header'] = 'elementor_pro';
			}
			if ( ! empty( $footers ) ) {
				$GLOBALS['wolmart_layout']['footer'] = 'elementor_pro';
			}
		}

		public function do_header() {
			elementor_theme_do_location( 'header' );
		}

		public function do_footer() {
			elementor_theme_do_location( 'footer' );
		}

		public function remove_header_footer_locations() {
			$module        = ElementorPro\Modules\ThemeBuilder\Module::instance();
			$theme_support = $module->get_component( 'theme_support' );
			if ( $theme_support ) {
				remove_action( 'get_header', array( $theme_support, 'get_header' ) );
				remove_action( 'get_footer', array( $theme_support, 'get_footer' ) );
				remove_filter( 'show_admin_bar', array( $theme_support, 'filter_admin_bar_from_body_open' ) );
			}
		}
	}
endif;

Wolmart_Elementor_Pro::get_instance();
