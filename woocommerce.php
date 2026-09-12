<?php
/**
 * The WooCommerce shop, category and single product template handler
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="content-area woocommerce-shop-container">
    <?php woocommerce_content(); ?>
</div>

<?php
get_footer();
