<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package dazzling
 */

get_header();

?>
    <?php wp_reset_query(); ?>
	<div id="primary" data="dupa">
		<main id="main" class="site-main" role="main">

			<?php
            function excludeCat($query) {
                if ( $query->is_home ) {
                    $query->set('cat', '-7,-1');
                    }
                return $query;
                }
            add_filter('pre_get_posts', 'excludeCat');
            while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php if( ( !is_home() && !is_front_page() ) ) {?>
    <?php #get_sidebar(); ?>
<?php } ?>
<?php get_footer(); ?>
