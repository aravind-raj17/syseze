<?php
/**
 * 404 — page not found.
 *
 * @package SysEze
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
$arrow = syseze_arrow();
?>

<section class="notfound">
	<?php syseze_orbs(); ?>
	<div style="position:relative;z-index:2;">
		<div class="code">404</div>
		<span class="eyebrow" style="justify-content:center;">Page not found</span>
		<h1>Lost in the cloud?</h1>
		<p>The page you were looking for has been moved, renamed, or never existed. Let's get you back on track.</p>
		<div class="notfound-ctas">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">Back to home <?php echo $arrow; ?></a>
			<a href="<?php echo esc_url( syseze_page_url( 'contact' ) ); ?>" class="btn btn-ghost">Contact us</a>
		</div>
	</div>
</section>

<?php get_footer(); ?>
