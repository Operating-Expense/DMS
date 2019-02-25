<?php

/**
 * Button Shortcode
 *
 **/
use DMS\Model\Shortcode;

if ( !class_exists( 'DMSShortcode_Button' ) ) {
	class DMSShortcode_Button extends Shortcode {

		public function content( $atts, $content = null ) {

			$atts = shortcode_atts( [
				'title'		    => '',
				'link' 			=> '',
				'icon' 			=> '',
				'button_align'  => '',
				'button_size'   => '',
				'button_style'  => 'primary',
				'outline'       => '',
				'css'           => '',
				'el_id' 		=> '',
				'classes' 		=> ''
			], $this->atts($atts), $this->shortcode );

			if ( $atts['icon'] <> '' ) {
				\DMS\Helper\Assets::enqueue_style( 'font-awesome' );
			}

			$data = $this->data( array(
				'atts'    => $atts,
				'content' => $content
			));

			return DMS()->View->load( '/view/view', $data, true, $this->shortcode_dir );
		}

	}
}
