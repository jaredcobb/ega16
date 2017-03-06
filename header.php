<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ega16
 */

?><!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">

		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<div id="page" class="site">

			<header id="masthead" class="site-header" role="banner">

				<?php if ( true === get_theme_mod( 'points_enabled' ) || true === get_theme_mod( 'audio_enabled' ) ) : ?>

					<div id="game-header" class="top-bar">

				<?php endif; ?>

					<?php
					if ( true === get_theme_mod( 'points_enabled' ) ) :
						$score = EGA16_Points::instance()->get_score();
						$total_points = EGA16_Points::instance()->get_total_points();
					?>

						<div class="top-bar-left">
							<ul class="menu">
								<li><span class="points"><?php echo wp_kses_post( sprintf( __( 'Score: <span class="score">%1$s</span> of %2$s ' ), $score, $total_points ) ); ?></span></li>
							</ul>
						</div>

					<?php endif; ?>

					<?php if ( true === get_theme_mod( 'audio_enabled' ) ) : ?>

						<div class="top-bar-right">
							<ul class="menu">
								<li><a class="audio-toggle">Sound: off</a></li>
							</ul>
						</div>

					<?php endif; ?>

				<?php if ( true === get_theme_mod( 'points_enabled' ) || true === get_theme_mod( 'audio_enabled' ) ) : ?>

					</div>

				<?php endif; ?>

				<!-- Start Top Bar -->
				<nav id="site-navigation" class="top-bar main-navigation" role="navigation">
					<div class="top-bar-left">
					<?php
						wp_nav_menu( array(
							'theme_location' => 'primary',
							'container' => false,
							'menu' => 'Primary Menu',
							'menu_class' => 'menu',
							'depth' => 0,
							'items_wrap' => '<ul id="%1$s" class="%2$s" data-parent-link="true" data-auto-height="true" data-responsive-menu="drilldown medium-dropdown" data-back-button="<li class=\'js-drilldown-back\'><a tabindex=\'0\'><span>&#9668;</span> Back</a></li>">%3$s</ul>',
							'walker' => new EGA16_Foundation_Topbar_Walker(),
						) );
					?>
					</div>
					<div class="top-bar-right">
						<ul class="menu">
							<li class="crt-toggle"><a><?php echo esc_html( ega16_crt_enabled() ? __( 'CRT: on', 'ega16' ) : __( 'CRT: off', 'ega16' ) ); ?></a></li>
						</ul>
					</div>
				</nav>
				<!-- End Top Bar -->

			</header><!-- #masthead -->

			<?php
			if ( true === get_theme_mod( 'global_callout_enabled' ) || ( true === get_theme_mod( 'homepage_callout_enabled' ) && is_home() ) ) {
				?>
				<div class="row column align-center">
					<div class="callout large primary">
						<div>
							<?php echo wp_kses_post( ( true === get_theme_mod( 'homepage_callout_enabled' ) && is_home() ) ? get_theme_mod( 'homepage_callout_content' ) : get_theme_mod( 'global_callout_content' ) ); ?>
						</div>
					</div>
				</div>
			<?php
			}
			?>

			<div id="content" class="row">
