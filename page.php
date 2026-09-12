<?php
/**
 * The template for displaying all pages, with custom experiences for Cart and Checkout
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$is_cart_page = function_exists( 'is_cart' ) && is_cart();
?>

<?php if ( $is_cart_page ) : ?>
	<div class="content-area cart-page-wrapper">
		<!-- 1. Background Decorativo com SVGs Flutuantes -->
		<div class="cart-bg-decor" aria-hidden="true">
			<svg class="decor-shape shape-c-1" width="360" height="360" viewBox="0 0 200 200" fill="none">
				<circle cx="100" cy="100" r="85" stroke="rgba(37,99,235,0.06)" stroke-width="30" stroke-dasharray="6 6" />
				<circle cx="100" cy="100" r="45" fill="rgba(37,99,235,0.02)" />
			</svg>
			<svg class="decor-shape shape-c-2" width="280" height="280" viewBox="0 0 120 120" fill="none">
				<polygon points="60 0, 120 60, 60 120, 0 60" stroke="rgba(15,23,42,0.04)" stroke-width="2" />
			</svg>
		</div>

		<!-- 2. Barra Superior & Etapas do Checkout -->
		<div class="cart-header-top">
			<nav class="cart-breadcrumbs">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a>
				<span class="sep">/</span>
				<span class="current">Carrinho de Compras</span>
			</nav>

			<!-- Indicador de Passos do Checkout -->
			<div class="checkout-steps-bar">
				<div class="step-item is-active">
					<span class="step-num">1</span>
					<span class="step-label">Carrinho</span>
				</div>
				<span class="step-divider"></span>
				<div class="step-item">
					<span class="step-num">2</span>
					<span class="step-label">Dados & Pagamento</span>
				</div>
				<span class="step-divider"></span>
				<div class="step-item">
					<span class="step-num">3</span>
					<span class="step-label">Confirmação</span>
				</div>
			</div>
		</div>

		<!-- 3. Título do Carrinho & Barra Inteligente de Portes Grátis -->
		<div class="cart-title-section">
			<h1 class="cart-main-title">O Seu Carrinho</h1>
			<p class="cart-main-subtitle">Reveja os artigos selecionados antes de avançar para o pagamento seguro.</p>
		</div>

		<?php
		// Barra dinâmica de Portes Grátis
		if ( function_exists( 'targetlink_woo_cart_free_shipping_bar' ) ) {
			targetlink_woo_cart_free_shipping_bar();
		}
		?>

		<!-- 4. Conteúdo do Bloco de Carrinho do WooCommerce -->
		<div class="cart-block-container">
			<?php
			while ( have_posts() ) :
				the_post();
				the_content();
			endwhile;
			?>
		</div>

		<!-- 5. Selos de Confiança & Garantias do Carrinho -->
		<div class="cart-trust-badges-grid">
			<div class="cart-trust-card">
				<div class="trust-icon-box">
					<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
				</div>
				<div class="trust-card-text">
					<h4>Checkout 100% Encriptado</h4>
					<p>Transações protegidas com certificado SSL de 256 bits.</p>
				</div>
			</div>

			<div class="cart-trust-card">
				<div class="trust-icon-box">
					<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>
				</div>
				<div class="trust-card-text">
					<h4>Envio Rápido CTT Expresso</h4>
					<p>Entrega em 24h a 48h úteis para Portugal Continental.</p>
				</div>
			</div>

			<div class="cart-trust-card">
				<div class="trust-icon-box">
					<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg>
				</div>
				<div class="trust-card-text">
					<h4>30 Dias para Trocas Grátis</h4>
					<p>Troca de tamanho ou devolução sem perguntas ou burocracia.</p>
				</div>
			</div>

			<div class="cart-trust-card">
				<div class="trust-icon-box">
					<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
				</div>
				<div class="trust-card-text">
					<h4>Pagamentos Locais Seguros</h4>
					<p>Suporte oficial para MB WAY, Multibanco e Cartões.</p>
				</div>
			</div>
		</div>

		<!-- 6. Banner Concierge de Apoio -->
		<div class="cart-support-strip">
			<div class="support-strip-left">
				<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
				<span>Dúvidas com o seu pedido ou tamanhos? A nossa equipa em Portugal está pronta para ajudar.</span>
			</div>
			<div class="support-strip-links">
				<a href="mailto:suporte@simustore.local" class="support-link">Falar com Suporte</a>
				<a href="<?php echo esc_url( home_url( '/#faq' ) ); ?>" class="support-link secondary">Perguntas Frequentes</a>
			</div>
		</div>
	</div>

<?php else : ?>
	<div class="content-area page-content-area">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php if ( ! is_front_page() && ! ( function_exists( 'is_checkout' ) && is_checkout() ) ) : ?>
					<header class="entry-header">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					</header>
				<?php endif; ?>

				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</article>
			<?php
		endwhile;
		?>
	</div>
<?php endif; ?>

<?php
get_footer();
