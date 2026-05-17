<?php
/**
 * Template Name: Contact
 *
 * @package SysEze
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
$arrow = syseze_arrow();

$address    = nl2br( esc_html( syseze_mod( 'syseze_contact_address', "No 32, Keshava Krupa,\n3rd Cross, Anekal Road,\nChandapura, Bangalore — 560099" ) ) );
$phone      = syseze_mod( 'syseze_contact_phone', '+91 9019435799' );
$phone_tel  = preg_replace( '/[^0-9+]/', '', $phone );
$email      = syseze_mod( 'syseze_contact_email', 'hello@syseze.com' );
$hours      = nl2br( esc_html( syseze_mod( 'syseze_contact_hours', "Mon – Fri: 9:00 AM – 7:00 PM IST\nSaturday: 10:00 AM – 2:00 PM IST\nSunday: Closed" ) ) );
$cf_short   = trim( syseze_mod( 'syseze_cf7_shortcode', '' ) );
?>

<section class="page-hero">
	<?php syseze_orbs(); ?>
	<div class="container" style="position:relative;z-index:2;">
		<div class="breadcrumbs reveal"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span>Contact</div>
		<span class="eyebrow reveal">Get in touch</span>
		<h1 class="reveal delay-1">Let's <span class="gradient-text">talk.</span></h1>
		<p class="lead reveal delay-2">Whether you're ready to start a project, exploring options, or just have a question — we're easy to reach and quick to respond.</p>
	</div>
</section>

<section class="section-tight">
	<div class="container">
		<div class="contact-grid">
			<div class="form-card reveal">
				<h2>Send us a message</h2>
				<p class="form-intro">We typically respond within 1 business day.</p>

				<?php if ( $cf_short ) : ?>
					<?php echo do_shortcode( $cf_short ); ?>
				<?php else : ?>
					<!-- Static fallback. Set a Contact Form 7 shortcode in Customizer ▸ SysEze — Contact Form to replace this. -->
					<form id="contact-form" novalidate>
						<div class="form-row">
							<div class="field"><label for="name">Full name *</label><input id="name" name="name" type="text" required /></div>
							<div class="field"><label for="email">Email address *</label><input id="email" name="email" type="email" required /></div>
						</div>
						<div class="form-row">
							<div class="field"><label for="company">Company name</label><input id="company" name="company" type="text" /></div>
							<div class="field"><label for="phone">Phone number</label><input id="phone" name="phone" type="tel" /></div>
						</div>
						<div class="field">
							<label for="service">Service you're interested in</label>
							<select id="service" name="service">
								<option value="">Not sure yet</option>
								<option>Cloud Services</option>
								<option>IT Consulting</option>
								<option>Migration Services</option>
								<option>Network Design</option>
								<option>Cyber Security</option>
								<option>Business Support</option>
							</select>
						</div>
						<div class="field">
							<label for="message">How can we help? *</label>
							<textarea id="message" name="message" required placeholder="A few lines about your project, your stack, or your timeline."></textarea>
						</div>
						<label class="field-check"><input type="checkbox" name="newsletter" /><span>I'd like to receive occasional updates from SysEze.</span></label>
						<button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">Send Message <?php echo $arrow; ?></button>
						<div id="form-status" class="form-status" role="status" aria-live="polite"></div>
					</form>
				<?php endif; ?>
			</div>

			<aside class="info-card reveal delay-1">
				<h2 style="font-size:1.4rem;margin-bottom:24px;">Get in touch directly</h2>

				<div class="info-block">
					<span class="info-label">Office</span>
					<p><?php echo $address; ?></p>
				</div>
				<div class="info-block">
					<span class="info-label">Phone</span>
					<p><a href="tel:<?php echo esc_attr( $phone_tel ); ?>"><?php echo esc_html( $phone ); ?></a></p>
				</div>
				<div class="info-block">
					<span class="info-label">Email</span>
					<p><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></p>
				</div>
				<div class="info-block">
					<span class="info-label">Hours</span>
					<p><?php echo $hours; ?></p>
				</div>

				<?php syseze_render_socials(); ?>
			</aside>
		</div>
	</div>
</section>

<section class="section-tight">
	<div class="container">
		<div class="map-wrap reveal">
			<iframe src="https://www.google.com/maps?q=Chandapura%2C%20Bangalore%2C%20India&output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="SysEze office location — Chandapura, Bangalore"></iframe>
		</div>
	</div>
</section>

<?php get_footer(); ?>
