<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package ega16
 */

get_header(); ?>

	<div id="primary" class="small-12 columns">

		<section class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title"><?php echo ! empty( get_theme_mod( '404_title' ) ) ? esc_html( get_theme_mod( '404_title' ) ) : esc_html_e( 'Oops! That page can&rsquo;t be found.', 'ega16' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content">

				<?php echo ! empty( get_theme_mod( '404_content' ) ) ? '<div class="custom-content">' . wp_kses_post( get_theme_mod( '404_content' ) ) . '</div>' : ''; ?>

				<p><?php esc_html_e( 'Maybe you can try searching for it...', 'ega16' ); ?></p>

				<?php
				get_search_form();

				if ( empty( get_theme_mod( '404_content' ) ) ) :
					the_widget( 'WP_Widget_Recent_Posts' );

					// Only show the widget if site has multiple categories.
					if ( ega16_categorized_blog() ) :
				?>

				<div class="widget widget_categories">
					<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'ega16' ); ?></h2>
					<ul>
					<?php
						wp_list_categories( array(
							'orderby'    => 'count',
							'order'      => 'DESC',
							'show_count' => 1,
							'title_li'   => '',
							'number'     => 10,
						) );
					?>
					</ul>
				</div><!-- .widget -->

				<?php
					endif;

					/* translators: %1$s: smiley */
					$archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'ega16' ), convert_smilies( ':)' ) ) . '</p>';
					the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );

					the_widget( 'WP_Widget_Tag_Cloud' );
				endif;
				?>

			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</div><!-- #primary -->

<?php
get_footer();
