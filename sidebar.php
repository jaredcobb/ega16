<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ega16
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}

$global_sidebar_sticky = get_theme_mod( 'global_sidebar_sticky', true );

?>

<div id="sidebar-wrapper" class="columns" <?php echo $global_sidebar_sticky ? 'data-sticky-container' : ''; ?>>
	<aside id="secondary" class="widget-area <?php echo $global_sidebar_sticky ? 'sticky' : ''; ?>" <?php echo $global_sidebar_sticky ? 'data-sticky data-anchor="content"' : ''; ?> role="complementary">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</aside><!-- #secondary -->
</div>
