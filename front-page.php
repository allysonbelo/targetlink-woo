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
?>

<div class="home-page-container">

	<!-- 1. Hero Section -->
	<section class="hero-section">
		<div class="hero-content">
			<span class="hero-badge">Nova Coleção 2026</span>
			<h1 class="hero-title">Estilo Minimalista, Performance & Conforto</h1>
			<p class="hero-description">
				Descubra a nossa seleção exclusiva com materiais premium e acabamento refinado. Envio rápido para todo o território europeu.
			</p>
			<div class="hero-actions">
				<?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn-primary">
						Explorar Catálogo
						<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
					</a>
				<?php endif; ?>
				<a href="#destaques" class="btn btn-outline">Ver Destaques</a>
			</div>
		</div>
		<div class="hero-card-preview">
			<div class="preview-badge">🔥 Mais Vendido</div>
			<div class="preview-info">
				<h3>Qualidade Sem Compromissos</h3>
				<p>Tecnologia têxtil avançada para o seu dia a dia.</p>
				<span class="preview-price">A partir de € 12,00</span>
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
				<span>30 dias para trocas fáceis</span>
			</div>
		</div>
		<div class="benefit-item">
			<div class="benefit-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 21 1.9-5.7a8.5 8.5 0 1 1 3.8 3.8z"/></svg>
			</div>
			<div class="benefit-text">
				<strong>Suporte Dedicado</strong>
				<span>Atendimento ágil ao cliente</span>
			</div>
		</div>
	</section>

	<!-- 3. Categorias em Destaque -->
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
			<h2 class="section-title">Compre por Categoria</h2>
			<p class="section-subtitle">Explore os nossos principais departamentos</p>
		</div>
		<div class="categories-grid">
			<?php foreach ( $categories as $cat ) : 
				$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
				$image = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : '';
			?>
				<a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="category-card">
					<?php if ( $image ) : ?>
						<div class="category-image" style="background-image: url('<?php echo esc_url( $image ); ?>');"></div>
					<?php else : ?>
						<div class="category-image category-placeholder"></div>
					<?php endif; ?>
					<div class="category-info">
						<h3><?php echo esc_html( $cat->name ); ?></h3>
						<span><?php echo esc_html( $cat->count ); ?> produtos</span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</section>
	<?php endif; ?>

	<!-- 4. Produtos em Destaque (WooCommerce Grid Dinâmico) -->
	<section id="destaques" class="featured-products-section">
		<div class="section-header">
			<h2 class="section-title">Destaques da Loja</h2>
			<p class="section-subtitle">Os produtos mais procurados pelos nossos clientes</p>
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

	<!-- 5. Banner Promocional / Frete Grátis -->
	<section class="promo-banner-section">
		<div class="promo-banner-card">
			<div class="promo-badge">Oferta Especial</div>
			<h2>Envio Grátis para Todo o País</h2>
			<p>Aproveite portes grátis em todas as encomendas superiores a € 50,00.</p>
			<?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
				<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn-primary">Aproveitar Agora</a>
			<?php endif; ?>
		</div>
	</section>

	<!-- 6. Newsletter / Fidelização -->
	<section class="newsletter-section">
		<div class="newsletter-content">
			<h2>Receba 10% de desconto na primeira compra</h2>
			<p>Subscreva a nossa newsletter e receba novidades exclusivas e lançamentos semanais.</p>
			<form class="newsletter-form" onsubmit="event.preventDefault(); alert('Obrigado pela subscrição!');">
				<input type="email" placeholder="Introduza o seu melhor e-mail..." required />
				<button type="submit" class="btn btn-primary">Subscrever</button>
			</form>
		</div>
	</section>

</div><!-- .home-page-container -->

<?php
get_footer();
