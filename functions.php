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
 * Hooks & Filtros Específicos para a Página de Produto (Single Product)
 * ==========================================================================
 */

/**
 * 1. Exibe a categoria em pill estilizado acima do título na página do produto
 */
function targetlink_woo_single_category_pill() {
	global $product;
	if ( ! $product ) {
		return;
	}
	$categories = wc_get_product_category_list( $product->get_id(), ', ', '<div class="single-product-cat-pill">', '</div>' );
	if ( $categories && ! is_wp_error( $categories ) ) {
		echo $categories;
	}
}
add_action( 'woocommerce_single_product_summary', 'targetlink_woo_single_category_pill', 4 );

/**
 * 2. Texto amigável do botão de compra na página do produto
 */
function targetlink_woo_single_add_to_cart_text( $text, $product ) {
	if ( ! $product->is_in_stock() ) {
		return esc_html__( 'Produto Esgotado', 'targetlink-woo' );
	}
	return esc_html__( 'Adicionar ao Carrinho', 'targetlink-woo' );
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'targetlink_woo_single_add_to_cart_text', 10, 2 );

/**
 * 3. Formatação moderna e em português do indicador de disponibilidade em stock
 */
function targetlink_woo_custom_availability_text( $availability, $product ) {
	if ( ! $product->is_in_stock() ) {
		return esc_html__( 'Esgotado temporariamente', 'targetlink-woo' );
	}
	$qty = $product->get_stock_quantity();
	if ( $qty ) {
		return sprintf( esc_html__( 'Em Stock (%d unidades prontas para envio)', 'targetlink-woo' ), $qty );
	}
	return esc_html__( 'Em Stock — Pronto para envio em 24h', 'targetlink-woo' );
}
add_filter( 'woocommerce_get_availability_text', 'targetlink_woo_custom_availability_text', 10, 2 );

/**
 * 4. Bloco de Confiança & Garantias (exibido logo abaixo do botão Adicionar ao Carrinho)
 */
function targetlink_woo_single_trust_box() {
	?>
	<div class="product-trust-perks">
		<div class="trust-perk-item">
			<div class="trust-perk-icon-wrap">
				<svg class="trust-perk-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
			</div>
			<div class="trust-perk-text">
				<strong>Envio Rápido 24/48h</strong>
				<span>Entrega via CTT Expresso em Portugal</span>
			</div>
		</div>
		<div class="trust-perk-item">
			<div class="trust-perk-icon-wrap">
				<svg class="trust-perk-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg>
			</div>
			<div class="trust-perk-text">
				<strong>30 Dias para Trocas</strong>
				<span>Trocas simples sem custos adicionais</span>
			</div>
		</div>
		<div class="trust-perk-item">
			<div class="trust-perk-icon-wrap">
				<svg class="trust-perk-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
			</div>
			<div class="trust-perk-text">
				<strong>Pagamento 100% Seguro</strong>
				<span>MB WAY, Multibanco, Cartões e BACS</span>
			</div>
		</div>
		<div class="trust-perk-item">
			<div class="trust-perk-icon-wrap">
				<svg class="trust-perk-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
			</div>
			<div class="trust-perk-text">
				<strong>Qualidade Assegurada</strong>
				<span>Confeção premium e acabamento rigoroso</span>
			</div>
		</div>
	</div>
	<?php
}
add_action( 'woocommerce_single_product_summary', 'targetlink_woo_single_trust_box', 35 );

/**
 * 5. Menus Retráteis (Accordions) para Detalhes, Cuidados e Envios
 */
