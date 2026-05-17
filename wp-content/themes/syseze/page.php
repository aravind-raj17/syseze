<?php
/**
 * Generic page fallback.
 *
 * @package SysEze
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
?>

<section class="page-hero" style="padding-bottom:40px;">
	<?php syseze_orbs(); ?>
	<div class="container" style="position:relative;z-index:2;">
		<div class="breadcrumbs reveal"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span><?php the_title(); ?></div>
		<h1 class="reveal delay-1"><?php the_title(); ?></h1>
	</div>
</section>

<section class="section-tight">
	<div class="container" style="max-width:820px;">
		<article class="reveal post-content" style="color:var(--text); font-size:1.05rem; line-height:1.8;">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); the_content(); endwhile; endif; ?>
		</article>
	</div>
</section>

<style>
.post-content h2, .post-content h3 { color: var(--text); margin: 1.6em 0 0.5em; }
.post-content p { color: var(--text-muted); margin-bottom: 1.2em; }
.post-content a { color: var(--accent-cyan); text-decoration: underline; }
.post-content ul, .post-content ol { color: var(--text-muted); padding-left: 22px; margin-bottom: 1.2em; }
</style>

<?php get_footer(); ?>
