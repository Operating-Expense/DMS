<?php

return array(
	'name'        => esc_html__( 'Posts', 'dms' ),
	'base'        => 'posts',
	'icon'        => DMS()->config['shortcodes_icon_uri'] . 'post-it.svg',
	'category'    => esc_html__( 'Theme Elements', 'dms' ),
	'description' => esc_html__( 'Any post type with pagination', 'dms' ),
	'params'      => array(

		/**
		 *  Query tab
		 **/
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Post type', 'dms' ),
			'param_name' => 'post_type',
			'value'      => array(
				esc_html__( 'Blog post', 'dms' )            => 'post',
				esc_html__( 'Portfolio', 'dms' )            => 'portfolio',
				esc_html__( 'Testimonials', 'dms' )         => 'testimonials',
				esc_html__( 'Team Members', 'dms' )         => 'team_members',
				esc_html__( 'WooCommerce Products', 'dms' ) => 'product',
			),
			'group'      => esc_html__( 'General', 'dms' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Posts per page', 'dms' ),
			'param_name' => 'posts_per_page',
			'value'      => '9',
			'group'      => esc_html__( 'General', 'dms' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Posts ordering method', 'dms' ),
			'param_name' => 'orderby',
			'value'      => array(
				esc_html__( 'Date', 'dms' )          => 'date',
				esc_html__( 'ID', 'dms' )            => 'ID',
				esc_html__( 'Modified date', 'dms' ) => 'modified',
				esc_html__( 'Title', 'dms' )         => 'title',
				esc_html__( 'Random', 'dms' )        => 'rand',
				esc_html__( 'Menu', 'dms' )          => 'menu',
			),
			'group'      => esc_html__( 'General', 'dms' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Posts sorting method', 'dms' ),
			'param_name' => 'order',
			'value'      => array(
				esc_html__( 'Descending', 'dms' ) => 'DESC',
				esc_html__( 'Ascending', 'dms' )  => 'ASC',
			),
			'group'      => esc_html__( 'General', 'dms' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Query from category', 'dms' ),
			'param_name'  => 'tax_query_type',
			'admin_label' => true,
			'value'       => array(
				esc_html__( 'All', 'dms' )    => '',
				esc_html__( 'Only', 'dms' )   => 'only',
				esc_html__( 'Except', 'dms' ) => 'except',
			),
			'group'       => esc_html__( 'General', 'dms' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Taxonomy slug', 'dms' ),
			'param_name' => 'taxonomy_slug',
			'value'      => 'category',
			'dependency' => array(
				'element' => 'tax_query_type',
				'value'   => array( 'only', 'except' ),
			),
			'group'      => esc_html__( 'General', 'dms' ),
		),
		array(
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Categories', 'dms' ),
			'description' => esc_html__( 'Type here category slugs to include or exclude, based on previous parameter. Explode multiple categories slugs by comma',
				'dms' ),
			'param_name'  => 'taxonomy_terms',
			'admin_label' => true,
			'value'       => '',
			'dependency'  => array(
				'element' => 'tax_query_type',
				'value'   => array( 'only', 'except' ),
			),
			'group'       => esc_html__( 'General', 'dms' ),
		),
		array(
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Element ID', 'dms' ),
			'param_name'  => 'el_id',
			'settings'    => array(
				'auto_generate' => true,
			),
			'group'       => esc_html__( 'General', 'dms' ),
			'description' => esc_html__( 'Unique identifier of this element', 'dms' ),
		),

		/**
		 *  Pagination tab
		 **/
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Display pagination', 'dms' ),
			'param_name' => 'pagination',
			'value'      => array( esc_html__( 'Yes', 'dms' ) => 'yes' ),
			'group'      => esc_html__( 'Pagination', 'dms' ),
			'std'        => 'yes'
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Pagination button text', 'dms' ),
			'param_name' => 'ajax_load_more_button_text',
			'dependency' => array(
				'element'   => 'pagination',
				'not_empty' => true,
			),
			'value'      => esc_html__( 'Load more', 'dms' ),
			'group'      => esc_html__( 'Pagination', 'dms' ),
		),

		/**
		 *  Appearance tab
		 **/
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Display thumbnail', 'dms' ),
			'param_name' => 'display_thumb',
			'value'      => array( esc_html__( 'Yes', 'dms' ) => 'yes' ),
			'group'      => esc_html__( 'Appearance', 'dms' ),
			'std'        => 'yes'
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Display post title', 'dms' ),
			'param_name' => 'display_title',
			'value'      => array( esc_html__( 'Yes', 'dms' ) => 'yes' ),
			'group'      => esc_html__( 'Appearance', 'dms' ),
			'std'        => 'yes'
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Display post excerpt', 'dms' ),
			'param_name' => 'display_excerpt',
			'value'      => array( esc_html__( 'Yes', 'dms' ) => 'yes' ),
			'group'      => esc_html__( 'Appearance', 'dms' ),
			'std'        => 'yes'
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Excerpt lenght', 'dms' ),
			'description' => esc_html__( 'how many words should we display?', 'dms' ),
			'param_name'  => 'excerpt_length',
			'value'       => '13',
			'dependency'  => array(
				'element'   => 'display_excerpt',
				'not_empty' => true,
			),
			'group'       => esc_html__( 'Appearance', 'dms' ),
		),

		/**
		 *  Style tab
		 **/
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Thumbnails dimensions', 'dms' ),
			'param_name' => 'thumbs_dimensions',
			'value'      => array(
				esc_html__( 'Original size (full)', 'dms' ) => '',
				esc_html__( 'Crop thumbnails', 'dms' )      => 'crop',
			),
			'group'      => esc_html__( 'Style', 'dms' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Thumbnail width', 'dms' ),
			'description' => esc_html__( 'value in pixels, e.g.: 320', 'dms' ),
			'param_name'  => 'thumb_width',
			'value'       => '320',
			'dependency'  => array(
				'element' => 'thumbs_dimensions',
				'value'   => array( 'crop' ),
			),
			'group'       => esc_html__( 'Style', 'dms' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Thumbnail height', 'dms' ),
			'description' => esc_html__( 'value in pixels, e.g.: 320', 'dms' ),
			'param_name'  => 'thumb_height',
			'value'       => '180',
			'dependency'  => array(
				'element' => 'thumbs_dimensions',
				'value'   => array( 'crop' ),
			),
			'group'       => esc_html__( 'Style', 'dms' ),
		),

	),
);
