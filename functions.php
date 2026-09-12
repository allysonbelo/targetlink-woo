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

/**
 * Remove o título h1 cru padrão do WooCommerce no catálogo
 */
add_filter( 'woocommerce_show_page_title', '__return_false' );

/**
 * Exibe a categoria do produto acima do título no card
 */
function targetlink_woo_card_category_badge() {
	global $product;
	if ( ! $product ) {
		return;
	}
	$categories = wc_get_product_category_list( $product->get_id(), ', ', '<div class="product-card-category">', '</div>' );
	if ( $categories && ! is_wp_error( $categories ) ) {
		echo $categories;
	}
}
add_action( 'woocommerce_shop_loop_item_title', 'targetlink_woo_card_category_badge', 5 );

/**
 * ==========================================================================
 * Hooks Exclusivos para a Página Individual do Produto (Single Product)
 * ==========================================================================
 */

/**
 * 1. Eyebrow com Categoria e Coleção acima do H1 do Produto
 */
function targetlink_woo_single_category_eyebrow() {
	global $product;
	if ( ! $product ) {
		return;
	}
	$categories = wc_get_product_terms( $product->get_id(), 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' ) );
	if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
		echo '<div class="single-product-eyebrow"><a href="' . esc_url( get_term_link( $categories[0] ) ) . '">' . esc_html( $categories[0]->name ) . '</a> <span class="eyebrow-sep">&bull;</span> <span class="eyebrow-tag">COLEÇÃO EXCLUSIVA</span></div>';
	}
}
add_action( 'woocommerce_single_product_summary', 'targetlink_woo_single_category_eyebrow', 3 );

/**
 * 2. Badge Dinâmico de Stock com Pulsing Dot
 */
function targetlink_woo_single_stock_badge() {
	global $product;
	if ( ! $product ) {
		return;
	}
	if ( $product->is_in_stock() ) {
		echo '<div class="single-product-stock-badge in-stock"><span class="pulse-dot"></span> ' . esc_html__( 'Em Stock &bull; Envio Imediato em 24h', 'targetlink-woo' ) . '</div>';
	} else {
		echo '<div class="single-product-stock-badge out-of-stock"><span class="pulse-dot-red"></span> ' . esc_html__( 'Esgotado no Momento', 'targetlink-woo' ) . '</div>';
	}
}
add_action( 'woocommerce_single_product_summary', 'targetlink_woo_single_stock_badge', 12 );

/**
 * 2.1. Botão de Consultoria / Orçamento para peças com Preço sob consulta
 */
function targetlink_woo_empty_price_single_cta() {
	global $product;
	if ( ! $product || '' !== $product->get_price() ) {
		return;
	}
	$product_title = $product->get_title();
	$mailto_url    = 'mailto:suporte@simustore.local?subject=' . rawurlencode( 'Consulta sobre: ' . $product_title );
	echo '<div class="single-product-quote-cta">';
	echo '<a href="' . esc_url( $mailto_url ) . '" class="btn-quote">';
	echo '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>';
	echo esc_html__( 'Falar com Consultor sobre esta Peça', 'targetlink-woo' );
	echo '</a>';
	echo '</div>';
}
add_action( 'woocommerce_single_product_summary', 'targetlink_woo_empty_price_single_cta', 29 );

/**
 * 3. Caixa de Vantagens e Conversão (Trust Box) e Métodos de Pagamento abaixo do botão
 */
function targetlink_woo_single_trust_perks() {
	?>
	<div class="single-product-trust-box">
		<div class="trust-box-item">
			<svg class="trust-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
			<div class="trust-item-content">
				<strong>Portes Grátis</strong>
				<span>Em encomendas superiores a € 50</span>
			</div>
		</div>
		<div class="trust-box-item">
			<svg class="trust-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg>
			<div class="trust-item-content">
				<strong>30 Dias para Trocas</strong>
				<span>Trocas simples e gratuitas em Portugal</span>
			</div>
		</div>
		<div class="trust-box-item">
			<svg class="trust-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
			<div class="trust-item-content">
				<strong>Check-out 100% Blindado</strong>
				<span>Criptografia SSL de 256 bits</span>
			</div>
		</div>
		<div class="trust-box-item">
			<svg class="trust-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
			<div class="trust-item-content">
				<strong>Acabamento de Alfaiataria</strong>
				<span>Garantia de 2 anos de durabilidade</span>
			</div>
		</div>
	</div>

	<div class="single-product-payment-strip">
		<span class="payment-title">Meios de Pagamento Seguros:</span>
		<div class="payment-badges-list">
			<span class="pay-badge">Multibanco</span>
			<span class="pay-badge">MB WAY</span>
			<span class="pay-badge">Visa</span>
			<span class="pay-badge">Mastercard</span>
			<span class="pay-badge">Apple Pay</span>
		</div>
	</div>
	<?php
}
add_action( 'woocommerce_single_product_summary', 'targetlink_woo_single_trust_perks', 35 );

