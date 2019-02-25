<?php
/**
 * Social Login Shortcode
 *
 */

return array(
	'name'        => esc_html__( 'Social Login Buttons', 'dms' ),
	'base'        => 'social_login',
	'icon'        => DMS()->config['shortcodes_icon_uri'] . 'login.svg',
	'category'    => esc_html__( 'Theme Elements', 'dms' ),
	'description' => esc_html__( 'Add social login buttons', 'dms' ),
	'params'      => array()
);
