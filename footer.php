	</main><!-- #primary -->

	<footer class="site-footer">
		<div class="footer-container">
			<div class="footer-grid">
				<!-- Coluna 1: Marca & Missão -->
				<div class="footer-col footer-brand">
					<h3 class="footer-logo"><?php bloginfo( 'name' ); ?></h3>
					<p class="footer-bio">
						Moda contemporânea e alfaiataria com foco em design minimalista, matérias-primas sustentáveis e durabilidade.
					</p>
					<div class="footer-badge-secure">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
						<span>Pagamentos 100% Encriptados SSL</span>
					</div>
				</div>

				<!-- Coluna 2: Navegação Rápida -->
				<div class="footer-col">
					<h4 class="footer-heading">Coleções</h4>
					<ul class="footer-links">
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Página Inicial</a></li>
						<?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
							<li><a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">Catálogo Completo</a></li>
						<?php endif; ?>
						<li><a href="<?php echo esc_url( home_url( '/#destaques' ) ); ?>">Destaques da Temporada</a></li>
						<li><a href="<?php echo esc_url( home_url( '/#categorias' ) ); ?>">Comprar por Categoria</a></li>
					</ul>
				</div>

				<!-- Coluna 3: Apoio ao Cliente -->
				<div class="footer-col">
					<h4 class="footer-heading">Apoio ao Cliente</h4>
					<ul class="footer-links">
						<li><a href="<?php echo esc_url( home_url( '/#faq' ) ); ?>">Perguntas Frequentes (FAQ)</a></li>
						<li><a href="#">Envios e Prazos de Entrega</a></li>
						<li><a href="#">Trocas e Devoluções (30 Dias)</a></li>
						<li><a href="#">Termos de Serviço & Privacidade</a></li>
					</ul>
				</div>

				<!-- Coluna 4: Pagamentos & Segurança -->
				<div class="footer-col">
					<h4 class="footer-heading">Métodos de Pagamento</h4>
					<p class="footer-payment-text">Disponibilizamos meios de pagamento locais e internacionais seguros:</p>
					<div class="payment-badges-grid">
						<span class="payment-badge">Multibanco</span>
						<span class="payment-badge">MB WAY</span>
						<span class="payment-badge">Visa</span>
						<span class="payment-badge">Mastercard</span>
						<span class="payment-badge">Apple Pay</span>
						<span class="payment-badge">BACS</span>
					</div>
				</div>
			</div>

			<div class="footer-bottom">
				<p class="copyright-text">
					&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>. Todos os direitos reservados.
				</p>
				<p class="developer-credit">
					Desenvolvido com foco em alta performance e experiência mobile-first.
				</p>
			</div>
		</div>
	</footer><!-- .site-footer -->
</div><!-- .site-wrapper -->

<?php wp_footer(); ?>
</body>
</html>
