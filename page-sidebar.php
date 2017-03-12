<?php
/**
 * Template Name: Page With Sidebar
 *
 * @package ega16
 */

get_header(); ?>

	<div id="primary" class="small-12 medium-8 columns">

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
