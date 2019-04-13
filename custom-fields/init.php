<?php

add_action( 'after_setup_theme', 'dms_crb_load' );
function dms_crb_load() {
	require_once  get_template_directory() . '/vendor/autoload.php';
	\Carbon_Fields\Carbon_Fields::boot();
}
