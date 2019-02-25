<?php
/**
 * Team composerlayout post type options array
 **/

$args = array(
	'public'          => true,
	'capability_type' => 'page',
);

$post_types_cap_page = get_post_types( $args, 'objects' );

$args = array(
	'public'             => true,
	'publicly_queryable' => true,
	'capability_type'    => 'post',
);

$post_types_cap_post = get_post_types( $args, 'objects' );

$post_types = array_merge( $post_types_cap_page, $post_types_cap_post );

$choices = array(
	'default'           => esc_html__( 'Default', 'dms' ),
	'for-manual-select' => esc_html__( 'For manual select', 'dms' ),
	'is-home'           => esc_html__( 'Blog page', 'dms' ),
	'is-search'         => esc_html__( 'Search results page', 'dms' ),
	'is-archive'        => esc_html__( 'Archive page', 'dms' ),
	'is-404'            => esc_html__( '404 page', 'dms' ),
);

foreach ( $post_types as $post_type ) {
	$choices[ $post_type->name ] = $post_type->label;
}

$options = array(
	'settings' => array(
		'title'   => esc_html__( 'Settings', 'dms' ),
		'type'    => 'box',
		'options' => array(

			'_layouttype'  => array(
				'label'      => esc_html__( 'Layout type', 'dms' ),
				'type'       => 'radio',
				'value'      => 'header',
				'choices'    => array(
					'header' => esc_html__( 'Header', 'dms' ),
					'footer' => esc_html__( 'Footer', 'dms' ),
				),
				'fw-storage' => array(
					'type'      => 'post-meta',
					'post-meta' => '_layouttype',
				),
			),
			'_appointment' => array(
				'type'       => 'select',
				'label'      => esc_html__( 'Placement', 'dms' ),
				'value'      => 'default',
				'desc'       => esc_html__( 'Where this Header/Footer will be shown', 'dms' ),
				'choices'    => $choices,
				'fw-storage' => array(
					'type'      => 'post-meta',
					'post-meta' => '_appointment',
				),
			)

		)
	),

);
