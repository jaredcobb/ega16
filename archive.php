<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ega16
 */

$global_sidebar_enabled = get_theme_mod( 'global_sidebar_enabled', true );

get_header(); ?>

	<div id="primary" class="small-12 <?php echo $global_sidebar_enabled ? 'medium-8 ' : ''; ?>columns">

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

	</div><!-- #primary -->

<?php
if ( $global_sidebar_enabled ) {
	get_sidebar();
}
get_footer();
