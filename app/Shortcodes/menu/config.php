<?php

$menus_raw = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
$menus = array();

foreach ( $menus_raw as $menu) {
	$menus[$menu->name] = $menu->slug;
}

return array(
	'name'        => esc_html__( 'Menu', 'dms' ),
	'base'        => 'menu',
	'category'    => esc_html__( 'Theme Elements', 'dms' ),
	'description' => esc_html__( 'Add a menu', 'dms' ),
	'params'      => array(

		/**
		 *  Menu settings tab
		 **/

		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Menu', 'dms' ),
			'description' => esc_html__( 'Desired menu.', 'dms' ),
			'param_name'  => 'menu',
			'value'       => $menus,
			'group'       => esc_html__( 'Menu Settings', 'dms' ),
		),

		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Menu ID', 'dms' ),
			'description' => esc_html__( 'The ID that is applied to the ul element which forms the menu. Default is the menu slug, incremented.', 'dms' ),
			'param_name' => 'menu_id',
			'value'      => '',
			'group'      => esc_html__( 'Menu Settings', 'dms' ),
		),

		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Menu Classes', 'dms' ),
			'description' => esc_html__( 'CSS class to use for the ul element which forms the menu. Default \'menu\'.', 'dms' ),
			'param_name' => 'menu_class',
			'value'      => '',
			'group'      => esc_html__( 'Menu Settings', 'dms' ),
		),

		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Menu Container', 'dms' ),
			'description' => esc_html__( 'Whether to wrap the ul, and what to wrap it with. Default \'div\'', 'dms' ),
			'param_name' => 'container',
			'value'      => '',
			'group'      => esc_html__( 'Menu Settings', 'dms' ),
		),

		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Menu Container Class', 'dms' ),
			'description' => esc_html__( 'Class that is applied to the container. Default \'menu-{menu slug}-container\'', 'dms' ),
			'param_name' => 'container_class',
			'value'      => '',
			'group'      => esc_html__( 'Menu Settings', 'dms' ),
		),

		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Menu Container ID', 'dms' ),
			'description' => esc_html__( 'The ID that is applied to the container', 'dms' ),
			'param_name' => 'container_id',
			'value'      => '',
			'group'      => esc_html__( 'Menu Settings', 'dms' ),
		),

		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Menu Depth', 'dms' ),
			'description' => esc_html__( 'How many levels of the hierarchy are to be included. 0 means all. Default 0', 'dms' ),
			'param_name' => 'depth',
			'value'      => array( 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
			'group'      => esc_html__( 'Menu Settings', 'dms' ),
		),

		array(
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Element ID', 'dms' ),
			'param_name'  => 'el_id',
			'settings'    => array(
				'auto_generate' => true,
			),
			'group'       => esc_html__( 'Menu Settings', 'dms' ),
			'description' => esc_html__( 'Unique identifier of this element', 'dms' ),
		)

	)
);
