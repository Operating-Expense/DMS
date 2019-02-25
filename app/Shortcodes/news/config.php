<?php

return array(
	'name'        => esc_html__( 'News', 'dms' ),
	'base'        => 'news',
	'icon'        => DMS()->config['shortcodes_icon_uri'] . 'newspaper.svg',
	'category'    => esc_html__( 'Theme Elements', 'dms' ),
	'description' => esc_html__( 'News', 'dms' ),
	'params'      => array(

		/**
		 *  Query tab
		 **/
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Title', 'dms' ),
			'param_name' => 'title',
			'value'      => __('Recent News', 'dms'),
			'group'      => esc_html__( 'General', 'dms' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'News ordering method', 'dms' ),
			'param_name' => 'orderby',
			'value'      => array(
				esc_html__( 'Date', 'dms' )          => 'date',
				esc_html__( 'ID', 'dms' )            => 'ID',
				esc_html__( 'Modified date', 'dms' ) => 'modified',
				esc_html__( 'Title', 'dms' )         => 'title',
				esc_html__( 'Random', 'dms' )        => 'rand',
			),
			'group'      => esc_html__( 'General', 'dms' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'News sorting method', 'dms' ),
			'param_name' => 'order',
			'value'      => array(
				esc_html__( 'Descending', 'dms' ) => 'DESC',
				esc_html__( 'Ascending', 'dms' )  => 'ASC',
			),
			'group'      => esc_html__( 'General', 'dms' ),
		),
		array(
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Element ID', 'dms' ),
			'param_name'  => 'el_id',
			'settings'    => array(
				'auto_generate' => true,
			),
			'group'       => esc_html__( 'General', 'dms' ),
			'description' => esc_html__( 'Unique identifier of this element', 'dms' ),
		),

		/**
		 *  Appearance tab
		 **/
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Display thumbnail', 'dms' ),
			'param_name' => 'display_thumb',
			'value'      => array( esc_html__( 'Yes', 'dms' ) => 'yes' ),
			'group'      => esc_html__( 'Appearance', 'dms' ),
			'std'        => 'yes'
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Display news title', 'dms' ),
			'param_name' => 'display_title',
			'value'      => array( esc_html__( 'Yes', 'dms' ) => 'yes' ),
			'group'      => esc_html__( 'Appearance', 'dms' ),
			'std'        => 'yes'
		),
	),
);