function targetlink_woo_single_accordions() {
	?>
	<div class="product-summary-accordions">
		<details class="product-accordion-item" open>
			<summary class="accordion-header">
				<span class="accordion-title">
					<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
					Detalhes da Peça & Confeção
				</span>
				<span class="accordion-toggle-icon" aria-hidden="true">+</span>
			</summary>
			<div class="accordion-content">
				<p>Peça concebida com modelagem ergonómica para máximo conforto e elegância natural. Fibras selecionadas de alta densidade que mantêm a estrutura mesmo após uso contínuo.</p>
				<ul class="accordion-bullets">
					<li>Acabamentos interiores reforçados com costura dupla</li>
					<li>Tratamento pré-lavado que previne o encolhimento doméstico</li>
					<li>Etiqueta interna macia sem atrito cutâneo</li>
				</ul>
			</div>
		</details>

		<details class="product-accordion-item">
			<summary class="accordion-header">
				<span class="accordion-title">
					<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"/></svg>
					Instruções de Lavagem & Conservação
				</span>
				<span class="accordion-toggle-icon" aria-hidden="true">+</span>
			</summary>
			<div class="accordion-content">
				<p>Para manter a suavidade das fibras e a vivacidade da cor por longos anos:</p>
				<ul class="accordion-bullets">
					<li>Lavar à máquina em ciclo delicado até 30ºC</li>
					<li>Não usar lixívia ou produtos com cloro ativo</li>
					<li>Secar à sombra, evitando centrifugação agressiva</li>
					<li>Passar pelo avesso com ferro a baixa temperatura (máx. 110ºC)</li>
				</ul>
			</div>
		</details>

		<details class="product-accordion-item">
			<summary class="accordion-header">
				<span class="accordion-title">
					<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
					Prazos de Envio & Devolução Grátis
				</span>
				<span class="accordion-toggle-icon" aria-hidden="true">+</span>
			</summary>
			<div class="accordion-content">
				<p><strong>Portugal Continental:</strong> Entrega em 24h a 48h úteis via CTT Expresso com código de rastreio enviado por SMS.</p>
				<p><strong>Regiões Autónomas:</strong> Entrega em 48h a 72h úteis.</p>
				<p><strong>Trocas e Devoluções:</strong> 30 dias após a receção para solicitar troca de tamanho ou devolução integral gratuita.</p>
			</div>
		</details>
	</div>
	<?php
}
add_action( 'woocommerce_single_product_summary', 'targetlink_woo_single_accordions', 38 );

/**
 * 6. Títulos elegantes em português para as abas do produto
 */
function targetlink_woo_custom_product_tabs( $tabs ) {
	if ( isset( $tabs['description'] ) ) {
		$tabs['description']['title'] = esc_html__( 'Descrição Detalhada', 'targetlink-woo' );
	}
	if ( isset( $tabs['reviews'] ) ) {
		$tabs['reviews']['title'] = esc_html__( 'Avaliações de Clientes', 'targetlink-woo' );
	}
	if ( isset( $tabs['additional_information'] ) ) {
		$tabs['additional_information']['title'] = esc_html__( 'Especificações Técnicas', 'targetlink-woo' );
	}
	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'targetlink_woo_custom_product_tabs', 98 );

/**
 * 7. Título da seção de produtos relacionados
 */
add_filter( 'woocommerce_product_related_products_heading', function() {
	return esc_html__( 'Também Poderá Gostar', 'targetlink-woo' );
} );

/**
 * ==========================================================================
 * Helpers e Otimizações para o Carrinho de Compras (Cart)
 * ==========================================================================
 */

/**
 * Renderiza barra inteligente de progresso de Portes Grátis (Portugal > 50€)
 */
function targetlink_woo_cart_free_shipping_bar() {
	if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
		return;
	}

	$subtotal  = floatval( WC()->cart->get_displayed_subtotal() );
	$threshold = 50.0;
	$is_empty  = WC()->cart->is_empty();

	if ( $is_empty ) {
		return;
	}

	$has_free_shipping = ( $subtotal >= $threshold );
	$percentage        = $has_free_shipping ? 100 : min( 100, max( 12, ( $subtotal / $threshold ) * 100 ) );
	$missing           = $threshold - $subtotal;
	?>
	<div class="cart-free-shipping-box <?php echo $has_free_shipping ? 'is-achieved' : ''; ?>">
		<div class="shipping-box-header">
			<div class="shipping-box-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>
			</div>
			<div class="shipping-box-message">
				<?php if ( $has_free_shipping ) : ?>
					<span>🎉 Parabéns! O seu pedido já tem <strong>Portes de Envio Gratuitos</strong> para Portugal!</span>
				<?php else : ?>
					<span>Faltam apenas <strong><?php echo wc_price( $missing ); ?></strong> para desbloquear <strong>Portes de Envio Grátis</strong>!</span>
				<?php endif; ?>
			</div>
		</div>
		<div class="shipping-progress-track">
			<div class="shipping-progress-fill" style="width: <?php echo esc_attr( $percentage ); ?>%;"></div>
		</div>
	</div>
	<?php
}



