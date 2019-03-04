<?php

return array(
	'name'     => esc_html__( 'Intro', 'dms' ),
	'base'     => 'intro',
	'category' => esc_html__( 'DMS', 'dms' ),
	'params'   => array(
		// ============================ Block Settings =============================
		array(
			'type'       => 'textfield',
			'param_name' => 'header_title_l',
			'heading'    => esc_html__( 'Section Title left', 'dms' ),
			'value'      => '',
			'group'      => esc_html__( 'General', 'dms' ),
		),
		array(
			'type'       => 'textfield',
			'param_name' => 'header_title_r',
			'heading'    => esc_html__( 'Section Title right', 'dms' ),
			'value'      => '',
			'group'      => esc_html__( 'General', 'dms' ),
		),
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
			'param_name' => 'btn_try_text',
			'heading'    => esc_html__( 'Button Try text ', 'dms' ),
			'value'      => '',
			'group'      => esc_html__( 'General', 'dms' ),
		),
		array(
			'type'       => 'textfield',
			'param_name' => 'btn_try_url',
			'heading'    => esc_html__( 'Button Try url ', 'dms' ),
			'value'      => '',
			'group'      => esc_html__( 'General', 'dms' ),
		),
		
		array(
			'type'       => 'textfield',
			'param_name' => 'btn_about_text',
			'heading'    => esc_html__( 'Button About text ', 'dms' ),
			'value'      => '',
			'group'      => esc_html__( 'General', 'dms' ),
		),
		array(
			'type'       => 'textfield',
			'param_name' => 'btn_about_url',
			'heading'    => esc_html__( 'Button About url ', 'dms' ),
			'value'      => '',
			'group'      => esc_html__( 'General', 'dms' ),
		),
		
		array(
			'type'       => 'textfield',
			'param_name' => 'btn_how_text',
			'heading'    => esc_html__( 'Button How it works text ', 'dms' ),
			'value'      => '',
			'group'      => esc_html__( 'General', 'dms' ),
		),
		array(
			'type'       => 'textfield',
			'param_name' => 'btn_how_url',
			'heading'    => esc_html__( 'Button How it works url ', 'dms' ),
			'value'      => '',
			'group'      => esc_html__( 'General', 'dms' ),
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
	
	
	)
);
