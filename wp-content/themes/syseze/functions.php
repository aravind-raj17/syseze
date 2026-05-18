<?php
/**
 * SysEze theme bootstrap.
 *
 * @package SysEze
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'SYSEZE_VERSION', '1.2.0' );

require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/enqueue.php';
require_once get_template_directory() . '/inc/cpt.php';
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/template-helpers.php';
require_once get_template_directory() . '/inc/contact-handler.php';
require_once get_template_directory() . '/inc/blog-seed.php';
require_once get_template_directory() . '/inc/seo.php';
