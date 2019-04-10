<?php
namespace DMS\Controller;

/**
 * Post Types
 *
 * Register custom post types
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
class PostTypes {

	/**
	 * Constructor
	 **/
	public function __construct() {

		// Register Custom Post Types and Taxonomies
		add_action( 'init', array( $this, 'register_custom_post_types' ), 5 );

	}

	/**
	 * Register custom post types
	 **/
	public function register_custom_post_types() {


/*
		register_post_type( 'composerlayout', array(
				'label'               => esc_html__( 'Header / Footer', 'dms' ),
				'description'         => '',
				'public'              => true,
				'show_ui'             => true,
				'publicly_queryable'  => false,
				'exclude_from_search' => true,
				'show_in_nav_menus'   => false,
				'_builtin'            => false,
				'show_in_menu'        => true,
				'capability_type'     => 'post',
				'map_meta_cap'        => true,
				'hierarchical'        => false,
				'menu_position'       => null,
				'rewrite'             => false,
				'query_var'           => true,
				'supports'            => array( 'title', 'editor' ),
				'labels'              => array(
					'name'               => esc_html__( 'Header / Footer', 'dms' ),
					'singular_name'      => esc_html__( 'Header / Footer', 'dms' ),
					'menu_name'          => esc_html__( 'Header / Footer', 'dms' ),
					'add_new'            => esc_html__( 'Add New Header / Footer', 'dms' ),
					'add_new_item'       => esc_html__( 'Add New Header / Footer', 'dms' ),
					'edit'               => esc_html__( 'Edit', 'dms' ),
					'edit_item'          => esc_html__( 'Edit Header / Footer', 'dms' ),
					'new_item'           => esc_html__( 'New Header / Footer', 'dms' ),
					'view'               => esc_html__( 'View Header / Footer', 'dms' ),
					'view_item'          => esc_html__( 'View Header / Footer', 'dms' ),
					'search_items'       => esc_html__( 'Search Header / Footer', 'dms' ),
					'not_found'          => esc_html__( 'No Header / Footer Found', 'dms' ),
					'not_found_in_trash' => esc_html__( 'No Header / Footer Found in Trash',
						'dms' ),
					'parent'             => esc_html__( 'Parent Header / Footer', 'dms' )
				)
			)
		);

		register_post_type( 'testimonials',
			array(
				'label'             => esc_html__( 'Testimonials', 'dms' ),
				'description'       => '',
				'public'            => false,
				'show_ui'           => true,
				'show_in_menu'      => true,
				'show_in_nav_menus' => true,
				'capability_type'   => 'post',
				'hierarchical'      => false,
				'supports'          => array( 'title', 'editor', 'custom-fields', 'thumbnail' ),
				'rewrite'           => false,
				'has_archive'       => false,
				'query_var'         => false,
				'menu_position'     => 5,
				'capabilities'      => array(
					'publish_posts'       => 'edit_pages',
					'edit_posts'          => 'edit_pages',
					'edit_others_posts'   => 'edit_pages',
					'delete_posts'        => 'edit_pages',
					'delete_others_posts' => 'edit_pages',
					'read_private_posts'  => 'edit_pages',
					'edit_post'           => 'edit_pages',
					'delete_post'         => 'edit_pages',
					'read_post'           => 'edit_pages',
				),
				'labels'            => array(
					'name'               => esc_html__( 'Testimonials', 'dms' ),
					'singular_name'      => esc_html__( 'Testimonial', 'dms' ),
					'menu_name'          => esc_html__( 'Testimonials', 'dms' ),
					'add_new'            => esc_html__( 'Add Testimonial', 'dms' ),
					'add_new_item'       => esc_html__( 'Add New Testimonial', 'dms' ),
					'all_items'          => esc_html__( 'All Testimonials', 'dms' ),
					'edit_item'          => esc_html__( 'Edit Testimonial', 'dms' ),
					'new_item'           => esc_html__( 'New Testimonial', 'dms' ),
					'view_item'          => esc_html__( 'View Testimonial', 'dms' ),
					'search_items'       => esc_html__( 'Search Testimonials', 'dms' ),
					'not_found'          => esc_html__( 'No Testimonials Found', 'dms' ),
					'not_found_in_trash' => esc_html__( 'No Testimonials Found in Trash', 'dms' ),
					'parent_item_colon'  => esc_html__( 'Parent Testimonial:', 'dms' )
				)
			)
		);

		register_taxonomy( 'testimonial_cat',
			'testimonials',
			array(
				'hierarchical'      => true,
				'show_ui'           => true,
				'query_var'         => false,
				'show_in_nav_menus' => false,
				'rewrite'           => false,
				'show_admin_column' => true,
				'labels'            => array(
					'name'          => _x( 'Testimonials Categories', 'taxonomy general name',
						'dms' ),
					'singular_name' => _x( 'Testimonials Category', 'taxonomy singular name',
						'dms' ),
					'search_items'  => esc_html__( 'Search in categories', 'dms' ),
					'all_items'     => esc_html__( 'All Categories', 'dms' ),
					'edit_item'     => esc_html__( 'Edit Category', 'dms' ),
					'update_item'   => esc_html__( 'Update Category', 'dms' ),
					'add_new_item'  => esc_html__( 'Add New Category', 'dms' ),
					'new_item_name' => esc_html__( 'New Category', 'dms' ),
					'menu_name'     => esc_html__( 'Categories', 'dms' )
				)
			)
		);

		register_post_type( 'team_members',
			array(
				'label'             => esc_html__( 'Team Members', 'dms' ),
				'description'       => '',
				'public'            => false,
				'show_ui'           => true,
				'show_in_menu'      => true,
				'show_in_nav_menus' => true,
				'capability_type'   => 'post',
				'hierarchical'      => false,
				'supports'          => array( 'title', 'editor', 'custom-fields', 'thumbnail' ),
				'rewrite'           => false,
				'has_archive'       => false,
				'query_var'         => false,
				'menu_position'     => 5,
				'capabilities'      => array(
					'publish_posts'       => 'edit_pages',
					'edit_posts'          => 'edit_pages',
					'edit_others_posts'   => 'edit_pages',
					'delete_posts'        => 'edit_pages',
					'delete_others_posts' => 'edit_pages',
					'read_private_posts'  => 'edit_pages',
					'edit_post'           => 'edit_pages',
					'delete_post'         => 'edit_pages',
					'read_post'           => 'edit_pages',
				),
				'labels'            => array(
					'name'               => esc_html__( 'Team Members', 'dms' ),
					'singular_name'      => esc_html__( 'Team Member', 'dms' ),
					'menu_name'          => esc_html__( 'Team Members', 'dms' ),
					'add_new'            => esc_html__( 'Add Team Member', 'dms' ),
					'add_new_item'       => esc_html__( 'Add New Team Member', 'dms' ),
					'all_items'          => esc_html__( 'All Team Members', 'dms' ),
					'edit_item'          => esc_html__( 'Edit Team Member', 'dms' ),
					'new_item'           => esc_html__( 'New Team Member', 'dms' ),
					'view_item'          => esc_html__( 'View Team Member', 'dms' ),
					'search_items'       => esc_html__( 'Search Team Members', 'dms' ),
					'not_found'          => esc_html__( 'No Team Members Found', 'dms' ),
					'not_found_in_trash' => esc_html__( 'No Team Members Found in Trash', 'dms' ),
					'parent_item_colon'  => esc_html__( 'Parent Team Member:', 'dms' )
				)
			)
		);

		register_taxonomy( 'team_members_cat',
			'team',
			array(
				'hierarchical'      => true,
				'show_ui'           => true,
				'query_var'         => false,
				'show_in_nav_menus' => false,
				'rewrite'           => false,
				'show_admin_column' => true,
				'labels'            => array(
					'name'          => _x( 'Team Members Categories', 'taxonomy general name',
						'dms' ),
					'singular_name' => _x( 'Team Members Category', 'taxonomy singular name',
						'dms' ),
					'search_items'  => esc_html__( 'Search in categories', 'dms' ),
					'all_items'     => esc_html__( 'All Categories', 'dms' ),
					'edit_item'     => esc_html__( 'Edit Category', 'dms' ),
					'update_item'   => esc_html__( 'Update Category', 'dms' ),
					'add_new_item'  => esc_html__( 'Add New Category', 'dms' ),
					'new_item_name' => esc_html__( 'New Category', 'dms' ),
					'menu_name'     => esc_html__( 'Categories', 'dms' )
				)
			)
		);

		register_post_type( 'portfolio',
			array(
				'label'             => esc_html__( 'Portfolio', 'dms' ),
				'description'       => '',
				'public'            => true,
				'show_ui'           => true,
				'show_in_menu'      => true,
				'show_in_nav_menus' => true,
				'capability_type'   => 'post',
				'hierarchical'      => false,
				'supports'          => array( 'title', 'editor', 'custom-fields', 'thumbnail' ),
				'rewrite'           => true,
				'has_archive'       => true,
				'query_var'         => true,
				'menu_position'     => 5,
				'capabilities'      => array(
					'publish_posts'       => 'edit_pages',
					'edit_posts'          => 'edit_pages',
					'edit_others_posts'   => 'edit_pages',
					'delete_posts'        => 'edit_pages',
					'delete_others_posts' => 'edit_pages',
					'read_private_posts'  => 'edit_pages',
					'edit_post'           => 'edit_pages',
					'delete_post'         => 'edit_pages',
					'read_post'           => 'edit_pages',
				),
				'labels'            => array(
					'name'               => esc_html__( 'Portfolio', 'dms' ),
					'singular_name'      => esc_html__( 'Post', 'dms' ),
					'menu_name'          => esc_html__( 'Portfolio', 'dms' ),
					'add_new'            => esc_html__( 'Add Post', 'dms' ),
					'add_new_item'       => esc_html__( 'Add New Post', 'dms' ),
					'all_items'          => esc_html__( 'All Posts', 'dms' ),
					'edit_item'          => esc_html__( 'Edit Post', 'dms' ),
					'new_item'           => esc_html__( 'New Post', 'dms' ),
					'view_item'          => esc_html__( 'View Post', 'dms' ),
					'search_items'       => esc_html__( 'Search Posts', 'dms' ),
					'not_found'          => esc_html__( 'No Posts Found', 'dms' ),
					'not_found_in_trash' => esc_html__( 'No Posts Found in Trash', 'dms' ),
					'parent_item_colon'  => esc_html__( 'Parent Post:', 'dms' )
				)
			)
		);

		register_taxonomy( 'portfolio_cat',
			'portfolio',
			array(
				'hierarchical'      => true,
				'show_ui'           => true,
				'query_var'         => true,
				'show_in_nav_menus' => true,
				'rewrite'           => true,
				'show_admin_column' => true,
				'labels'            => array(
					'name'          => _x( 'Categories', 'taxonomy general name', 'dms' ),
					'singular_name' => _x( 'Category', 'taxonomy singular name', 'dms' ),
					'search_items'  => esc_html__( 'Search in categories', 'dms' ),
					'all_items'     => esc_html__( 'All Categories', 'dms' ),
					'edit_item'     => esc_html__( 'Edit Category', 'dms' ),
					'update_item'   => esc_html__( 'Update Category', 'dms' ),
					'add_new_item'  => esc_html__( 'Add New Category', 'dms' ),
					'new_item_name' => esc_html__( 'New Category', 'dms' ),
					'menu_name'     => esc_html__( 'Categories', 'dms' )
				)
			)
		);

		register_post_type( 'news',
			array(
				'label'             => esc_html__( 'News', 'dms' ),
				'description'       => '',
				'public'            => true,
				'show_ui'           => true,
				'show_in_menu'      => true,
				'show_in_nav_menus' => true,
				'capability_type'   => 'post',
				'hierarchical'      => false,
				'supports'          => array( 'title', 'editor', 'custom-fields', 'thumbnail' ),
				'rewrite'           => false,
				'has_archive'       => true,
				'query_var'         => false,
				'menu_position'     => 1,
				'capabilities'      => array(
					'publish_posts'       => 'edit_pages',
					'edit_posts'          => 'edit_pages',
					'edit_others_posts'   => 'edit_pages',
					'delete_posts'        => 'edit_pages',
					'delete_others_posts' => 'edit_pages',
					'read_private_posts'  => 'edit_pages',
					'edit_post'           => 'edit_pages',
					'delete_post'         => 'edit_pages',
					'read_post'           => 'edit_pages',
				),
				'labels'            => array(
					'name'               => esc_html__( 'News', 'dms' ),
					'singular_name'      => esc_html__( 'News Item', 'dms' ),
					'menu_name'          => esc_html__( 'News', 'dms' ),
					'add_new'            => esc_html__( 'Add News', 'dms' ),
					'add_new_item'       => esc_html__( 'Add News', 'dms' ),
					'all_items'          => esc_html__( 'All News', 'dms' ),
					'edit_item'          => esc_html__( 'Edit News', 'dms' ),
					'new_item'           => esc_html__( 'New News', 'dms' ),
					'view_item'          => esc_html__( 'View News', 'dms' ),
					'search_items'       => esc_html__( 'Search News', 'dms' ),
					'not_found'          => esc_html__( 'No News Found', 'dms' ),
					'not_found_in_trash' => esc_html__( 'No News Found in Trash', 'dms' ),
					'parent_item_colon'  => esc_html__( 'Parent News:', 'dms' )
				)
			)
		);

*/

	}


}
