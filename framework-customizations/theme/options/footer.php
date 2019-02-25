<?php

$options = array(
	array(
		'footer_options_tab' => array(
			'title'   => esc_html__( 'Footer', 'dms' ),
			'type'    => 'tab',
			'options' => array(

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
