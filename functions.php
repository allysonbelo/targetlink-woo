<?php
/**
 * TargetLink Woo Demo functions and definitions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Setup Theme and WooCommerce Support
 */
function targetlink_woo_setup() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// Switch default core markup for search form, comment form, and comments to output valid HTML5.
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Suporte nativo ao ecossistema WooCommerce
	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 300,
		'single_image_width'    => 600,
        'product_grid'          => array(
            'default_rows'    => 3,
            'min_rows'        => 2,
            'max_rows'        => 8,
            'default_columns' => 4,
            'min_columns'     => 2,
            'max_columns'     => 5,
        ),
	) );

	// Registra menus de navegação
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Menu Principal', 'targetlink-woo' ),
		)
	);

	// WooCommerce Features
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'targetlink_woo_setup' );

/**
 * Atualização assíncrona do mini-carrinho via AJAX fragments
 */
function targetlink_woo_cart_link_fragment( $fragments ) {
	ob_start();
	targetlink_woo_cart_link();
	$fragments['a.cart-custom-location'] = ob_get_clean();
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'targetlink_woo_cart_link_fragment' );

/**
 * Helper de renderização do link do carrinho no Header
 */
function targetlink_woo_cart_link() {
	if ( ! function_exists( 'wc_get_cart_url' ) || ! function_exists( 'WC' ) ) {
		return;
	}
	$count = ( WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0;
	?>
	<a class="cart-custom-location header-cart-link" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'Ver seu carrinho de compras', 'targetlink-woo' ); ?>">
		<span class="cart-icon" aria-hidden="true">
			<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><line x1="3" x2="21" y1="6" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
		</span>
		<span class="cart-label">Carrinho</span>
		<span class="cart-count"><?php echo esc_html( $count ); ?></span>
	</a>
	<?php
}

/**
 * Enqueue scripts and styles.
 */
function targetlink_woo_scripts() {
	wp_enqueue_style( 'targetlink-woo-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );

    // Podemos enfileirar JS aqui depois para otimizações específicas de checkout
}
add_action( 'wp_enqueue_scripts', 'targetlink_woo_scripts' );

/**
 * Remover CSS padrão do WordPress que não usamos para melhorar velocidade (Performance Requirement)
 */
function targetlink_woo_remove_wp_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-blocks-style' ); // Remove blocks do Woo se for usar layout classico focado em vel
}
// Descomentar a linha abaixo para habilitar otimização extrema de CSS
// add_action( 'wp_enqueue_scripts', 'targetlink_woo_remove_wp_block_library_css', 100 );

/**
 * Adiciona badge visual de "Esgotado" para produtos fora de estoque na listagem
 */
function targetlink_woo_out_of_stock_badge() {
	global $product;
	if ( ! $product ) {
		return;
	}
	if ( ! $product->is_in_stock() ) {
		echo '<span class="badge-out-of-stock">' . esc_html__( 'Esgotado', 'targetlink-woo' ) . '</span>';
	}
}
add_action( 'woocommerce_before_shop_loop_item_title', 'targetlink_woo_out_of_stock_badge', 10 );

/**
 * Personaliza o texto do botão do catálogo
 * Se estiver esgotado -> "Esgotado"
 * Se não tiver preço cadastrado -> "Ver detalhes"
 */
function targetlink_woo_custom_add_to_cart_text( $text, $product ) {
	if ( ! $product->is_in_stock() ) {
		return esc_html__( 'Esgotado', 'targetlink-woo' );
	}
	if ( '' === $product->get_price() ) {
		return esc_html__( 'Ver detalhes', 'targetlink-woo' );
	}
	return $text;
}
add_filter( 'woocommerce_product_add_to_cart_text', 'targetlink_woo_custom_add_to_cart_text', 10, 2 );

/**
 * Exibe indicação elegante quando o produto não possui preço cadastrado
 */
function targetlink_woo_empty_price_html( $price, $product ) {
	if ( '' === $product->get_price() ) {
		return '<span class="price-empty">' . esc_html__( 'Preço sob consulta', 'targetlink-woo' ) . '</span>';
	}
	return $price;
}
add_filter( 'woocommerce_get_price_html', 'targetlink_woo_empty_price_html', 10, 2 );

/**
 * Substitui o thumbnail padrão do catálogo para exibir a primeira imagem da galeria no Hover
 */
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

function targetlink_woo_template_loop_product_thumbnail() {
	global $product;
	if ( ! $product ) {
		return;
	}

	$image_id          = $product->get_image_id();
	$gallery_image_ids = $product->get_gallery_image_ids();
	$has_gallery       = ! empty( $gallery_image_ids );

	echo '<div class="product-thumbnail-wrapper ' . ( $has_gallery ? 'has-hover-image' : '' ) . '">';

	// 1. Imagem Principal (Capa)
	if ( $image_id ) {
		echo wp_get_attachment_image( $image_id, 'woocommerce_thumbnail', false, array( 'class' => 'product-primary-img' ) );
	} else {
		echo wc_placeholder_img( 'woocommerce_thumbnail', array( 'class' => 'product-primary-img' ) );
	}

	// 2. Primeira Imagem da Galeria (Exibida suavemente no Hover)
	if ( $has_gallery ) {
		$secondary_image_id = $gallery_image_ids[0];
		echo wp_get_attachment_image( $secondary_image_id, 'woocommerce_thumbnail', false, array( 'class' => 'product-secondary-img' ) );
	}

	echo '</div>';
}
add_action( 'woocommerce_before_shop_loop_item_title', 'targetlink_woo_template_loop_product_thumbnail', 10 );

