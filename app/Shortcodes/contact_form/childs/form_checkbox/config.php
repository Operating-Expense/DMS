<?php

return [
	'name'            => esc_html__( 'Checkbox Field', 'dms' ),
	'base'            => 'form_checkbox',
	'icon'            => DMS()->config['shortcodes_icon_uri'] . 'checked.svg',
	'content_element' => true,
	'category'        => esc_html__( 'Form Fields', 'dms' ),
	'as_child'        => array( 
		'only' => 'contact_form, vc_column_inner'
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
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Mandatory Field', 'dms' ),
			'description' => esc_html__( 'Make this field mandatory?', 'dms' ),
			'param_name'  => 'required',
			'value'       => array( esc_html__('Yes', 'dms') => 'yes' ),
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
];