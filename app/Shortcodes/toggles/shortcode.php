<?php

/**
 * Toggles Shortcode
 **/

use DMS\Model\Shortcode;

if ( !class_exists( 'DMSShortcode_Toggles' ) ) {
	class DMSShortcode_Toggles extends Shortcode {

		public function content( $atts, $content = null ) {

			$atts = shortcode_atts( [
				'el_id'             => '',
				'classes'           => 'accordion'
			], $this->atts($atts), $this->shortcode );

			$data = $this->data( [
				'atts'    => $atts,
				'content' => $content
			]);

			return DMS()->View->load( '/view/view', $data, true, $this->shortcode_dir );
		}

	}
}