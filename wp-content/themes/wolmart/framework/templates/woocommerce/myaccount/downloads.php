<?php
/**
 * Downloads
 *
 * Shows downloads on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/downloads.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.2.0
 */

defined( 'ABSPATH' ) || die;

$downloads     = WC()->customer->get_downloadable_products();
$has_downloads = (bool) $downloads;

do_action( 'woocommerce_before_account_downloads', $has_downloads ); ?>

<div class="icon-box icon-box-side woocommerce-MyAccount-content-caption justify-content-start mb-4">
	<span class="icon-box-icon text-grey mr-2">
		<i class="w-icon-download"></i>
	</span>
	<div class="icon-box-content">
		<h4 class="icon-box-title text-normal"><?php echo esc_html_e( 'Downloads', 'wolmart' ); ?></h4>
	</div>
</div>

<?php if ( $has_downloads ) : ?>

	<?php do_action( 'woocommerce_before_available_downloads' ); ?>

	<?php do_action( 'woocommerce_available_downloads', $downloads ); ?>

	<?php do_action( 'woocommerce_after_available_downloads' ); ?>

<?php else : ?>
	<div class="woocommerce-Message woocommerce-Message--info woocommerce-info">
		<p><?php esc_html_e( 'No downloads available yet.', 'woocommerce' ); ?></p>
		<a class="woocommerce-Button btn btn-dark btn-rounded btn-icon-right" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
			<?php esc_html_e( 'Go Shop', 'wolmart' ); ?><i class="w-icon-long-arrow-right"></i>
		</a>
	</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_account_downloads', $has_downloads ); ?>
