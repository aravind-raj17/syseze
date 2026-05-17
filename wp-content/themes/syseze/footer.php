<?php
/**
 * Footer — closes <main> and renders the footer block.
 *
 * @package SysEze
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

$address   = nl2br( esc_html( syseze_mod( 'syseze_contact_address', "No 32, Keshava Krupa,\n3rd Cross, Anekal Road,\nChandapura, Bangalore — 560099" ) ) );
$phone     = syseze_mod( 'syseze_contact_phone', '+91 9019435799' );
$phone_tel = preg_replace( '/[^0-9+]/', '', $phone );
$email     = syseze_mod( 'syseze_contact_email', 'hello@syseze.com' );
$tagline   = syseze_mod( 'syseze_footer_tagline', 'IT infrastructure, cloud, and cybersecurity solutions for businesses ready to scale.' );
$copy      = syseze_mod( 'syseze_footer_copyright', '© ' . date( 'Y' ) . ' SysEze Tech Pvt Ltd. All rights reserved.' );
$credit    = syseze_mod( 'syseze_footer_credit', 'Designed by Aravind Raj R' );
?>
</main>

<footer class="footer">
	<div class="container">
		<div class="footer-grid">
			<div>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand"><img src="<?php echo esc_url( syseze_logo_url() ); ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>
				<p class="footer-tagline"><?php echo esc_html( $tagline ); ?></p>
				<?php syseze_render_socials(); ?>
			</div>

			<div>
				<h4><?php esc_html_e( 'Services', 'syseze' ); ?></h4>
				<?php if ( has_nav_menu( 'footer_services' ) ) : ?>
					<?php wp_nav_menu( array( 'theme_location' => 'footer_services', 'container' => false, 'menu_class' => '', 'depth' => 1 ) ); ?>
				<?php else : ?>
					<ul>
						<li><a href="<?php echo esc_url( syseze_page_url( 'cloud-services' ) ); ?>">Cloud Services</a></li>
						<li><a href="<?php echo esc_url( syseze_page_url( 'it-consulting' ) ); ?>">IT Consulting</a></li>
						<li><a href="<?php echo esc_url( syseze_page_url( 'migration-services' ) ); ?>">Migration Services</a></li>
						<li><a href="<?php echo esc_url( syseze_page_url( 'network-design' ) ); ?>">Network Design</a></li>
						<li><a href="<?php echo esc_url( syseze_page_url( 'cyber-security' ) ); ?>">Cyber Security</a></li>
						<li><a href="<?php echo esc_url( syseze_page_url( 'business-support' ) ); ?>">Business Support</a></li>
					</ul>
				<?php endif; ?>
			</div>

			<div>
				<h4><?php esc_html_e( 'Company', 'syseze' ); ?></h4>
				<?php if ( has_nav_menu( 'footer_company' ) ) : ?>
					<?php wp_nav_menu( array( 'theme_location' => 'footer_company', 'container' => false, 'menu_class' => '', 'depth' => 1 ) ); ?>
				<?php else : ?>
					<ul>
						<li><a href="<?php echo esc_url( syseze_page_url( 'about' ) ); ?>">About</a></li>
						<li><a href="<?php echo esc_url( syseze_page_url( 'portfolio' ) ); ?>">Portfolio</a></li>
						<li><a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ) ); ?>">Blog</a></li>
						<li><a href="<?php echo esc_url( syseze_page_url( 'contact' ) ); ?>">Contact</a></li>
						<li><a href="<?php echo esc_url( syseze_page_url( 'terms' ) ); ?>">Terms</a></li>
						<li><a href="<?php echo esc_url( syseze_page_url( 'privacy' ) ); ?>">Privacy</a></li>
					</ul>
				<?php endif; ?>
			</div>

			<div>
				<h4><?php esc_html_e( 'Get in touch', 'syseze' ); ?></h4>
				<address class="footer-contact">
					<?php echo $address; // phpcs:ignore -- already escaped + nl2br'd. ?>
					<br/><br/>
					<a href="tel:<?php echo esc_attr( $phone_tel ); ?>"><?php echo esc_html( $phone ); ?></a>
					<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
				</address>
			</div>
		</div>

		<div class="footer-bottom">
			<span><?php echo esc_html( $copy ); ?></span>
			<span><?php echo esc_html( $credit ); ?></span>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
