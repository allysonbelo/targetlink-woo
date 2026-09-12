# TargetLink Woo Demo - Custom WooCommerce Theme

Tema sob medida desenvolvido do zero para WordPress e WooCommerce, focado em **Mobile-First**, **Alta Performance (Core Web Vitals)** e arquitetura limpa sem dependência de page builders pesados.

---

## 🎯 Objetivo do Projeto
Demonstrar a implementação técnica integral de uma loja WooCommerce:
- Arquitetura de tema moderno com CSS Vanilla e variáveis semânticas.
- Suporte nativo completo ao WooCommerce (`add_theme_support('woocommerce')`, galeria com zoom, lightbox e slider).
- Templates otimizados para fluxo de conversão (catálogo responsivo, carrinho e checkout limpo).
- Otimização de entrega de assets (remoção seletiva de estilos não utilizados).
- Estrutura pronta para versionamento e ambiente de staging.

## 🛠️ Tecnologias & Estrutura
- **PHP 8.x**
- **WordPress 6.x**
- **WooCommerce 8.x+**
- **CSS3 Vanilla** (Variáveis CSS, CSS Grid, Flexbox, Mobile-First)
- **HTML5 Semântico**

## 📂 Organização de Diretórios
```text
targetlink-woo/
├── woocommerce/          # Sobrescrita de templates WooCommerce (se aplicável)
├── functions.php         # Definições, hooks e suporte WooCommerce
├── header.php            # Cabeçalho semântico e navegação
├── footer.php            # Rodapé estruturado
├── index.php             # Template fallback padrão
├── style.css             # Declarações do tema, tokens e estilização
└── README.md             # Documentação técnica
```

## 🚀 Instalação Local
1. Clone ou adicione este repositório dentro do diretório `wp-content/themes/` da sua instalação WordPress:
   ```bash
   cd wp-content/themes/
   git clone https://github.com/allysonbelo/targetlink-woo.git
   ```
2. No painel do WordPress, navegue até **Aparência > Temas** e ative o tema **TargetLink Woo Demo**.
3. Certifique-se de que o plugin **WooCommerce** está instalado e ativado.

---
Desenvolvido por [Allyson Belo](https://github.com/allysonbelo).
