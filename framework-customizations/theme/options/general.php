<?php

$options = array(
	array(
		'base_options_tab' => array(
			'title'   => esc_html__( 'Base Settings', 'dms' ),
			'type'    => 'tab',
			'options' => array(
				
				'basic_box' => array(
					'title'   => esc_html__( 'Basic', 'dms' ),
					'type'    => 'box',
					'attr'    => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(
						
						'dms_phone' => array(
							'type'  => 'text',
							'label' => esc_html__( 'DMS Phone', 'dms' ),
							'value' => ''
						),
						
						'dms_email' => array(
							'type'  => 'text',
							'label' => esc_html__( 'DMS e-mail', 'dms' ),
							'value' => ''
						),
					
					),
				
				),
				
				'antispam_box' => array(
					'title'   => esc_html__( 'Antispam', 'dms' ),
					'type'    => 'box',
					'attr'    => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(
						
						'forms_antispam' => array(
							'type'         => 'switch',
							'label'        => __( 'Antispam', 'dms' ),
							'right-choice' => array(
								'value' => '1',
								'label' => __( 'Yes', 'dms' )
							),
							'left-choice'  => array(
								'value' => '0',
								'color' => '#ccc',
								'label' => __( 'No', 'dms' )
							),
							'desc'         => __( 'Antispam for all Email Forms', 'dms' ),
						
						),
					
					)
				),
				
				'pingbacks' => array(
					'title'   => esc_html__( 'Ping Backs', 'dms' ),
					'type'    => 'box',
					'attr'    => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(
						
						'disable_pingbacks' => array(
							'type'         => 'switch',
							'label'        => __( 'Trackbacks/Pingbacks', 'dms' ),
							'right-choice' => array(
								'value' => '1',
								'label' => __( 'Yes', 'dms' )
							),
							'left-choice'  => array(
								'value' => '0',
								'color' => '#ccc',
								'label' => __( 'No', 'dms' )
							),
							'desc'         => __( 'Disables trackbacks/pingbacks', 'dms' ),
						
						),
					
					)
				),
			
			)
		)
	)
);
