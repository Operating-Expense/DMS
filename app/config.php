<?php
/**
 * Application config
 *
 * Return an array with predefined config values
 *
 * PHP version 5.6
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
return array(
	'cache_time'          => '201812022311',
	'assets_uri'          => get_template_directory_uri() . '/assets/',
	'shortcodes_dir'      => get_template_directory() . '/app/Shortcodes/',
	'shortcodes_uri'      => get_template_directory_uri() . '/app/Shortcodes/',
	'shortcodes_icon_uri' => get_template_directory_uri() . '/assets/images/icon/',
	'widgets_dir'         => get_template_directory() . '/app/Widgets/',
	'widgets_uri'         => get_template_directory_uri() . '/app/Widgets/',
	'social_profiles'     => array(
		'facebook_url'    => esc_html__( 'Facebook URL', 'dms' ),
		'twitter_url'     => esc_html__( 'Twitter URL', 'dms' ),
		'instagram_url'   => esc_html__( 'Instagram URL', 'dms' ),
		'google_plus_url' => esc_html__( 'Google Plus URL', 'dms' ),
		'pinterest_url'   => esc_html__( 'Pinterest URL', 'dms' ),
		'linkedin_url'    => esc_html__( 'LinkedIn URL', 'dms' ),
		'youtube_url'     => esc_html__( 'YouTube URL', 'dms' ),
		'vimeo_url'       => esc_html__( 'Vimeo URL', 'dms' ),
		'dribbble_url'    => esc_html__( 'Dribbble URL', 'dms' ),
		'behance_url'     => esc_html__( 'Behance URL', 'dms' ),
		'tumblr_url'      => esc_html__( 'Tumblr URL', 'dms' ),
		'flickr_url'      => esc_html__( 'Flickr URL', 'dms' ),
		'medium_url'      => esc_html__( 'Medium URL', 'dms' ),
	),
	'social_icons'        => array(
		'facebook_url'    => 'fa fa-facebook',
		'twitter_url'     => 'fa fa-twitter',
		'instagram_url'   => 'fa fa-instagram',
		'google_plus_url' => 'fa fa-google-plus',
		'pinterest_url'   => 'fa fa-pinterest-p',
		'linkedin_url'    => 'fa fa-linkedin',
		'youtube_url'     => 'fa fa-youtube-play',
		'vimeo_url'       => 'fa fa-vimeo',
		'dribbble_url'    => 'fa fa-dribbble',
		'behance_url'     => 'fa fa-behance',
		'tumblr_url'      => 'fa fa-tumblr',
		'flickr_url'      => 'fa fa-flickr',
		'medium_url'      => 'fa fa-medium',
	),
	'animations'          => array(
		'bounce'            => esc_html__( 'Bounce', 'dms' ),
		'pulse'             => esc_html__( 'Pulse', 'dms' ),
		'tada'              => esc_html__( 'Tada', 'dms' ),
		'wobble'            => esc_html__( 'Wobble', 'dms' ),
		'jello'             => esc_html__( 'Jello', 'dms' ),
		'bounceIn'          => esc_html__( 'Bounce In', 'dms' ),
		'bounceInDown'      => esc_html__( 'Bounce In Down', 'dms' ),
		'bounceInLeft'      => esc_html__( 'Bounce In Left', 'dms' ),
		'bounceInRight'     => esc_html__( 'Bounce In Right', 'dms' ),
		'bounceInUp'        => esc_html__( 'Bounce In Up', 'dms' ),
		'fadeIn'            => esc_html__( 'Fade In', 'dms' ),
		'fadeInDown'        => esc_html__( 'Fade In Down', 'dms' ),
		'fadeInDownBig'     => esc_html__( 'Fade In Down Big', 'dms' ),
		'fadeInLeft'        => esc_html__( 'Fade In Left', 'dms' ),
		'fadeInLeftBig'     => esc_html__( 'Fade In Left Big', 'dms' ),
		'fadeInRight'       => esc_html__( 'Fade In Right', 'dms' ),
		'fadeInRightBig'    => esc_html__( 'Fade In Right Big', 'dms' ),
		'fadeInUp'          => esc_html__( 'Fade In Up', 'dms' ),
		'fadeInUpBig'       => esc_html__( 'Fade In Up Big', 'dms' ),
		'flip'              => esc_html__( 'Flip', 'dms' ),
		'flipInX'           => esc_html__( 'Flip in X', 'dms' ),
		'flipInY'           => esc_html__( 'Flip in Y', 'dms' ),
		'flipOutX'          => esc_html__( 'Flip out X', 'dms' ),
		'flipOutY'          => esc_html__( 'Flip out Y', 'dms' ),
		'lightSpeedIn'      => esc_html__( 'Light Speed In', 'dms' ),
		'rotateIn'          => esc_html__( 'Rotate In', 'dms' ),
		'rotateInDownLeft'  => esc_html__( 'Rotate In Down Left', 'dms' ),
		'rotateInDownRight' => esc_html__( 'Rotate In Down Right', 'dms' ),
		'rotateInUpLeft'    => esc_html__( 'Rotate In Up Left', 'dms' ),
		'rotateInUpRight'   => esc_html__( 'Rotate In Up Right', 'dms' ),
		'slideInUp'         => esc_html__( 'Slide In Up', 'dms' ),
		'slideInDown'       => esc_html__( 'Slide In Down', 'dms' ),
		'slideInLeft'       => esc_html__( 'Slide In Left', 'dms' ),
		'slideInRight'      => esc_html__( 'Slide In Right', 'dms' ),
		'zoomIn'            => esc_html__( 'Zoom In', 'dms' ),
		'zoomInDown'        => esc_html__( 'Zoom In Down', 'dms' ),
		'zoomInLeft'        => esc_html__( 'Zoom In Left', 'dms' ),
		'zoomInRight'       => esc_html__( 'Zoom In Right', 'dms' ),
		'zoomInUp'          => esc_html__( 'Zoom In Up', 'dms' ),
	),
);
