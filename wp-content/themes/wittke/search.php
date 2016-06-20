<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package dazzling
 */

get_header(); ?>
		<section id="primary">
			<main id="main" class="site-main" role="main">

			<?php
                function excludeCat($query) {
                if ( $query->is_home ) {
                    $query->set('cat', '-7,-1');
                    }
                return $query;
                }
                if ( have_posts() ) : ?>



				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'search' ); ?>

				<?php endwhile; ?>

				<?php dazzling_paging_nav(); ?>

			<?php else : ?>

				<?php get_template_part( 'content', 'none' ); ?>

			<?php endif; ?>

			</main><!-- #main -->
		</section><!-- #primary -->

<?php #get_sidebar(); ?>
<?php get_footer(); ?>
