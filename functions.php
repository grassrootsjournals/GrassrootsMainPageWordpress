<?php
function grassroots_theme_enqueue_styles() {

    $parent_style = 'twentysseventeen-style'; // This is 'twentysixteen-style' for the Twenty Sixteen theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/css/grassroots.css',
        array( $parent_style ),
        wp_get_theme()->get('Version'),
        'all'
    );
    wp_enqueue_script( 'child-js',
        get_stylesheet_directory_uri() . '/js/grassroots.js',
        array(),
        wp_get_theme()->get('Version'),
        true // Link to JS in the footer
    );
}
add_action( 'wp_enqueue_scripts', 'grassroots_theme_enqueue_styles' );



/* Remove tracking possibilities  
 * For more information: https://wordpress.org/support/topic/remove-the-new-dns-prefetch-code/
 */
/* Removes the google fonts prefetching:
 * <link rel='dns-prefetch' href='//fonts.googleapis.com'>
 * <link rel='dns-prefetch' href='//s.w.org'>
 * The fonts themselves still need to be removed.
 */
remove_action( 'wp_head', 'wp_resource_hints', 2 );

/* Remove links to Wordpress.org for emojis */
add_filter( 'emoji_svg_url', '__return_false' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

/* TN Dequeue Styles - Remove Google Fonts from Genesis Sample WordPress Theme
 * Taken from: https://technumero.com/remove-google-fonts-from-wordpress-theme/
 * Information on how to move Google fonts to your own server:
 * https://techstuffer.com/serve-google-fonts-from-your-own-server/
 * https://google-webfonts-helper.herokuapp.com/
 */
function grassroots_dequeue_google_fonts_style() {
      wp_dequeue_style( 'twentyseventeen-fonts' );
}
add_action( 'wp_print_styles', 'grassroots_dequeue_google_fonts_style' );
?> 


<?php
/**
 * Setup My Child Theme's textdomain.
 *
 * Declare textdomain for this child theme.
 * Translations can be filed in the /languages/ directory.
 */
function my_child_theme_setup() {
    load_child_theme_textdomain( 'my-child-theme', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'my_child_theme_setup' );

/* For more information: https://codex.wordpress.org/I18n_for_WordPress_Developers
Example how to use this:
<?php
esc_html_e( 'Code is Poetry', 'my-child-theme' );
?>
*/
?>

<?php
/* A child theme can replace a PHP function of the parent by simply declaring it beforehand. 
if ( ! function_exists( 'theme_special_nav' ) ) {
    function theme_special_nav() {
        //  Do something.
    }
}
*/

/*
When you need to include files that reside within your child theme's directory structure, you will use get_stylesheet_directory(). Because the parent template's style.css is replaced by your child theme's style.css, and your style.css resides in the root of your child theme's subdirectory, get_stylesheet_directory() points to your child theme's directory (not the parent theme's directory).

Here's an example, using require_once, that shows how you can use get_stylesheet_directory when referencing a file stored within your child theme's directory structure.

require_once( get_stylesheet_directory() . '/my_included_file.php' );

*/

?>
