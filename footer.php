<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>

		</div><!-- #content -->

		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="wrap">
				<?php
				get_template_part( 'template-parts/footer/footer', 'widgets' );

				if ( has_nav_menu( 'social' ) ) :
					?>
					<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'twentyseventeen' ); ?>">
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'social',
									'menu_class'     => 'social-links-menu',
									'depth'          => 1,
									'link_before'    => '<span class="screen-reader-text">',
									'link_after'     => '</span>' . twentyseventeen_get_svg( array( 'icon' => 'chain' ) ),
								)
							);
						?>
					</nav><!-- .social-navigation -->
					<?php
				endif;
				// get_template_part( 'template-parts/footer/site', 'info' );
				?>
				<div class="site-info">
					<a href="<?php echo esc_url( __( '/', 'twentyseventeen' ) ); ?>" class="imprint">
						<?php printf( __( '%s', 'twentyseventeen-child' ), 'Grassroots Journals' ); ?>
					</a>
					<span role="separator" aria-hidden="true"></span>
					<a href="<?php echo esc_url( __( '/technology/', 'twentyseventeen' ) ); ?>" class="imprint">
						<?php printf( __( '%s', 'twentyseventeen-child' ), 'Technology' ); ?>
					</a>
					<span role="separator" aria-hidden="true"></span>
					<a href="<?php echo esc_url( __( '/to-do-list/', 'twentyseventeen' ) ); ?>" class="imprint">
						<?php printf( __( '%s', 'twentyseventeen-child' ), 'To do list' ); ?>
					</a>
					<?php
					if ( function_exists( 'the_privacy_policy_link' ) ) {
						the_privacy_policy_link( '<br>', '' );
					}
					?>
					<span role="separator" aria-hidden="true"></span>
					<a href="<?php echo esc_url( __( 'https://www2.meteo.uni-bonn.de/venema/', 'twentyseventeen' ) ); ?>" class="imprint">
						<?php printf( __( '%s', 'twentyseventeen-child' ), 'Contact' ); ?>
					</a>

				</div><!-- .site-info -->					
			</div><!-- .wrap -->
		</footer><!-- #colophon -->
	</div><!-- .site-content-contain -->
</div><!-- #page -->
<?php wp_footer(); ?>

</body>
</html>
