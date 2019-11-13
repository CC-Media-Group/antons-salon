<?php
/**
 * Child theme functions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Text Domain: wpex
 * @link http://codex.wordpress.org/Plugin_API
 *
 */

/**
 * Load the parent style.css file
 *
 * @link http://codex.wordpress.org/Child_Themes
 */
#### Includes
require_once 'includes/utilities.class.php';

#### Action Hooks
add_action( 'wp_enqueue_scripts', array($wh_scripts, 'total_child_enqueue_parent_theme_style') );
add_action('wpex_hook_header_inner', array($hook, 'ccmedia_header_social'));

#### Filter Hooks
add_filter('the_content', array($hook, 'ccmedia_service_pages'));

#### Minify HTML Output
function ccmedia_sanitize_output($buffer) {
    $search = array(
        '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
        '/[^\S ]+\</s',     // strip whitespaces before tags, except space
        '/(\s)+/s',         // shorten multiple whitespace sequences
        //'/<!--(.|\s)*?-->/' // Remove HTML comments
    );
    $replace = array( '>', '<', '\\1', '' );
		$buffer = preg_replace($search, $replace, $buffer);
    return $buffer;
}
ob_start("ccmedia_sanitize_output");

#### Add Image For MSPA Navigation Menu Item
$custom_fonts->ccmedia_add_fonts();
