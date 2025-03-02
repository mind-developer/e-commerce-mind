<?php
/**
 * The template for displaying demo plugin content.
 *
 * Override this template by copying it to yourtheme/dc-product-vendor/widget/vendor-list.php
 *
 * @author      WC Marketplace
 * @package     dc-product-vendor/Templates
 * @version     0.0.1
 */

global $WCMp;

$vendor_count = count( $vendors ); ?>
<div id="wcmp_widget_vendor_search" class="vendor_search_wrap form-group">
	<?php wp_nonce_field( 'wcmp_widget_vendor_search_form', 'wcmp_vendor_search_nonce' ); ?>
	<input type="search" class="search_keyword search-field form-control" placeholder="<?php esc_attr_e( 'Search Vendor…', 'dc-woocommerce-multi-vendor' ); ?>" value="" name="s" style="width: 100%;margin-bottom: 10px;">
</div>
<?php
if ( $vendor_count > 5 ) {
	?>
	<div id="wcmp_widget_vendor_list" class="pt-0 pb-0 pr-4 scrollable" style="height: 308px; overflow-y: scroll; width: 100%;" >
<?php } else { ?>
	<div id="wcmp_widget_vendor_list" class="pt-0 pb-0 pr-4 scrollable" style=" height: auto; width: 100%;" >
	<?php
}
if ( $vendors ) {
	foreach ( $vendors as $vendors_key => $vendor ) {
		$vendor->image = $vendor->get_image() ? $vendor->get_image() : $WCMp->plugin_url . 'assets/images/WP-stdavatar.png';
		?>
		<div style=" width: 100%; margin-bottom: 5px; clear: both; display: block;">
			<div style=" width: 25%;  display: inline;">		
			<img width="60" height="60" class="vendor_img" style="display: inline;" src=<?php echo esc_url( $vendor->image ); ?> id="vendor_image_display">
			</div>
			<div style=" width: 75%;  display: inline;  padding: 10px;">
				<a href="<?php echo esc_url( $vendor->permalink ); ?>">
					<?php echo esc_html( $vendor->page_title ); ?>
				</a>
			</div>
		</div>
		<?php
	}
}
?>
</div>
