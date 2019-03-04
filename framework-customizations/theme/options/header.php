<?php

$options = array(
	array(
		'header_options_tab' => array(
			'title'   => esc_html__( 'Header', 'dms' ),
			'type'    => 'tab',
			'options' => array(
				
				'header_box' => array(
					
					'title' => esc_html__( 'Main', 'dms' ),
					'type'  => 'box',
					'attr'  => array(
						'class' => 'prevent-auto-close'
					),
					
					'options' => array(
						'logo_img' => array(
							'type'        => 'upload',
							'value'       => array(),
							'label'       => __( 'Logo image', 'dms' ),
							'attr'        => array( 'class' => 'brand-logo' ),
							'images_only' => true,
						
						),
						
						'header_text1' => array(
							'type'          => 'wp-editor',
							'label'         => esc_html__( 'Header text 1', 'dms' ),
							'value'         => '',
							'desc'          => __( 'display only on menu', 'dms' ),
							'size'          => 'small', // small, large
							'editor_height' => 100,
							'wpautop'       => false,
							'editor_type'   => false, // tinymce, html
							'media_buttons' => false,
						),
						
						'header_text2' => array(
							'type'          => 'wp-editor',
							'label'         => esc_html__( 'Header text 2', 'dms' ),
							'desc'          => __( 'phone link', 'dms' ),
							'value'         => '',
							'size'          => 'small', // small, large
							'editor_height' => 100,
							'wpautop'       => false,
							'editor_type'   => false, // tinymce, html
							'media_buttons' => false,
						),
						
						'header_text3' => array(
							'type'          => 'wp-editor',
							'label'         => esc_html__( 'Header text 3', 'dms' ),
							'desc'          => __( 'e-mail link', 'dms' ),
							'value'         => '',
							'size'          => 'small', // small, large
							'editor_height' => 100,
							'wpautop'       => false,
							'editor_type'   => false, // tinymce, html
							'media_buttons' => false,
						),
					),
				),
			)
		)
	)
);
