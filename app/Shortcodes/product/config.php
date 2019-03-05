<?php

return array(
	'name'     => esc_html__( 'About Product', 'dms' ),
	'base'     => 'product',
	'category' => esc_html__( 'DMS', 'dms' ),
	'params'   => array(
		// ============================ Block Settings =============================
		
		array(
			'type'       => 'textfield',
			'param_name' => 'title',
			'heading'    => esc_html__( 'Title', 'dms' ),
			'value'      => '',
			'group'      => esc_html__( 'General', 'dms' ),
			'admin_label' => true
		),
		array(
			'type'       => 'textarea_html',
			'param_name' => 'content',   // !!! must be “content”, and  only one per shortcode 
			'heading'    => esc_html__( 'Text', 'dms' ),
			'value'      => '',
			'group'      => esc_html__( 'General', 'dms' ),
			//'admin_label' => true
		),
		// ---------------------------
		
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'CSS classes', 'dms' ),
			'param_name' => 'el_classes',
			'value'      => '',
			'group'      => esc_html__( 'General', 'dms' ),
		),
		array(
			'type'       => 'el_id',
			'heading'    => esc_html__( 'CSS id', 'dms' ),
			'param_name' => 'el_id',
			'settings'   => array(
				'auto_generate' => true,
			),
			'group'      => esc_html__( 'General', 'dms' ),
		),
		
		// ========================== Block Items Settings ===========================
		array(
			'type'       => 'param_group',
			'param_name' => 'items',
			'heading'    => esc_html__( 'Possibilities', 'dms' ),
			'group'      => esc_html__( 'Possibilities', 'dms' ),
			'value'      => '',
			'params'     => array(
				
				array(
					'type'       => 'textfield',
					'param_name' => 'item_title',
					'heading'    => esc_html__( 'Item title', 'dms' ),
					'value'      => '',
					'admin_label' => true
				),
				array(
					'type'       => 'textarea',
					'param_name' => 'item_text',
					'heading'    => esc_html__( 'Item text', 'dms' ),
					'value'      => '',
					//'admin_label' => true
				),
				array(
					'type'       => 'attach_image',
					'param_name' => 'item_image',
					'heading'    => esc_html__( 'Item image', 'dms' ),
				),
				array(
					'type'       => 'textfield',
					'param_name' => 'item_el_classes',
					'heading'    => esc_html__( ' Item CSS classes', 'dms' ),
					'value'      => '',
				),
			)
		),
		
		// ========================== Carousel ===========================
		array(
			'type'       => 'checkbox',
			'param_name' => 'autoplay',
			'heading'    => esc_html__( 'Autoplay', 'dms' ),
			'group'      => esc_html__( 'Carousel', 'dms' ),
			'value'      => array(
				'On' => 'on'
			),
		),
		array(
			'type'       => 'textfield',
			'param_name' => 'autoplay_speed',
			'heading'    => esc_html__( 'Autoplay speed, ms', 'dms' ),
			'group'      => esc_html__( 'Carousel', 'dms' ),
			'value'      => 3000
		),
		
		/*array(
			'type'       => 'textfield',
			'param_name' => 'num',
			'heading'    => esc_html__( 'Number of slides', 'dms' ),
			'description'       => esc_html__( 'For wide screen', 'dms' ),
			'group'      => esc_html__( 'Carousel', 'dms' ),
			'value'      => 3
		),
		array(
			'type'       => 'textfield',
			'param_name' => 'num_medium',
			'heading'    => esc_html__( 'Number of slides', 'dms' ),
			'description'       => esc_html__( 'For medium screen', 'dms' ),
			'group'      => esc_html__( 'Carousel', 'dms' ),
			'value'      => 2
		),
		array(
			'type'       => 'textfield',
			'param_name' => 'num_small',
			'heading'    => esc_html__( 'Number of slides', 'dms' ),
			'description'       => esc_html__( 'For small screen', 'dms' ),
			'group'      => esc_html__( 'Carousel', 'dms' ),
			'value'      => 1
		),*/
	
	)
);
