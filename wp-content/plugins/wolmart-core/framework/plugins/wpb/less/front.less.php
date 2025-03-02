<?php
$unused_shortcode_list = isset( $wpb_shortcodes_to_remove ) ? $wpb_shortcodes_to_remove : array();
?>

@import "responsive-utilities.less";
@import "grid.less";
@import "utils.less";
@import "../modules/vc_table.less";
// pixel icons
@import "pixel_icons.less";
@import "../../fonts/vc_icons_v2/init.less";

//Helper classes
.vc_txt_align_ {
  &left {
	text-align: left;
  }
  &right {
	text-align: right;
  }
  &center {
	text-align: center;
  }
  &justify {
	text-align: justify;
	text-justify: inter-word;
  }
}

// Mixin for genereate .vc_el_width_X class
.vc_el_width( @size ) {
  &.vc_el_width_@{size} {
	@percent_size: ~"@{size}%"; // string concatenation with number + %
	width: @percent_size;
	margin-left: auto !important;
	margin-right: auto !important;
  }
}

// Loop to call .vc_el_width mixin
.generate_width(@start, @max: 100, @step: 10) when ( @start <= @max) {
  .vc_el_width(@start);
  .generate_width((@start+@step), @max, @step); // next iteration, will automatically break if @start+@step <= @max
}

// Generate classes in loop from 50 to 100, vc_el_width_50, .. vc_el_width_100.
.generate_width(50, 100, 10);

@import (once) "../modules/vc_buttons.less";
.vc_column_container {
  .vc_btn, .wpb_button {
	margin-top: 5px;
	margin-bottom: 5px;
  }
}

/* 2. Alerts (Message boxes)
---------------------------------------------------------- */
<?php if ( ! in_array( 'vc_message', $unused_shortcode_list ) ) : ?>
@import "../shortcodes/vc_message_box/vc_message_box_front.less";
<?php endif; ?>

/* 4. Separators
---------------------------------------------------------- */

/***************** OLD CSS *****************/
/* Content elements margins
---------------------------------------------------------- */
.wpb_alert p:last-child,
#content .wpb_alert p:last-child, /* for twenty ten theme */
.wpb_text_column p:last-child,
.wpb_text_column *:last-child,
#content .wpb_text_column p:last-child, /* for twenty ten theme */
#content .wpb_text_column *:last-child /* for twenty ten theme */
{
  margin-bottom: 0;
}

.wpb_content_element,
ul.wpb_thumbnails-fluid > li,
.wpb_button {
  margin-bottom: @vc_element_margin_bottom;
}

.fb_like,
.twitter-share-button, .entry-content .twitter-share-button,
.wpb_googleplus,
.wpb_pinterest,
.wpb_tab .wpb_content_element,
.wpb_accordion .wpb_content_element {
  margin-bottom: @vc_margin_bottom_gold;
}

@import "../lib/parallax.less";
@import "../shortcodes/vc_row.less";
<?php if ( ! in_array( 'vc_section', $unused_shortcode_list ) ) : ?>
@import "../shortcodes/vc_section.less";
<?php endif; ?>
@import "../shortcodes/frontend_vc_row.less";

/*@import "../shortcodes/vc_social_btns.less";*/
<?php if ( ! in_array( 'vc_toggle', $unused_shortcode_list ) ) : ?>
@import "../shortcodes/vc_toggle.less";
<?php endif; ?>

<?php if ( ! in_array( 'vc_widget_sidebar', $unused_shortcode_list ) ) : ?>
@import "../shortcodes/vc_widgetised_column.less";
<?php endif; ?>

<?php if ( ! in_array( 'vc_button', $unused_shortcode_list ) || ! in_array( 'vc_button2', $unused_shortcode_list ) ) : ?>
@import "../shortcodes/vc_button.less";
<?php endif; ?>

<?php if ( ! in_array( 'vc_btn', $unused_shortcode_list ) ) : ?>
/*@import "../shortcodes/vc_button3.less";*/
<?php endif; ?>

<?php if ( ! in_array( 'vc_custom_heading', $unused_shortcode_list ) ) : ?>
@import "../shortcodes/vc_custom_heading.less";
<?php endif; ?>

