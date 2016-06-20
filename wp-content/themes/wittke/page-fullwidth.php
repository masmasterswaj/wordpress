<?php
/**
 * Template Name: Full-width(no sidebar)
 *
 * This is the template that displays full width page without sidebar
 *
 * @package dazzling
 */

get_header(); ?>
	<div id="primary">
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

<?php get_footer(); ?>
