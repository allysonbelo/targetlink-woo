<?php
/**
 * The WooCommerce shop, category and single product template handler
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$is_catalog = is_shop() || is_product_taxonomy();
?>

<div class="content-area woocommerce-shop-container">
	<?php if ( $is_catalog ) : ?>
		<!-- Shop Hero & Filter Bar -->
		<div class="shop-hero-header">
			<div class="shop-hero-inner">
				<nav class="shop-breadcrumbs">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a>
					<span class="sep">/</span>
					<span class="current">
						<?php 
						if ( is_product_category() ) {
							single_term_title();
						} else {
							echo esc_html__( 'Catálogo', 'targetlink-woo' );
						}
						?>
					</span>
				</nav>

				<div class="shop-header-title-wrap">
					<h1 class="shop-hero-title">
						<?php 
						if ( is_product_category() ) {
							single_term_title();
						} else {
							echo esc_html__( 'Coleção & Catálogo Exclusivo', 'targetlink-woo' );
						}
						?>
					</h1>
					<p class="shop-hero-description">
						<?php 
						if ( is_product_category() && term_description() ) {
							echo wp_strip_all_tags( term_description() );
						} else {
							echo esc_html__( 'Explore a nossa seleção de vestuário e acessórios confeccionados com materiais de alta performance e acabamento artesanal.', 'targetlink-woo' );
						}
						?>
					</p>
				</div>
			</div>

			<?php
			// Category Pills de Filtro Rápido
			$categories = get_terms( array(
				'taxonomy'   => 'product_cat',
				'hide_empty' => true,
			) );

			if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
				$current_cat_id = is_product_category() ? get_queried_object_id() : 0;
			?>
			<div class="shop-filter-bar">
				<span class="filter-label">Filtrar por:</span>
				<div class="shop-category-pills">
					<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="shop-pill <?php echo is_shop() ? 'active' : ''; ?>">
						Todos os Produtos
					</a>
					<?php foreach ( $categories as $cat ) : ?>
						<a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="shop-pill <?php echo ( $current_cat_id === $cat->term_id ) ? 'active' : ''; ?>">
							<?php echo esc_html( $cat->name ); ?>
							<span class="pill-badge"><?php echo esc_html( $cat->count ); ?></span>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<div class="shop-main-content">
		<?php woocommerce_content(); ?>
	</div>
</div>

<?php
get_footer();
