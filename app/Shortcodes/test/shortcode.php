<?php

use dms\Helper\Assets;
use dms\Model\Shortcode;

if ( ! class_exists( 'dmsShortcode_test' ) ) {
	class dmsShortcode_test extends Shortcode {
		
		public function content( $atts, $content = null ) {
			
			$atts = shortcode_atts( [
				'title'        => '',
				'image'        => '',
				'btn_try_text' => '',
				'btn_try_url'  => '#',
				'el_classes'   => '',
				'el_id'        => '',
			
			], $this->atts( $atts ), $this->shortcode );
			
			
			Assets::enqueue_style_dist(
				$this->shortcode . '-style',
				'shortcode-' . $this->shortcode . '.css'
			);
			
			$data = $this->data( array(
				'atts'    => $atts,
				'content' => $content,
			) );
			
			return DMS()->View->load( '/view/view', $data, true, $this->shortcode_dir );
			
		}
		
	}
}
