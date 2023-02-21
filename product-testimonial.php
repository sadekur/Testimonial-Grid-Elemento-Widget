<?php
/*
Plugin Name: Product Testimonial 
Plugin URI: https://google.com
Description: Product Testimonial 
Version: 1.0.0
Author: SRS
Author URI: https://google.com
License: GPLv2 or later
Text Domain: arg
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
define('ARGPLUGINPATH', plugin_dir_path(__FILE__));

function arg_scripts() {
	wp_enqueue_style( 'arg-style', plugins_url ( 'css/style.css', __FILE__), '', time(), false );
	wp_enqueue_style( 'css2', plugins_url ( 'css/css2.css', __FILE__), '', time(), false );
	wp_enqueue_script( 'arg-main', plugins_url ( 'js/jquery.min.js', __FILE__), '', time(), true );
	wp_enqueue_script( 'arg-main', plugins_url ( 'js/main.js', __FILE__), '', time(), true );
}
add_action( 'wp_enqueue_scripts', 'arg_scripts' );

function arg_script_admin(){
	wp_enqueue_style( 'admincss', plugins_url ( 'css/product-testimonial-admin.css', __FILE__), '', time(), false );
	wp_enqueue_script( 'wpnhtp', plugins_url ( 'js/wpnhtp.js', __FILE__), '', time(), true );
	wp_enqueue_script( 'iris', plugins_url ( 'js/iris.min.js', __FILE__), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), false, 1 );
	wp_enqueue_script( 'cp-active', plugins_url ( 'js/cp-active.js', __FILE__), '', time(), true );
	wp_enqueue_script( 'admin-js', plugins_url ( 'js/admin-product-testimonial.js', __FILE__), '', time(), true );
	wp_localize_script( 'admin-js', 'ARRG', [ 'ajaxurl' => admin_url( 'admin-ajax.php' ) ] );
}
add_action( 'admin_enqueue_scripts', 'arg_script_admin' );

/**
* 	Post Type: WP Product Testimonials.
*/
function arg_register_testimonial() {
	$labels = [
		"name" => __( "Testimonial Grid", "arg" ),
		"singular_name" => __( "Testimonial Grid", "arg" ),
		"menu_name" => __( "Testimonial Grid", "arg" ),
		"all_items" => __( "All Testimonial", "arg" ),
		"add_new" => __( "Add New Testimonial", "arg" ),
		"add_new_item" => __( "Add New Testimonial", "arg" ),
		"edit_item" => __( "Edit Testimonial", "arg" ),
		"new_item" => __( "New Testimonial", "arg" ),
		"view_item" => __( "View Testimonial", "arg" ),
		"view_items" => __( "View All Testimonial", "arg" ),
		"search_items" => __( "Search Testimonial", "arg" ),
		"not_found" => __( "Not Testimonial Found", "arg" ),
		"not_found_in_trash" => __( "No Testimonial Found in Trush", "arg" ),
		"featured_image" => __( "Client Image", "arg" ),
		"set_featured_image" => __( "Client Image", "arg" ),
		"remove_featured_image" => __( "Remove client image", "arg" ),
		"archives" => __( "Testimonial archives", "arg" ),
		"insert_into_item" => __( "Insert into Testimonial", "arg" ),
		"filter_items_list" => __( "Filter Testimonial List", "arg" ),
		"items_list_navigation" => __( "Testimonial list navigation", "arg" ),
		"items_list" => __( "Testimonial list", "arg"),
		"item_reverted_to_draft" => __( "Testimonial reverted to draft", "arg" ),
	];
	$args = [
		"label" => __( "Custom WP Testimonial", "arg" ),
		"labels" => $labels,
		"description" => "Custom WP Testimonial for your Business.",
		"public" => true,
		'menu_icon' =>'dashicons-testimonial',
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => false,
		"rewrite" => [ "slug" => "product-testimonial", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail", "custom-fields" ],
		"show_in_graphql" => false,
	];

	register_post_type( "arg", $args );
}

add_action( 'init', 'arg_register_testimonial' );
function arg_shortcode($atts) {
	$atts = shortcode_atts( array(
		'count' 	=> 6, 
		'columns' 	=> 3, 
	), $atts, 'wpt_grid' );
    
    // Query
	$args = array(
		'post_type'		=> 'arg',
		'posts_per_page'=> $atts['count'],
	);
	$query = new WP_Query( $args );

 	//Get number of columns from the query
    $columns = absint( get_query_var( 'columns' ) );
    if ( $columns ) {
        $args['posts_per_page'] = $columns * ceil( $atts['count'] / $columns );
    }

    if ( $query->have_posts() ) {
    	?>
    	<main class="container card-grid">
    		<?php
    		while ( $query->have_posts() ) {
    			$query->the_post();
    			?>
    			<article class="card grey">
    				<figure class="profile">
    					<div>
    						<img
    						class="avatar"
    						src="<?php echo get_the_post_thumbnail_url( get_the_ID(),'full' ); ?>"
    						alt="jonathan's image"
    						/>
    					</div>
    					<figcaption class="profile-info">
    						<h2 class="profile-name"><?php echo get_post_meta( get_the_ID(), 'testmonial_name', true ); ?></h2>
    						<p class="profile-title"><?php echo get_post_meta( get_the_ID(), 'test_designation', true ); ?></p>
    					</figcaption>
    				</figure>
    				<div class="testimonials">
    					<h1 class="heading">
    						<?php the_title(); ?>
    					</h1>
    					<blockquote>
    						“ <?php the_excerpt(); ?> ”
    					</blockquote>
    				</div>
    			</article>
    			<?php
    		}
    		wp_reset_postdata();?>
    	</main>
    	<?php
    }
}
add_shortcode("wpt_grid", "arg_shortcode");

//Limite description length
add_filter( 'get_the_excerpt', 'wpt_excerpt' );
function wpt_excerpt( $excerpt ) {
	return substr( $excerpt, 0, 20 ) . ' [..]';
}
//Meta box
function arg_meta_box() {
	add_meta_box(
		'arg-meta-box-id',
		esc_html__( 'MetaBox', 'arg' ),
		'arg_meta_box_callback',
		('arg')
	);
}
add_action( 'admin_menu', 'arg_meta_box' );

function arg_meta_box_callback($post){
	$get_name	= get_post_meta( get_the_ID(), 'testmonial_name', true );
	$get_desig	= get_post_meta( get_the_ID(), 'test_designation', true );
	?>
	<label><?php echo esc_attr('Testimonial Name', 'cwpt') ?></label>
	<input style= width:15%; type="text" name="testmonial_name" id="testmonial_name" value="<?php echo esc_attr($get_name ); ?>">
	<label><?php echo esc_attr('Testimonial Designation', 'cwpt') ?></label>
	<input style= width:15%; type="text" name="test_designation" id="test_designation" value="<?php echo esc_attr($get_desig ); ?>">
	<?php
}

function arg_post_save($post_id){
	$set_name  = isset($_POST['testmonial_name'])? sanitize_text_field( $_POST['testmonial_name']) : '';
	$set_desig = isset($_POST['test_designation'])? sanitize_text_field( $_POST['test_designation']): '';

	update_post_meta( get_the_ID(), 'testmonial_name',  $set_name);
	update_post_meta( get_the_ID(), 'test_designation',  $set_desig);
} 
add_action('save_post', 'arg_post_save');
foreach ( glob( ARGPLUGINPATH."inc/*.php" ) as $php_file )
	include_once $php_file;
