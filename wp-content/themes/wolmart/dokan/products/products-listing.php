<?php
global $post;

do_action( 'dokan_dashboard_wrap_start' );
?>

<div class="dokan-dashboard-wrap">

	<?php

		/**
		 *  dokan_dashboard_content_before hook
		 *
		 *  @hooked get_dashboard_side_navigation
		 *
		 *  @since 2.4
		 */
		do_action( 'dokan_dashboard_content_before' );
	?>

		<div class="dokan-dashboard-content dokan-product-listing">

			<?php

			/**
			 *  dokan_dashboard_content_before hook
			 *
			 *  @hooked get_dashboard_side_navigation
			 *
			 *  @since 2.4
			 */
			do_action( 'dokan_dashboard_content_inside_before' );
			do_action( 'dokan_before_listing_product' );
			?>

			<article class="dokan-product-listing-area">

				<div class="product-listing-top dokan-clearfix">
					<?php dokan_product_listing_status_filter(); ?>

					<?php if ( dokan_is_seller_enabled( get_current_user_id() ) ) { ?>
						<span class="dokan-add-product-link">
							<?php if ( current_user_can( 'dokan_add_product' ) ) { ?>
								<a href="<?php echo esc_url( dokan_get_navigation_url( 'new-product' ) ); ?>" class="dokan-btn dokan-btn-theme <?php echo ( 'on' == dokan_get_option( 'disable_product_popup', 'dokan_selling', 'off' ) ) ? '' : 'dokan-add-new-product'; ?>">
									<i class="w-icon-cart">&nbsp;</i>
									<?php esc_html_e( 'Add new product', 'dokan-lite' ); ?>
								</a>
							<?php } ?>

							<?php
								do_action( 'dokan_after_add_product_btn' );
							?>
						</span>
					<?php } ?>
				</div>

				<?php dokan_product_dashboard_errors(); ?>

				<div class="dokan-w12">
					<?php dokan_product_listing_filter(); ?>
				</div>

				<div class="dokan-dashboard-product-listing-wrapper">

					<form id="product-filter" method="POST" class="dokan-form-inline">
						<div class="dokan-form-group">
							<label for="bulk-product-action-selector" class="screen-reader-text"><?php esc_html_e( 'Select bulk action', 'dokan-lite' ); ?></label>

							<select name="status" id="bulk-product-action-selector" class="dokan-form-control chosen">
								<?php foreach ( $bulk_statuses as $key => $bulk_status ) { ?>
									<option class="bulk-product-status" value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $bulk_status ); ?></option>
								<?php } ?>
							</select>
						</div>

						<div class="dokan-form-group">
							<?php wp_nonce_field( 'bulk_product_status_change', 'security' ); ?>
							<input type="submit" name="bulk_product_status_change" id="bulk-product-action" class="dokan-btn" value="<?php esc_attr_e( 'Apply', 'dokan-lite' ); ?>">
						</div>
						<table class="dokan-table dokan-table-striped product-listing-table dokan-inline-editable-table" id="dokan-product-list-table">
							<thead>
								<tr>
									<th id="cb" class="manage-column column-cb check-column">
										<label for="cb-select-all"></label>
										<input id="cb-select-all" class="dokan-checkbox" type="checkbox">
									</th>
									<th><?php esc_html_e( 'Image', 'dokan-lite' ); ?></th>
									<th><?php esc_html_e( 'Name', 'dokan-lite' ); ?></th>
									<th><?php esc_html_e( 'Status', 'dokan-lite' ); ?></th>

									<?php do_action( 'dokan_product_list_table_after_status_table_header' ); ?>

									<th><?php esc_html_e( 'SKU', 'dokan-lite' ); ?></th>
									<th><?php esc_html_e( 'Stock', 'dokan-lite' ); ?></th>
									<th><?php esc_html_e( 'Price', 'dokan-lite' ); ?></th>
									<th><?php esc_html_e( 'Earning', 'dokan-lite' ); ?></th>
									<th><?php esc_html_e( 'Type', 'dokan-lite' ); ?></th>
									<th><?php esc_html_e( 'Views', 'dokan-lite' ); ?></th>
									<th><?php esc_html_e( 'Date', 'dokan-lite' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php
								$pagenum       = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
								$post_statuses = apply_filters( 'dokan_product_listing_post_statuses', [ 'publish', 'draft', 'pending', 'future' ] );
								$get_data      = wp_unslash( $_GET );

								$args = [
									'posts_per_page' => 15,
									'paged'          => $pagenum,
									'author'         => get_current_user_id(),
									'post_status'    => $post_statuses,
									'tax_query'      => [
										[
											'taxonomy' => 'product_type',
											'field'    => 'slug',
											'terms'    => apply_filters( 'dokan_product_listing_exclude_type', [] ),
											'operator' => 'NOT IN',
										],
									],
								];

								if ( isset( $get_data['post_status'] ) && in_array( $get_data['post_status'], $post_statuses ) ) {
									$args['post_status'] = $get_data['post_status'];
								}

								if ( isset( $get_data['date'] ) && 0 != $get_data['date'] ) {
									$args['m'] = $get_data['date'];
								}

								if ( isset( $get_data['product_cat'] ) && -1 != $get_data['product_cat'] ) {
									$args['tax_query'][] = [
										'taxonomy'         => 'product_cat',
										'field'            => 'id',
										'terms'            => (int) $get_data['product_cat'],
										'include_children' => false,
									];
								}

								if ( isset( $get_data['product_search_name'] ) && ! empty( $get_data['product_search_name'] ) ) {
									$args['s'] = $get_data['product_search_name'];
								}

								$original_post = $post;
								$product_args  = apply_filters( 'dokan_pre_product_listing_args', $args, $get_data );
								$product_query = dokan()->product->all( apply_filters( 'dokan_product_listing_arg', $product_args ) );

								if ( $product_query->have_posts() ) {
									while ( $product_query->have_posts() ) {
										$product_query->the_post();

										$row_actions = dokan_product_get_row_action( $post );
										$tr_class    = ( 'pending' == $post->post_status ) ? 'danger' : '';
										$view_class  = ( 'pending' == $post->post_status ) ? 'dokan-hide' : '';
										$product     = wc_get_product( $post->ID );

										$row_args = [
											'post'        => $post,
											'product'     => $product,
											'tr_class'    => $tr_class,
											'row_actions' => $row_actions,
										];

										dokan_get_template_part( 'products/products-listing-row', '', $row_args );

										do_action( 'dokan_product_list_table_after_row', $product, $post );
									}
								} else {
									?>
									<tr>
										<td colspan="11"><?php esc_html_e( 'No product found', 'dokan-lite' ); ?></td>
									</tr>
									<?php
								}
								?>
							</tbody>

						</table>
					</form>
				</div>
					<?php
					wp_reset_postdata();

					$pagenum  = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
					$base_url = dokan_get_navigation_url( 'products' );

					if ( $product_query->max_num_pages > 1 ) {
						echo '<div class="pagination-wrap">';
						$page_links = paginate_links(
							[
								'current'   => $pagenum,
								'total'     => $product_query->max_num_pages,
								'base'      => $base_url . '%_%',
								'format'    => '?pagenum=%#%',
								'add_args'  => false,
								'type'      => 'array',
								'prev_text' => __( '&laquo; Previous', 'dokan-lite' ),
								'next_text' => __( 'Next &raquo;', 'dokan-lite' ),
							]
						);

						echo '<ul class="pagination"><li>';
						echo join( "</li>\n\t<li>", $page_links ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
						echo "</li>\n</ul>\n";
						echo '</div>';
					}
					?>
				</article>

				<?php

				/**
				 *  dokan_dashboard_content_before hook
				 *
				 *  @hooked get_dashboard_side_navigation
				 *
				 *  @since 2.4
				 */
				do_action( 'dokan_dashboard_content_inside_after' );
				do_action( 'dokan_after_listing_product' );
				?>

		</div><!-- #primary .content-area -->

		<?php

		/**
		 *  dokan_dashboard_content_after hook
		 *
		 *  @since 2.4
		 */
		do_action( 'dokan_dashboard_content_after' );
		?>

	</div><!-- .dokan-dashboard-wrap -->

<?php do_action( 'dokan_dashboard_wrap_end' ); ?>
