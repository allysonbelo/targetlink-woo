<?php
/**
 * The template for displaying all pages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="content-area page-content-area">
    <?php
    while ( have_posts() ) :
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php if ( ! is_front_page() && ! ( function_exists( 'is_cart' ) && is_cart() ) && ! ( function_exists( 'is_checkout' ) && is_checkout() ) ) : ?>
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

<?php
get_footer();
