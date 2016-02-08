<?php
/**
 * Initializes the theme
 *
 * @since 1.0.0
 *
 * @return void
 */
function garfunkel_child_theme_setup(){
	add_filter( 'the_excerpt_rss', 'garfunkel_child_rss_post_thumbnail' );
	add_filter( 'the_content_feed', 'garfunkel_child_rss_post_thumbnail' );
}
add_action( 'after_setup_theme', 'garfunkel_child_theme_setup' );

/**
 * Enqueue scripts and styles.
 *
 * @since 1.0.0
 *
 * @return void
 */
function garfunkel_child_enqueue_scripts(){
	remove_action( 'wp_print_styles', 'garfunkel_load_style' ); // parent theme improperly hooks to `wp_print_styles`

	wp_register_style('garfunkel_googleFonts',  '//fonts.googleapis.com/css?family=Fira+Sans:400,500,700,400italic,700italic|Playfair+Display:400,900|Crimson+Text:700,400italic,700italic,400' );

	$version = ( file_exists( get_stylesheet_directory() . '/main.css' ) )? filemtime( get_stylesheet_directory() . '/main.css' ) : null ;
	wp_register_style('garfunkel_style', get_stylesheet_directory_uri() . '/main.css', null, $version );

    wp_enqueue_style( 'garfunkel_googleFonts' );
    wp_enqueue_style( 'garfunkel_style' );
}
add_action( 'wp_enqueue_scripts', 'garfunkel_child_enqueue_scripts' );

/**
 * Add search to social menu.
 */
function garfunkel_child_header_search(){
	?>
<style type="text/css">
.search-wrap{position: absolute; right: 46px; width: 220px; display: none; z-index: 999; overflow: hidden;}
.social-search .search-field{padding: 4px 10px;}
</style>
<script type="text/javascript">
jQuery(document).ready(function($){
	$('div.menu-social li.search a').prepend('<div class="search-wrap"><form method="get" class="search-form social-search" action="<?php echo esc_url( home_url( '/' ) ) ?>"><input type="search" value="" placeholder="Enter search..." name="s" class="search-field" id="social-search-field"></form></div>');
	$('div.menu-social li.search a').click(function(e){
		e.preventDefault();
		$('.search-wrap').slideToggle();
	});
	$('.social-search').parent().bind('click',function(e){
		if(e){
			e.stopPropagation();
		}
	});
});
</script>
	<?php
}
add_action( 'wp_head', 'garfunkel_child_header_search' );

/**
 * Adds a post’s featured image to the RSS feed content
 *
 * @since 1.0.0
 *
 * @param string $content Post content.
 * @return string Modified post content.
 */
function garfunkel_child_rss_post_thumbnail( $content ){
	global $post;

	if( has_post_thumbnail( $post->ID ) ){
		// scale image proportionally to 560px wide
		$img_id = get_post_thumbnail_id( $post->ID );

		$img = wp_get_attachment_image_src( $img_id, 'large' );
		$url = $img[0];
		$width = $img[1];
		$height = $img[2];

		$new_width = 560;
		$new_height = intval( ( $new_width * $height ) / $width );

		$featured_image = '<a href="' . get_permalink( $post->ID ) . '"><img src="' . $url . '" width="' . $new_width . '" height="' . $new_height . '" title="' . esc_attr( get_the_title( $post->ID ) ) . '" style="display: block; margin: 0 auto 10px auto;" /></a>';

		$content = $featured_image . $content;
	}

	return $content;
}
?>