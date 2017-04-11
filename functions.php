<?php 

function testThemeOne_resources()
{
	wp_enqueue_style('style', get_stylesheet_uri());
	wp_enqueue_script('main_js', get_template_directory_uri() . '/js/main.js', NULL, 1.0, true);
	
	wp_localize_script('main_js', 'magicalData', array(
		'nonce' => wp_create_nonce('wp_rest'),
		'siteURL' => get_site_url()
	));
	
}

add_action('wp_enqueue_scripts', 'testThemeOne_resources');

// Get Top Ancestor
function get_top_ancestor_id()
{
	global $post;
	
	if($post->post_parent)
	{
		$ancestors = array_reverse(get_post_ancestors($post->ID));
		return $ancestors[0];
	}
	
	return $post->ID;
}

// Does Page Have Children?
function has_children()
{
	global $post;
	
	$pages = get_pages('child_of=' . $post->ID);
	
	return count($pages);
}

// Customize excerpt word count length
function custom_excerpt_length()
{
	return 25;
}

add_filter('excerpt_length', 'custom_excerpt_length');


// Theme Setup
function learningWordPress_setup()
{
	// Navigation Menus
	register_nav_menus(array(
		'primary' => __('Primary Menu'),
		'footer' => __('Footer Menu')
	));
	
	// Add featured image support
	add_theme_support('post-thumbnails');
	add_image_size('small-thumbnail', 180, 120, true);
	add_image_size('banner-image', 920, 210, array('left', 'top'));
	
	// Add post format support
	add_theme_support('post-formats', array('aside', 'gallery', 'link'));
	
}

add_action('after_setup_theme', 'learningWordPress_setup');

// Add Our Widget Locations
function ourWidgetsInit()
{
	register_sidebar( array(
		'name'          => 'Sidebar',
		'id'            => 'sidebar1',
		'before_widget' => '<div class="widget-item">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="my-special-class">',
		'after_title'   => '</h4>',
	) );
	
	register_sidebar( array(
		'name'          => 'Footer Area 1',
		'id'            => 'footer1',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => 'Footer Area 2',
		'id'            => 'footer2',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => 'Footer Area 3',
		'id'            => 'footer3',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => 'Footer Area 4',
		'id'            => 'footer4',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );
}

add_action('widgets_init', 'ourWidgetsInit');

// Customize Appearance Options
function learningWordPress_customize_register($wp_customize)
{
	$wp_customize->add_setting('tto_link_color', array(
		'default' => '#006ec3',
		'transport' => 'refresh',
	));
	
	$wp_customize->add_setting('tto_btn_color', array(
		'default' => '#006ec3',
		'transport' => 'refresh',
	));
	
	$wp_customize->add_section('tto_standart_colors', array(
		'title' => __('Standard Colors', 'TestThemeOne'),
		'priority' => 30,
	));
	
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tto_link_color_control', array(
		'label' => __('Link Color', 'TestThemeOne'), 
		'section' => 'tto_standart_colors',
		'settings' => 'tto_link_color',
	)));
	
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tto_btn_color_control', array(
		'label' => __('Button Color', 'TestThemeOne'), 
		'section' => 'tto_standart_colors',
		'settings' => 'tto_btn_color',
	)));
}

add_action('customize_register', 'learningWordPress_customize_register');

// Output Customize CSS
function learningWordPress_customize_css()
{ 
?>
	<style type="text/css">
		a:link,
		a:visited 
		{
			color: <?php echo get_theme_mod('tto_link_color'); ?>;
		}
		
		.site-header nav ul li.current-menu-item a:link,
		.site-header nav ul li.current-menu-item a:visited,
		.site-header nav ul li.current-page-ancestor a:link,
		.site-header nav ul li.current-page-ancestor a:visited 
		{
			background-color: <?php echo get_theme_mod('tto_link_color'); ?>;
		}
		
		.btn-a,
		.btn-a:link,
		.btn-a:visited,
		div.hd-search #searchsubmit {
			background-color: <?php echo get_theme_mod('tto_btn_color'); ?>;
		}
		
	</style>
<?php 
}

add_action('wp_head', 'learningWordPress_customize_css');

// Add Footer Callout Section to Admin Appearance Customize Screen
function tto_footer_callout($wp_customize)
{
	$wp_customize->add_section('tto-footer-callout-section', array(
		'title' => 'Footer Callout'
	));
	
	//Display
	$wp_customize->add_setting('tto-footer-callout-display', array(
		'default' => 'No'
	));
	
	$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'tto-footer-callout-display-control', array(
		'label' => 'Display this section?',
		'section' => 'tto-footer-callout-section',
		'settings' => 'tto-footer-callout-display',
		'type' => 'select',
		'choices' => array('No' => 'No', 'Yes' => 'Yes')
	)));
	
	//Header
	$wp_customize->add_setting('tto-footer-callout-headline', array(
		'default' => 'Example Headline Text!'
	));
	
	$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'tto-footer-callout-headline-control', array(
		'label' => 'Headline',
		'section' => 'tto-footer-callout-section',
		'settings' => 'tto-footer-callout-headline'
	)));
	
	//Text
	$wp_customize->add_setting('tto-footer-callout-text', array(
		'default' => 'Example paragraph text.'
	));
	
	$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'tto-footer-callout-text-control', array(
		'label' => 'Text',
		'section' => 'tto-footer-callout-section',
		'settings' => 'tto-footer-callout-text',
		'type' => 'textarea'
	)));
	
	//Link
	$wp_customize->add_setting('tto-footer-callout-link');
	
	$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'tto-footer-callout-link-control', array(
		'label' => 'Link',
		'section' => 'tto-footer-callout-section',
		'settings' => 'tto-footer-callout-link',
		'type' => 'dropdown-pages'
	)));
	
	//Image
	$wp_customize->add_setting('tto-footer-callout-image');
	
	$wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'tto-footer-callout-image-control', array(
		'label' => 'Image',
		'section' => 'tto-footer-callout-section',
		'settings' => 'tto-footer-callout-image',
		'width' => 750,
		'height' => 500
	)));
}

add_action('customize_register', 'tto_footer_callout');





















