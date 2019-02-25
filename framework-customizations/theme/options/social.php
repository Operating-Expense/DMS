<?php

$options = array(
	array(
		'social_options_tab' => array(
			'title'   => esc_html__( 'Social', 'dms' ),
			'type'    => 'tab',
			'options' => array(

				'oauth-settings-box' => array(
					'title'   => esc_html__( 'Social Login', 'dms' ),
					'type'    => 'box',
					'attr'    => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(

						'facebook_app_id'     => array(
							'type'  => 'text',
							'label' => esc_html__( 'Facebook Application ID', 'dms' ),
							'value' => ''
						),
						'facebook_app_secret' => array(
							'type'  => 'text',
							'label' => esc_html__( 'Facebook Application Secret', 'dms' ),
							'value' => ''
						),

						'google_client_id'     => array(
							'type'  => 'text',
							'label' => esc_html__( 'Google Client ID', 'dms' ),
							'value' => ''
						),
						'google_client_secret' => array(
							'type'  => 'text',
							'label' => esc_html__( 'Google Client Secret', 'dms' ),
							'value' => ''
						),

						'twitter_consumer_key'    => array(
							'type'  => 'text',
							'label' => esc_html__( 'Twitter Consumer Key', 'dms' ),
							'value' => ''
						),
						'twitter_consumer_secret' => array(
							'type'  => 'text',
							'label' => esc_html__( 'Twitter Consumer Secret', 'dms' ),
							'value' => ''
						),

					)
				),

				'social_profiles-settings-box' => array(
					'title'   => esc_html__( 'Social Profiles', 'dms' ),
					'type'    => 'box',
					'attr'    => array(
						'class' => 'prevent-auto-close'
					),
					'options' => array(

						\DMS\Helper\Utils::get_social_cfg_usyon()

					)
				),

			)
		)
	)
);
