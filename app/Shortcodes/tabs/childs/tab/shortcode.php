<?php

/**
 * Tab Shortcode
 **/

use DMS\Model\Shortcode;

if ( !class_exists( 'DMSShortcode_Tab' ) ) {
	class DMSShortcode_Tab extends Shortcode {

		public function content( $atts, $content = null ) {

			$atts = shortcode_atts( [
				'icon'		        => '',
				'title'   			=> '',
				'classes'           => ''
			], $this->atts($atts), $this->shortcode );

			$data = $this->data( array(
				'atts'    => $atts,
				'content' => $content
			));

			return DMS()->View->load( '/view/view', $data, true, $this->shortcode_dir );
		}

	}
}