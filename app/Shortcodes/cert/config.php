<?php

return array(
	'name'     => esc_html__( 'Certificates', 'dms' ),
	'base'     => 'cert',
	'category' => esc_html__( 'DMS', 'dms' ),
	'params'   => array(
		// ============================ Block Settings =============================
		array(
			'type'       => 'textfield',
			'param_name' => 'title',
			'heading'    => esc_html__( 'Title', 'dms' ),
			'value'      => '',
			'group'      => esc_html__( 'General', 'dms' ),
		),
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
			'heading'    => esc_html__( 'Certificates', 'dms' ),
			'group'      => esc_html__( 'Certificates', 'dms' ),
			'value'      => '',
			'params'     => array(
				
				array(
					'type'       => 'textfield',
					'param_name' => 'item_title',
					'heading'    => esc_html__( 'Item title', 'dms' ),
					'value'      => '',
					//'admin_label' => true
				),
				array(
					'type'       => 'textarea',
					'param_name' => 'item_text',
					'heading'    => esc_html__( 'Item text', 'dms' ),
					'value'      => '',
					'admin_label' => true
				),
				array(
					'type'       => 'attach_image',
					'param_name' => 'item_image',
					'heading'    => esc_html__( 'Item image', 'dms' ),
				),
				array(
					'type'       => 'textfield',
					'param_name' => 'item_url',
					'heading'    => esc_html__( 'Item URL', 'dms' ),
					'value'      => '',
				),
				array(
					'type'       => 'textfield',
					'param_name' => 'item_el_classes',
					'heading'    => esc_html__( ' Item CSS classes', 'dms' ),
					'value'      => '',
				),
			)
		),
	
	)
);