/**
 * 4. Customização e Tradução das Abas do Produto (Tabs)
 */
function targetlink_woo_custom_product_tabs( $tabs ) {
	if ( isset( $tabs['description'] ) ) {
		$tabs['description']['title'] = esc_html__( 'Descrição Detalhada', 'targetlink-woo' );
	}
	if ( isset( $tabs['reviews'] ) ) {
		$tabs['reviews']['title'] = esc_html__( 'Avaliações dos Clientes', 'targetlink-woo' );
	}
	$tabs['size_guide'] = array(
		'title'    => esc_html__( 'Guia de Tamanhos & Envio', 'targetlink-woo' ),
		'priority' => 15,
		'callback' => 'targetlink_woo_size_guide_tab_content',
	);
	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'targetlink_woo_custom_product_tabs' );

/**
 * 5. Personaliza o texto do botão no Single Product
 */
function targetlink_woo_single_add_to_cart_text( $text, $product ) {
	if ( ! $product->is_in_stock() ) {
		return esc_html__( 'Esgotado', 'targetlink-woo' );
	}
	return esc_html__( 'Adicionar ao Carrinho', 'targetlink-woo' );
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'targetlink_woo_single_add_to_cart_text', 10, 2 );

function targetlink_woo_size_guide_tab_content() {
	?>
	<div class="tab-size-guide-wrapper">
		<h3>Tabela de Medidas de Referência (cm)</h3>
		<p>Todas as peças da nossa coleção seguem rigorosamente a anatomia e o padrão de modelagem europeu.</p>
		<div class="table-responsive">
			<table class="size-guide-table">
				<thead>
					<tr>
						<th>Tamanho</th>
						<th>Peito (cm)</th>
						<th>Cintura (cm)</th>
						<th>Quadril (cm)</th>
						<th>Comprimento Manga (cm)</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><strong>S / 36-38</strong></td>
						<td>88 - 92</td>
						<td>70 - 74</td>
						<td>94 - 98</td>
						<td>61</td>
					</tr>
					<tr>
						<td><strong>M / 40-42</strong></td>
						<td>96 - 100</td>
						<td>78 - 82</td>
						<td>102 - 106</td>
						<td>63</td>
					</tr>
					<tr>
						<td><strong>L / 44-46</strong></td>
						<td>104 - 108</td>
						<td>86 - 90</td>
						<td>110 - 114</td>
						<td>64</td>
					</tr>
					<tr>
						<td><strong>XL / 48-50</strong></td>
						<td>112 - 116</td>
						<td>94 - 98</td>
						<td>118 - 122</td>
						<td>65</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="tab-shipping-note">
			<h4>Prazos de Entrega & Garantia</h4>
			<ul>
				<li><strong>Portugal Continental:</strong> 24h a 48h úteis via CTT Expresso (Portes grátis > €50).</li>
				<li><strong>Ilhas (Madeira e Açores):</strong> 2 a 5 dias úteis com código de rastreamento enviado por e-mail/SMS.</li>
				<li><strong>Política de Troca:</strong> Se o tamanho não ficar perfeito, realizamos a troca do seu artigo gratuitamente no prazo de 30 dias.</li>
			</ul>
		</div>
	</div>
	<?php
}

/**
 * 5. Título Personalizado para os Produtos Relacionados
 */
function targetlink_woo_related_products_heading() {
	return esc_html__( 'Complete o Seu Visual & Peças Relacionadas', 'targetlink-woo' );
}
add_filter( 'woocommerce_product_related_products_heading', 'targetlink_woo_related_products_heading' );


