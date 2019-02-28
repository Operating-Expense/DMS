<?php

$options = array(
	array(
		'footer_options_tab' => array(
			'title'   => esc_html__( 'Footer', 'dms' ),
			'type'    => 'tab',
			'options' => array(

				'footer-settings-box' => array(
					'title'   => esc_html__( 'Footer', 'dms' ),
					'type'    => 'box',
					'attr'    => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(
						
						'footer_box1' => array(
							'type'  => 'wp-editor',
							'label' => esc_html__( 'Footer box 1', 'dms' ),
							'value' => '',
							'desc'  => __('Можно вписать адрес', 'dms'),
							'size' => 'small', // small, large
							'editor_height' => 200,
							'wpautop' => true,
							'editor_type' => false, // tinymce, html
							'media_buttons'       => false,
						),
						
						'footer_box2' => array(
							'type'  => 'wp-editor',
							'label' => esc_html__( 'Footer box 2', 'dms' ),
							'value' => '',
							'desc'  => __('Можно вписать доп ссылки', 'dms'),
							'size' => 'small',
							'editor_height' => 200,
							'wpautop' => true,
							'editor_type' => false, // tinymce, html
							'media_buttons'       => false,
						),
					)
				),
				
				'bottom_bar-settings-box' => array(
					'title'   => esc_html__( 'Bottom Bar', 'dms' ),
					'type'    => 'box',
					'attr'    => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(
						
						'bottom_bar_text' => array(
							'type'  => 'text',
							'label' => esc_html__( 'Bottom bar text', 'dms' ),
							'value' => ''
						),

					)
				),

			)
		)
	)
);
