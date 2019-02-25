<?php

/**
 * Tabs Container / Tabs Shortcode
 **/

use DMS\Model\Shortcode;

use \DMS\Helper\Assets;

if ( !class_exists( 'DMSShortcode_Tabs' ) ) {
	class DMSShortcode_Tabs extends Shortcode {

		public function content( $atts, $content = null ) {

			$atts = shortcode_atts( [
				'position'          => '',
				'el_id'             => '',
				'classes'           => ''
			], $this->atts($atts), $this->shortcode );

			Assets::enqueue_style( $this->shortcode.'-style', $this->shortcode_uri.'/assets/style.css' );
			Assets::enqueue_script( $this->shortcode.'-script', $this->shortcode_uri.'/assets/scripts.js' );

			$data = $this->data( [
				'atts'    => $atts,
				'content' => $content
			]);

			return DMS()->View->load( '/view/view', $data, true, $this->shortcode_dir );
		}

	}
}