<?php if ( ! in_array( 'vc_cta_button', $unused_shortcode_list ) || ! in_array( 'vc_cta_button2', $unused_shortcode_list ) ) : ?>
@import "../shortcodes/vc_call_to_action.less";
<?php endif; ?>

<?php if ( ! in_array( 'vc_cta', $unused_shortcode_list ) ) : ?>
@import "../shortcodes/vc_call_to_action3.less";
<?php endif; ?>

<?php if ( ! in_array( 'vc_gmaps', $unused_shortcode_list ) ) : ?>
@import "../shortcodes/vc_google_maps.less";
<?php endif; ?>

/*@import "../shortcodes/vc_tabs_tour_accordion.less";*/

<?php if ( ! in_array( 'vc_posts_grid', $unused_shortcode_list ) ) : ?>
/* recheck */
@import "../shortcodes/vc_teaser_grid.less";
<?php endif; ?>

<?php if ( ! in_array( 'vc_gallery', $unused_shortcode_list ) || ! in_array( 'vc_posts_slider', $unused_shortcode_list ) ) : ?>
@import "../shortcodes/vc_image_gallery.less";
<?php endif; ?>

<?php if ( ! in_array( 'vc_flickr', $unused_shortcode_list ) ) : ?>
@import "../shortcodes/vc_flickr.less";
<?php endif; ?>

<?php if ( ! in_array( 'vc_video', $unused_shortcode_list ) ) : ?>
@import "../shortcodes/vc_video_widget.less";
<?php endif; ?>

<?php if ( ! in_array( 'vc_posts_slider', $unused_shortcode_list ) ) : ?>
@import "../shortcodes/vc_post_slider.less";
<?php endif; ?>

<?php if ( ! in_array( 'vc_progress_bar', $unused_shortcode_list ) ) : ?>
@import "../shortcodes/vc_progress_bar.less";
<?php endif; ?>

<?php if ( ! in_array( 'vc_pie', $unused_shortcode_list ) ) : ?>
@import "../shortcodes/vc_pie.less";
<?php endif; ?>

<?php if ( ! in_array( 'vc_carousel', $unused_shortcode_list ) ) : ?>
@import "../shortcodes/vc_carousel.less";
<?php endif; ?>

<?php if ( ! in_array( 'vc_separator', $unused_shortcode_list ) ) : ?>
@import "../shortcodes/vc_separator.less";
<?php endif; ?>

<?php if ( ! in_array( 'vc_zigzag', $unused_shortcode_list ) ) : ?>
@import "../shortcodes/vc_zigzag.less";
<?php endif; ?>

<?php if ( ! in_array( 'vc_single_image', $unused_shortcode_list ) ) : ?>
@import "../shortcodes/vc_single_image.less";
<?php endif; ?>

<?php if ( ! in_array( 'vc_icon', $unused_shortcode_list ) || ! in_array( 'vc_cta', $unused_shortcode_list ) ) : ?>
@import "../shortcodes/vc_icon_element.less";
<?php endif; ?>

<?php if ( ! in_array( 'vc_line_chart', $unused_shortcode_list ) || ! in_array( 'vc_round_chart', $unused_shortcode_list ) ) : ?>
@import "../shortcodes/vc_charts.less";
<?php endif; ?>

<?php if ( ! in_array( 'vc_single_image', $unused_shortcode_list ) ) : ?>
@import "../shortcodes/vc_zoom.less";
<?php endif; ?>

<?php if ( ! in_array( 'vc_tta_accordion', $unused_shortcode_list ) ) : ?>
@import "../shortcodes/vc_pagination.less";
<?php endif; ?>

<?php if ( ! in_array( 'vc_basic_grid', $unused_shortcode_list ) ) : ?>
@import "../shortcodes/vc_basic_grid/vc_grid.less";
<?php endif; ?>

<?php if ( ! in_array( 'vc_hoverbox', $unused_shortcode_list ) ) : ?>
@import "../shortcodes/vc_hoverbox.less";
<?php endif; ?>

@import "vc_font.less";
@import "css3_animations.less";
<?php if ( class_exists( 'WooCommerce' ) ) : ?>
@import "../vendor/woocommerce.less";
<?php endif; ?>
