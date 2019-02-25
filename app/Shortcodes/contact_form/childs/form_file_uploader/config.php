<?php

return array(
	'name'            => esc_html__( 'Form File Uploader', 'dms' ),
	'base'            => 'form_file_uploader',
	'icon'            => DMS()->config['shortcodes_icon_uri'] . 'file.svg',
	'content_element' => true,
	'category'        => esc_html__( 'Form Fields', 'dms' ),
	'as_child'        => array(
		'only' => 'contact_form,vc_column_inner'
	),
	'params'          => array(
			
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Field name', 'dms' ),
			'description' => esc_html__( 'Enter a field name for Humans', 'dms' ),
			'param_name'  => 'label',
			'holder'	  => 'h2',
			'value'       => '',
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Placeholder', 'dms' ),
			'description' => esc_html__( 'This text will be used as field placeholder', 'dms' ),
			'param_name'  => 'placeholder',
			'value'       => '',
		),
		array(
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Field ID', 'dms' ),
			'param_name'  => 'el_id',
			'settings'    => array(
				'auto_generate' => true,
			),
			'description' => esc_html__( 'Used in "name" attribute', 'dms' ),
		),	
	)
);