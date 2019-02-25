<?php

$options = array(
	'details' => array(
		'title'   => esc_html__( 'Portfolio Details', 'dms' ),
		'type'    => 'box',
		'options' => array(

			'images' => array(
				'label'       => esc_html__( 'Gallery Images', 'dms' ),
				'type'        => 'multi-upload',
				'images_only' => true,
			),


		)
	),
);
