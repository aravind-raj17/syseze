<?php
/**
 * Single blog post.
 *
 * @package SysEze
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
$arrow = syseze_arrow();
?>

<section class="page-hero" style="padding-bottom:40px;">
	<?php syseze_orbs(); ?>
	<div class="container" style="position:relative;z-index:2;">
		<div class="breadcrumbs reveal"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span><a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ) ); ?>">Blog</a><span class="sep">/</span><?php the_title(); ?></div>
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) : the_post();
				$cats = get_the_category();
				$cat_name = ! empty( $cats ) ? $cats[0]->name : '';
		?>
		<?php if ( $cat_name ) : ?><span class="eyebrow reveal"><?php echo esc_html( $cat_name ); ?></span><?php endif; ?>
		<h1 class="reveal delay-1"><?php the_title(); ?></h1>
		<p class="lead reveal delay-2" style="margin:0 auto;"><?php echo esc_html( get_the_date() ); ?></p>
	</div>
</section>

<section class="section-tight">
	<div class="container" style="max-width:820px;">
		<div class="reveal single-post-wrap">
			<?php the_content(); ?>
		</div>

		<div style="margin-top:48px; padding-top:32px; border-top:1px solid var(--border); display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
			<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ) ); ?>" class="btn-link" style="transform:scaleX(-1);">
				<?php echo $arrow; ?>
				<span style="transform:scaleX(-1);display:inline-block;">Back to all posts</span>
			</a>
		</div>
	</div>
</section>
<?php
			endwhile;
		endif;
?>

<?php syseze_cta_banner(); ?>

<style>
.post-content h2, .post-content h3, .post-content h4 { color: var(--text); margin: 1.8em 0 0.6em; }
.post-content p { color: var(--text-muted); margin-bottom: 1.4em; }
.post-content a { color: var(--accent-cyan); text-decoration: underline; }
.post-content a:hover { color: #fff; }
.post-content blockquote { border-left: 3px solid var(--accent-purple); padding: 4px 0 4px 20px; margin: 28px 0; color: var(--text); font-style: italic; }
.post-content ul, .post-content ol { color: var(--text-muted); padding-left: 24px; margin-bottom: 1.4em; }
.post-content li { margin-bottom: 8px; }
.post-content img { border-radius: var(--radius); margin: 24px 0; }
.post-content code { background: var(--surface); border: 1px solid var(--border); padding: 2px 6px; border-radius: 4px; font-size: 0.92em; font-family: var(--font-mono); }
.post-content pre { background: var(--surface); border: 1px solid var(--border); padding: 18px 20px; border-radius: var(--radius); overflow-x: auto; font-size: 0.9em; font-family: var(--font-mono); }
.post-content pre code { background: transparent; border: 0; padding: 0; }
</style>

<?php get_footer(); ?>
