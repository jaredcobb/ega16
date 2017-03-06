<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ega16
 */

$global_sidebar_enabled = get_theme_mod( 'global_sidebar_enabled', true );

get_header(); ?>

	<div id="primary" class="small-12 <?php echo $global_sidebar_enabled ? 'medium-8 ' : ''; ?>columns">

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', get_post_format() );

			the_post_navigation();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

	</div><!-- #primary -->

<?php
if ( $global_sidebar_enabled ) {
	get_sidebar();
}
get_footer();
