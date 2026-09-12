<?php
/**
 * The Front Page template
 *
 * Exibe uma Home completa, moderna e com foco em conversão para a loja.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$hero_img = get_theme_file_uri( 'assets/images/hero-banner.jpg' );
?>

<div class="home-page-container">

	<!-- 1. Hero Section com Imagem Editorial & Animações -->
	<section class="hero-section">
		<div class="hero-grid">
			<div class="hero-content">
				<div class="hero-badge animate-fade-in">
					<span class="live-dot"></span> Nova Coleção Outono / Inverno
				</div>
				<h1 class="hero-title animate-slide-up">Estilo Atemporal, Performance & Elegância</h1>
				<p class="hero-description animate-slide-up-delay">
					Conheça a nossa curadoria exclusiva de peças confeccionadas com acabamento impecável. Entregas expressas para todo o território europeu.
				</p>
				
				<div class="hero-actions animate-slide-up-delay-2">
					<?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
						<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn-primary">
							Explorar Coleção
							<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
						</a>
					<?php endif; ?>
					<a href="#destaques" class="btn btn-outline">Ver Destaques</a>
				</div>

				<div class="hero-social-proof">
					<div class="stars">★★★★★</div>
					<span><strong>4.9/5</strong> de satisfação por mais de 2.500 clientes</span>
				</div>
			</div>

			<div class="hero-image-wrapper">
				<div class="hero-image-card">
					<img src="<?php echo esc_url( $hero_img ); ?>" alt="Coleção Premium" class="hero-img" />
					<div class="hero-floating-card animate-float">
						<div class="floating-badge">Tendência 2026</div>
						<h4>Alfaiataria Contemporânea</h4>
						<span class="floating-price">A partir de € 25,00</span>
						<div class="floating-stock">
							<span class="stock-dot"></span> Em estoque limitado
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- 2. Value Propositions / Bar de Benefícios -->
	<section class="benefits-bar">
		<div class="benefit-item">
			<div class="benefit-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>
			</div>
			<div class="benefit-text">
				<strong>Envio Rápido & Seguro</strong>
				<span>Entregas expressas em 24/48h</span>
			</div>
		</div>
		<div class="benefit-item">
			<div class="benefit-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
			</div>
			<div class="benefit-text">
				<strong>Pagamento Protegido</strong>
				<span>Multibanco, MB WAY & Cartão</span>
			</div>
		</div>
		<div class="benefit-item">
			<div class="benefit-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg>
			</div>
			<div class="benefit-text">
				<strong>Troca Garantida</strong>
				<span>30 dias para devoluções fáceis</span>
			</div>
		</div>
		<div class="benefit-item">
			<div class="benefit-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 21 1.9-5.7a8.5 8.5 0 1 1 3.8 3.8z"/></svg>
			</div>
			<div class="benefit-text">
				<strong>Suporte Dedicado</strong>
				<span>Atendimento técnico de excelência</span>
			</div>
		</div>
	</section>

	<!-- 3. Categorias em Destaque (com Imagens Dinâmicas dos Produtos) -->
	<?php
	$categories = get_terms( array(
		'taxonomy'   => 'product_cat',
		'hide_empty' => true,
		'number'     => 4,
	) );

	if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
	?>
	<section class="categories-section">
		<div class="section-header">
			<span class="section-tag">Coleções</span>
			<h2 class="section-title">Compre por Categoria</h2>
			<p class="section-subtitle">Descubra as peças ideais para cada momento</p>
		</div>
		<div class="categories-grid">
			<?php foreach ( $categories as $cat ) : 
				// 1. Tenta pegar thumbnail da categoria
				$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
				$image = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : '';

				// 2. Se não tiver imagem na categoria, busca o primeiro produto da categoria
				if ( empty( $image ) && function_exists( 'wc_get_products' ) ) {
					$products_in_cat = wc_get_products( array(
						'category' => array( $cat->slug ),
						'limit'    => 1,
						'status'   => 'publish',
					) );
					if ( ! empty( $products_in_cat ) ) {
						$first_prod = $products_in_cat[0];
						$img_id = $first_prod->get_image_id();
						if ( $img_id ) {
							$image = wp_get_attachment_image_url( $img_id, 'medium' );
						}
					}
				}
			?>
				<a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="category-card">
					<div class="category-img-container">
						<?php if ( $image ) : ?>
							<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $cat->name ); ?>" class="cat-img" />
						<?php else : ?>
							<div class="category-placeholder">
								<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l8.57-8.57A4 4 0 1 1 18 8.84l-8.59 8.57a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
							</div>
						<?php endif; ?>
						<span class="category-count-badge"><?php echo esc_html( $cat->count ); ?> itens</span>
					</div>
					<div class="category-info">
						<h3><?php echo esc_html( $cat->name ); ?></h3>
						<span class="category-link-text">Ver catálogo &rarr;</span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</section>
	<?php endif; ?>

	<!-- 4. Produtos em Destaque (WooCommerce Grid Dinâmico Corrigido) -->
	<section id="destaques" class="featured-products-section">
		<div class="section-header">
			<span class="section-tag">Catálogo</span>
			<h2 class="section-title">Destaques da Loja</h2>
			<p class="section-subtitle">Os produtos mais desejados com disponibilidade imediata</p>
		</div>

		<div class="products-container">
			<?php
			if ( function_exists( 'woocommerce_product_loop' ) ) {
				echo do_shortcode( '[products limit="8" columns="4" orderby="date" order="DESC"]' );
			}
			?>
		</div>

		<div class="section-footer-action">
			<?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
				<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn-secondary">
					Ver Todos os Produtos
					<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
				</a>
			<?php endif; ?>
		</div>
	</section>

	<!-- 5. Banner Promocional / Frete Grátis com Visual Rico -->
	<section class="promo-banner-section">
		<div class="promo-banner-card">
			<div class="promo-badge">Portes Grátis</div>
			<h2>Envio Grátis para Todo o País</h2>
			<p>Faça a sua encomenda hoje e receba sem custos adicionais de envio em compras superiores a € 50,00.</p>
			<?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
				<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn-promo">Comprar com Portes Grátis</a>
			<?php endif; ?>
		</div>
	</section>

	<!-- 6. Newsletter / Fidelização -->
	<section class="newsletter-section">
		<div class="newsletter-content">
			<span class="section-tag">Desconto Exclusivo</span>
			<h2>Receba 10% de desconto na primeira compra</h2>
			<p>Junte-se à nossa lista VIP e tenha acesso antecipado a novas coleções e ofertas sazonais.</p>
			<form class="newsletter-form" onsubmit="event.preventDefault(); alert('Subscrição efetuada com sucesso!');">
				<input type="email" placeholder="Introduza o seu melhor e-mail..." required />
				<button type="submit" class="btn btn-primary">Subscrever</button>
			</form>
		</div>
	</section>

</div><!-- .home-page-container -->

<?php
get_footer();
