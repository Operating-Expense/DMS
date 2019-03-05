<?php

return array(
	'name'     => esc_html__( 'Statistic', 'dms' ),
	'base'     => 'stat',
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
			'heading'    => esc_html__( 'Statistic', 'dms' ),
			'group'      => esc_html__( 'Statistic', 'dms' ),
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
					'type'       => 'textfield',
					'param_name' => 'item_el_classes',
					'heading'    => esc_html__( ' Item CSS classes', 'dms' ),
					'value'      => '',
				),
			)
		),
	
	)
);
