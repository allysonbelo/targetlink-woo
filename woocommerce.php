<?php
/**
 * The WooCommerce shop, category and single product template handler
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$is_catalog = is_shop() || is_product_taxonomy();
$is_single  = is_product();
?>

<div class="content-area <?php echo $is_single ? 'woocommerce-single-wrapper' : 'woocommerce-shop-container'; ?>">

	<?php if ( $is_single ) : ?>
		<!-- ==================================================================
		     EXPERIÊNCIA PREMIUM: PÁGINA DE PRODUTO ÚNICO (SINGLE PRODUCT)
		     ================================================================== -->

		<!-- 1. Background Decorativo com SVGs Flutuantes -->
		<div class="single-product-bg-decor" aria-hidden="true">
			<svg class="decor-shape shape-orb-1" width="380" height="380" viewBox="0 0 200 200" fill="none">
				<circle cx="100" cy="100" r="90" stroke="rgba(37,99,235,0.06)" stroke-width="30" stroke-dasharray="8 8" />
				<circle cx="100" cy="100" r="50" fill="rgba(37,99,235,0.03)" />
			</svg>
			<svg class="decor-shape shape-orb-2" width="280" height="280" viewBox="0 0 120 120" fill="none">
				<polygon points="60 0, 120 60, 60 120, 0 60" stroke="rgba(15,23,42,0.04)" stroke-width="2" />
				<circle cx="60" cy="60" r="25" stroke="rgba(37,99,235,0.05)" stroke-width="1.5" />
			</svg>
		</div>

		<!-- 2. Barra Superior de Breadcrumbs & Garantias -->
		<div class="single-product-top-bar">
			<nav class="single-breadcrumbs">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a>
				<span class="sep">/</span>
				<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">Catálogo</a>
				<?php
				$product_id = get_queried_object_id();
				if ( $product_id ) :
					$terms = get_the_terms( $product_id, 'product_cat' );
					if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) :
						$main_term = $terms[0];
						?>
						<span class="sep">/</span>
						<a href="<?php echo esc_url( get_term_link( $main_term ) ); ?>"><?php echo esc_html( $main_term->name ); ?></a>
					<?php endif; ?>
					<span class="sep">/</span>
					<span class="current"><?php echo esc_html( get_the_title( $product_id ) ); ?></span>
				<?php endif; ?>
			</nav>

			<div class="single-top-badge">
				<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
				<span>Garantia Simustore: Devolução grátis em 30 dias</span>
			</div>
		</div>

		<!-- 3. Palco Principal do Produto do WooCommerce -->
		<div class="single-product-stage-wrapper">
			<?php woocommerce_content(); ?>
		</div>

		<!-- 4. Seção Destaques de Materiais & Engenharia da Peça (4 Cards com SVGs) -->
		<section class="single-product-highlights-section">
			<div class="section-header">
				<span class="section-tag">Engenharia Têxtil</span>
				<h2 class="section-title">A Anatomia da Peça Perfeita</h2>
				<p class="section-subtitle">Cada centímetro é desenvolvido com rigor de alfaiataria e respeito ao meio ambiente</p>
			</div>

			<div class="product-highlights-grid">
				<div class="highlight-feature-card">
					<div class="highlight-icon-wrap">
						<svg class="highlight-svg" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect width="64" height="64" rx="16" fill="rgba(37,99,235,0.08)" />
							<path d="M20 44C20 44 24 20 44 20C44 20 44 44 20 44Z" stroke="#2563eb" stroke-width="3" stroke-linejoin="round" />
							<path d="M28 36L36 28" stroke="#2563eb" stroke-width="2" stroke-linecap="round" />
							<circle cx="32" cy="32" r="2" fill="#2563eb" />
						</svg>
					</div>
					<h3>Fibras Naturais Puras</h3>
					<p>Tecido de densidade superior com toque macio na pele, garantindo regulação térmica e respirabilidade durante todo o dia.</p>
				</div>

				<div class="highlight-feature-card">
					<div class="highlight-icon-wrap">
						<svg class="highlight-svg" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect width="64" height="64" rx="16" fill="rgba(16,185,129,0.08)" />
							<path d="M18 32H46M32 18V46" stroke="#10b981" stroke-width="3" stroke-linecap="round" />
							<circle cx="32" cy="32" r="16" stroke="#10b981" stroke-width="2" stroke-dasharray="4 4" />
						</svg>
					</div>
					<h3>Corte Ergonómico</h3>
					<p>Desenvolvido com padrões de caimento anatómico que acompanham a postura sem apertar ou limitar movimentos.</p>
				</div>

				<div class="highlight-feature-card">
					<div class="highlight-icon-wrap">
						<svg class="highlight-svg" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect width="64" height="64" rx="16" fill="rgba(245,158,11,0.08)" />
							<path d="M32 16L44 24V40L32 48L20 40V24L32 16Z" stroke="#f59e0b" stroke-width="3" stroke-linejoin="round" />
							<path d="M32 24V40" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" />
						</svg>
					</div>
					<h3>Costura Reforçada Dupla</h3>
					<p>Pontos interiores travados com fios de alta tenacidade, prevenindo o desgaste prematuro nas zonas de maior tensão.</p>
				</div>

				<div class="highlight-feature-card">
					<div class="highlight-icon-wrap">
						<svg class="highlight-svg" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect width="64" height="64" rx="16" fill="rgba(99,102,241,0.08)" />
							<rect x="18" y="22" width="28" height="22" rx="4" stroke="#6366f1" stroke-width="3" />
							<path d="M18 28H46M32 22V44" stroke="#6366f1" stroke-width="2" />
						</svg>
					</div>
					<h3>Embalagem Zero Plástico</h3>
					<p>Envio em caixa de cartão rígido reciclável com papel vegetal certificado FSC, aromatizada e pronta para presente.</p>
				</div>
			</div>
		</section>

		<!-- 5. Tabela Oficial de Medidas & Caimento -->
		<section class="single-product-size-guide">
			<div class="size-guide-card">
				<div class="size-guide-header">
					<div class="size-guide-badge">Tabela de Medidas</div>
					<h2>Encontre o Seu Tamanho Ideal</h2>
					<p>Medidas aproximadas do produto em centímetros. Na dúvida entre dois tamanhos, recomendamos optar pelo tamanho acima para um caimento mais confortável.</p>
				</div>

				<div class="size-guide-table-responsive">
					<table class="size-guide-table">
						<thead>
							<tr>
								<th>Tamanho</th>
								<th>Peito (cm)</th>
								<th>Cintura (cm)</th>
								<th>Comprimento (cm)</th>
								<th>Ombro a Ombro (cm)</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><strong>S (Pequeno)</strong></td>
								<td>92 - 96</td>
								<td>78 - 82</td>
								<td>70</td>
								<td>43</td>
							</tr>
							<tr>
								<td><strong>M (Médio)</strong></td>
								<td>97 - 102</td>
								<td>83 - 88</td>
								<td>72</td>
								<td>45</td>
							</tr>
							<tr>
								<td><strong>L (Grande)</strong></td>
								<td>103 - 108</td>
								<td>89 - 94</td>
								<td>74</td>
								<td>47</td>
							</tr>
							<tr>
								<td><strong>XL (Extra Grande)</strong></td>
								<td>109 - 115</td>
								<td>95 - 101</td>
								<td>76</td>
								<td>49</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="size-guide-footer-tip">
					<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
					<span>Dica de Caimento: O modelo na fotografia veste tamanho <strong>M</strong> e mede 1,84m de altura. Se preferir um estilo mais solto e descontraído, escolha um tamanho superior.</span>
				</div>
			</div>
		</section>

		<!-- 6. Banner Concierge de Estilo com SVG Decorativo -->
		<section class="shop-concierge-banner single-product-concierge">
			<svg class="concierge-pattern-svg" viewBox="0 0 800 300" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
				<circle cx="750" cy="50" r="180" stroke="rgba(255,255,255,0.06)" stroke-width="30" />
				<circle cx="750" cy="50" r="100" stroke="rgba(255,255,255,0.08)" stroke-width="2" stroke-dasharray="6 6" />
				<rect x="30" y="180" width="80" height="80" rx="20" stroke="rgba(255,255,255,0.05)" stroke-width="2" />
				<line x1="0" y1="280" x2="800" y2="280" stroke="rgba(255,255,255,0.04)" stroke-width="1" />
			</svg>

			<div class="concierge-content">
				<div class="concierge-badge">Apoio Personalizado</div>
				<h2>Dúvidas sobre o caimento ou medidas desta peça?</h2>
				<p>Fale diretamente com os nossos consultores de estilo em Portugal para receber uma recomendação sob medida em minutos.</p>
				<div class="concierge-actions">
					<a href="mailto:suporte@simustore.local" class="btn btn-primary">Falar com um Consultor</a>
					<a href="<?php echo esc_url( home_url( '/#faq' ) ); ?>" class="btn btn-outline">Perguntas Frequentes</a>
				</div>
			</div>
		</section>

	<?php else : ?>
		<!-- ==================================================================
		     CATÁLOGO / SHOP & TAXONOMIAS
		     ================================================================== -->
		<!-- Shop Hero & Filter Bar com SVGs de Fundo -->
		<div class="shop-hero-header">
			<!-- SVG decorativo abstrato de fundo -->
			<div class="shop-hero-bg-shapes" aria-hidden="true">
				<svg class="bg-shape shape-1" width="320" height="320" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
					<circle cx="100" cy="100" r="80" stroke="rgba(37,99,235,0.07)" stroke-width="40" />
					<circle cx="100" cy="100" r="40" fill="rgba(37,99,235,0.03)" />
				</svg>
				<svg class="bg-shape shape-2" width="240" height="240" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
					<polygon points="50 0, 100 50, 50 100, 0 50" stroke="rgba(15,23,42,0.04)" stroke-width="2" />
					<polygon points="50 15, 85 50, 50 85, 15 50" stroke="rgba(37,99,235,0.05)" stroke-width="1.5" />
				</svg>
			</div>

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
					<span class="section-tag">Coleção 2026</span>
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

			<!-- Mini Bar de Vantagens da Loja -->
			<div class="shop-quick-perks">
				<div class="perk-item">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
					<span>Envio expresso 24/48h</span>
				</div>
				<div class="perk-item">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
					<span>Portes grátis acima de € 50</span>
				</div>
				<div class="perk-item">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg>
					<span>30 dias para trocas simples</span>
				</div>
				<div class="perk-item">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
					<span>Check-out blindado SSL</span>
				</div>
			</div>
		</div>

		<!-- Grid Principal de Produtos do WooCommerce -->
		<div class="shop-main-content">
			<?php woocommerce_content(); ?>
		</div>

		<!-- Seções Extras para Enriquecer o Catálogo -->
		<!-- 1. Guia de Escolha & Qualidade com SVGs Ilustrativos -->
		<section class="shop-guide-section">
			<div class="section-header">
				<span class="section-tag">Padrão de Qualidade</span>
				<h2 class="section-title">Como Garantimos o Caimento Perfeito</h2>
				<p class="section-subtitle">Cada peça é pensada para durabilidade e máximo conforto no dia a dia</p>
			</div>

			<div class="shop-guide-grid">
				<div class="guide-card">
					<div class="guide-icon-wrap">
						<svg class="guide-svg" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect width="64" height="64" rx="16" fill="rgba(37,99,235,0.08)" />
							<path d="M32 16L44 24V40L32 48L20 40V24L32 16Z" stroke="#2563eb" stroke-width="3" stroke-linejoin="round" />
							<path d="M32 16V48" stroke="#2563eb" stroke-width="2" stroke-dasharray="3 3" />
							<circle cx="32" cy="32" r="5" fill="#3b82f6" />
						</svg>
					</div>
					<h3>Modelagem & Caimento</h3>
					<p>Nossos padrões seguem medidas europeias rigorosas, com cortes ergonómicos que se ajustam naturalmente aos movimentos do corpo.</p>
				</div>

				<div class="guide-card">
					<div class="guide-icon-wrap">
						<svg class="guide-svg" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect width="64" height="64" rx="16" fill="rgba(16,185,129,0.08)" />
							<path d="M22 36C22 36 26 44 32 44C38 44 42 36 42 36" stroke="#10b981" stroke-width="3" stroke-linecap="round" />
							<path d="M32 20V44" stroke="#10b981" stroke-width="3" stroke-linecap="round" />
							<path d="M22 28C22 28 26 20 32 20C38 20 42 28 42 28" stroke="#10b981" stroke-width="3" stroke-linecap="round" />
						</svg>
					</div>
					<h3>Tecidos Nobres & Fibras Puras</h3>
					<p>Trabalhamos com algodão orgânico de fibras longas e linho europeu pré-encolhido que não perdem o toque macio mesmo após dezenas de lavagens.</p>
				</div>

				<div class="guide-card">
					<div class="guide-icon-wrap">
						<svg class="guide-svg" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect width="64" height="64" rx="16" fill="rgba(245,158,11,0.08)" />
							<path d="M18 24H46V44H18V24Z" stroke="#f59e0b" stroke-width="3" stroke-linejoin="round" />
							<path d="M32 24V44" stroke="#f59e0b" stroke-width="2" />
							<path d="M18 32H46" stroke="#f59e0b" stroke-width="2" />
							<circle cx="32" cy="20" r="4" stroke="#f59e0b" stroke-width="2" />
						</svg>
					</div>
					<h3>Embalagem Zero Plástico</h3>
					<p>Todas as encomendas do nosso catálogo são enviadas em caixas de cartão 100% reciclável com papel seda vegetal, prontas para presente.</p>
				</div>
			</div>
		</section>

		<!-- 2. Banner de Suporte & Concierge com Padrão Geométrico SVG -->
		<section class="shop-concierge-banner">
			<!-- Padrão geométrico de fundo em SVG -->
			<svg class="concierge-pattern-svg" viewBox="0 0 800 300" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
				<circle cx="750" cy="50" r="180" stroke="rgba(255,255,255,0.06)" stroke-width="30" />
				<circle cx="750" cy="50" r="100" stroke="rgba(255,255,255,0.08)" stroke-width="2" stroke-dasharray="6 6" />
				<rect x="30" y="180" width="80" height="80" rx="20" stroke="rgba(255,255,255,0.05)" stroke-width="2" />
				<line x1="0" y1="280" x2="800" y2="280" stroke="rgba(255,255,255,0.04)" stroke-width="1" />
			</svg>

			<div class="concierge-content">
				<div class="concierge-badge">Suporte Especializado</div>
				<h2>Tem dúvidas sobre tamanhos ou tecidos?</h2>
				<p>A nossa equipa de consultores de estilo está pronta para ajudá-lo a encontrar a peça perfeita para a sua silhueta em poucos minutos.</p>
				<div class="concierge-actions">
					<a href="mailto:suporte@simustore.local" class="btn btn-primary">Falar com um Consultor</a>
					<a href="<?php echo esc_url( home_url( '/#faq' ) ); ?>" class="btn btn-outline">Consultar Perguntas Frequentes</a>
				</div>
			</div>
		</section>
	<?php endif; ?>

</div>

<?php
get_footer();

