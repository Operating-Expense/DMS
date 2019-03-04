<?php

return array(
	'name'     => esc_html__( 'Tariffs', 'dms' ),
	'base'     => 'tariff',
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
			'heading'    => esc_html__( 'Tariffs', 'dms' ),
			'group'      => esc_html__( 'Tariffs', 'dms' ),
			'value'      => '',
			'params'     => array(
				
				// -------- main ---------
				array(
					'type'       => 'textfield',
					'param_name' => 'item_title',
					'heading'    => esc_html__( 'Item title', 'dms' ),
					'value'      => '',
					'admin_label' => true
				),
				array(
					'type'       => 'attach_image',
					'param_name' => 'item_image',
					'heading'    => esc_html__( 'Item image', 'dms' ),
				),
				
				// -------- text ---------
				
				// --------------------- 1 ---------------------
				array(
					'type'       => 'textfield',
					'param_name' => 'item_text1_prefix',
					'heading'    => esc_html__( 'Item text 1 prefix', 'dms' ),
					'value'      => '',
				),
				array(
					'type'       => 'textfield',
					'param_name' => 'item_text1_value',
					'heading'    => esc_html__( 'Item text 1 value', 'dms' ),
					'value'      => '',
				),
				array(
					'type'       => 'textfield',
					'param_name' => 'item_text1_suffix',
					'heading'    => esc_html__( 'Item text 1 suffix', 'dms' ),
					'value'      => '',
				),
				// --------------------- 2 ---------------------
				array(
					'type'       => 'textfield',
					'param_name' => 'item_text2_prefix',
					'heading'    => esc_html__( 'Item text 2 prefix', 'dms' ),
					'value'      => '',
				),
				array(
					'type'       => 'textfield',
					'param_name' => 'item_text2_value',
					'heading'    => esc_html__( 'Item text 2 value', 'dms' ),
					'value'      => '',
				),
				array(
					'type'       => 'textfield',
					'param_name' => 'item_text2_suffix',
					'heading'    => esc_html__( 'Item text 2 suffix', 'dms' ),
					'value'      => '',
				),
				// --------------------- 3 ---------------------
				array(
					'type'       => 'textfield',
					'param_name' => 'item_text3_prefix',
					'heading'    => esc_html__( 'Item text 3 prefix', 'dms' ),
					'value'      => '',
				),
				array(
					'type'       => 'textfield',
					'param_name' => 'item_text3_value',
					'heading'    => esc_html__( 'Item text 3 value', 'dms' ),
					'value'      => '',
				),
				array(
					'type'       => 'textfield',
					'param_name' => 'item_text3_suffix',
					'heading'    => esc_html__( 'Item text 3 suffix', 'dms' ),
					'value'      => '',
				),
				
				// -------- link ---------
				array(
					'type'       => 'textfield',
					'param_name' => 'item_link_url',
					'heading'    => esc_html__( 'Item link URL', 'dms' ),
					'value'      => '',
				),
				array(
					'type'       => 'textfield',
					'param_name' => 'item_link_text',
					'heading'    => esc_html__( 'Item link text', 'dms' ),
					'value'      => '',
				),
				
				// -------- common ---------
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
