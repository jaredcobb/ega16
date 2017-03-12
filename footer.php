<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ega16
 */

// Attempt to get the credits from any page named "credits".
$args = array(
	'name' => 'credits',
	'post_type' => 'page',
	'post_status' => 'publish',
	'numberposts' => 1,
);
$credits_query = new WP_Query( $args );
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer row align-center" role="contentinfo">
		<div class="site-info small-12 columns text-center">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'ega16' ) ); ?>" target="_blank"><?php echo esc_html__( 'C:\WORDPRESS>', 'ega16' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( '%1$s by %2$s.', 'ega16' ), '<a href="https://github.com/jaredcobb/ega16" target="_blank">EGA 16</a>', 'Jared Cobb' ); ?>
			<?php if ( $credits_query->post_count ) : ?>
				<span class="sep"> | </span>
				<a data-open="ega-credits" class="credits"><?php echo esc_html__( 'Credits', 'ega16' ); ?></a>
			<?php endif; ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
	<?php if ( $credits_query->post_count ) : ?>
		<div class="reveal" id="ega-credits" data-reveal>
			<h4><?php echo esc_html( apply_filters( 'the_title', $credits_query->posts[0]->post_title ) );?></h4>
			<?php echo wp_kses_post( apply_filters( 'the_content', $credits_query->posts[0]->post_content ) ); ?>
		</div>
	<?php endif; ?>
	<div class="reveal" id="ega-win" data-reveal>
	</div>
</div><!-- #page -->

<?php wp_footer(); ?>
<script>
$(document).foundation();
</script>

</body>
</html>
