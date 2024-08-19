<?php
/**
 * Wolmart Categories
 *
 * @since 1.0.0
 */

$params = array(
	esc_html__( 'General', 'wolmart-core' ) => array(
		'wolmart_wpb_categories_select_controls',
	),
	esc_html__( 'Layout', 'wolmart-core' )  => array(
		'wolmart_wpb_elements_layout_controls',
	),
	esc_html__( 'Type', 'wolmart-core' )    => array(
		'wolmart_wpb_categories_type_controls',
	),
	esc_html__( 'Style', 'wolmart-core' )   => array(
		esc_html__( 'Category', 'wolmart-core' )         => array( 'wolmart_wpb_categories_wrap_style_controls' ),
		esc_html__( 'Category Icon', 'wolmart-core' )    => array( 'wolmart_wpb_categories_icon_style_controls' ),
		esc_html__( 'Category Content', 'wolmart-core' ) => array( 'wolmart_wpb_categories_content_style_controls' ),
		esc_html__( 'Category Name', 'wolmart-core' )    => array( 'wolmart_wpb_categories_name_style_controls' ),
		esc_html__( 'Products Count', 'wolmart-core' )   => array( 'wolmart_wpb_categories_count_style_controls' ),
		esc_html__( 'Button', 'wolmart-core' )           => array( 'wolmart_wpb_categories_button_style_controls' ),
	),
);

$params = array_merge( wolmart_wpb_filter_element_params( $params, 'wpb_wolmart_categories_masonry' ), wolmart_get_wpb_design_controls(), wolmart_get_wpb_extra_controls() );

vc_map(
	array(
		'name'            => esc_html__( 'Product Categories Masonry', 'wolmart-core' ),
		'base'            => 'wpb_wolmart_categories_masonry',
		'icon'            => 'wolmart-icon wolmart-icon-cat-masonry',
		'class'           => 'wolmart_categories wolmart_categories_masonry',
		'content_element' => true,
		'controls'        => 'full',
		'category'        => esc_html__( 'Wolmart', 'wolmart-core' ),
		'description'     => esc_html__( 'Create wolmart product categories with masonry layout.', 'wolmart-core' ),
		'params'          => $params,
	)
);

add_filter( 'vc_autocomplete_wpb_wolmart_categories_masonry_category_ids_callback', 'wolmart_wpb_shortcode_product_category_id_callback', 10, 1 );
add_filter( 'vc_autocomplete_wpb_wolmart_categories_masonry_category_ids_render', 'wolmart_wpb_shortcode_product_category_id_render', 10, 1 );

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_WPB_Wolmart_Categories_Masonry extends WPBakeryShortCode {
	}
}
