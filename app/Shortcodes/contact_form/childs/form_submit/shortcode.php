<?php

/**
 *  Submit Child / Form Shortcode
 **/

use DMS\Model\Shortcode;

if ( !class_exists( 'DMSShortcode_Form_Submit' ) ) {
	class DMSShortcode_Form_Submit extends Shortcode {

		public function content( $atts, $content = null ) {

			$atts = shortcode_atts( [
				'el_id' => '',
				'align' => '',
				'submit_button_text' => ''
			], $this->atts($atts), $this->shortcode );

			$data = $this->data( array(
				'atts'    => $atts,
				'content' => $content
			));

			return DMS()->View->load( '/view/view', $data, true, $this->shortcode_dir );
		}

	}
}