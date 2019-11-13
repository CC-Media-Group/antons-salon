<?php

class Services {
    public $pageid;

    public function ccmedia_services($pageid){
        global $post;
        $child_pages_query_args = array(
            'post_type'   => 'page',
            'post_parent' => $pageid,
            'orderby' => 'title',
            'order'   => 'ASC'
        );
        $child_pages = new WP_Query( $child_pages_query_args );
        echo '<h2>' . get_the_title($pageid) . '</h2><br>';
        echo "<div style='display: flex; flex-direction: row; flex-wrap: wrap;'>";
        while ( $child_pages->have_posts() ) : $child_pages->the_post();
           echo "<div style='flex: 1 0 25%; margin: 5px;'>";
           echo '<a href="' . get_permalink() . '">';
           the_title();
           echo '<br>';
           if(has_post_thumbnail()) :
           the_post_thumbnail('full');
           endif;
           echo '</a>';
           echo "</div>";
           echo "<hr>";
        endwhile;
        echo "</div>";
        wp_reset_postdata();
    }
}

class Utilities {

  public function __construct() {
    #### Add MSPA 'M' Image For Navigation Menu Item
    add_shortcode( 'mspa_image', array($this, 'ccmedia_mspa_menu_image') );
    ### Dynamically add page title on page
    add_shortcode('page_title',array($this, 'ccmedia_page_title'));
  }

  public function ccmedia_service_pages($content) {
  	if(is_page('services')) {
  		$services = new Services();
  		$content .= $services->ccmedia_services(24);
  		$content .= $services->ccmedia_services(38);
  		$content .= $services->ccmedia_services(64);
  	}
  	return $content;
  }

  public function ccmedia_page_title(){
  	ob_start();
  	echo esc_html( get_the_title() );
  	return ob_get_clean();
  }

  public function ccmedia_add_fonts() {
  	return array( 'Bodoni MT' );
  }

  public function ccmedia_mspa_menu_image( $atts ) {
  	// Attributes
  	$atts = shortcode_atts(
  		array('class' => ''),
  		$atts,
  		'mspa_image'
  	);
  	$img = '<span class="' . $atts['class'] . '"></span>';
  		return $img;
  }

  public function ccmedia_header_social() {
  	echo '<span>Hello World</span>';
  }
}
$custom_fonts = new Utilities();
$hook = new Utilities();


class WHScripts {
  public function total_child_enqueue_parent_theme_style() {// Dynamically get version number of the parent stylesheet (lets browsers re-cache your stylesheet when you update your theme)
  	$theme   = wp_get_theme( 'Total' );
  	$version = $theme->get( 'Version' );

  	// Load the stylesheet
  	wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css', array(), $version );
    // enqueue script
  	wp_enqueue_script('ccmedia-scripts', get_stylesheet_directory_uri() .'/js/scripts.js', array(), '1.0.24', true);
  }
}
$wh_scripts = new WHScripts();
