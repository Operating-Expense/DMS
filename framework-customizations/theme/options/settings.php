<?php

if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(

	fw()->theme->get_options( 'general' ),
	fw()->theme->get_options( 'header' ),
	fw()->theme->get_options( 'footer' ),
	fw()->theme->get_options( 'analytics' ),
	fw()->theme->get_options( 'performance' ),
	fw()->theme->get_options( 'social' ),

);
