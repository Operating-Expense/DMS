<?php

use dms\Helper\Assets;
use dms\Model\Shortcode;

if ( ! class_exists( 'dmsShortcode_Account' ) ) {
	class dmsShortcode_Account extends Shortcode {
		
		public function content( $atts, $content = null ) {
			
			$atts = shortcode_atts( [
				'el_classes' => '',
				'el_id'      => '',
			
			], $this->atts( $atts ), $this->shortcode );
			
			Assets::enqueue_script( $this->shortcode . '-script', $this->shortcode_uri . '/assets/scripts.js' );
			
			Assets::enqueue_style_dist(
				$this->shortcode . '-style',
				'shortcode-' . $this->shortcode . '.css'
			);
			
			$data = $this->data( array(
				'atts'    => $atts,
				'content' => $content
			) );
			
			return DMS()->View->load( '/view/view', $data, true, $this->shortcode_dir );
			
		}
		
	}
}
