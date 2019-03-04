<?php

use dms\Helper\Assets;
use dms\Model\Shortcode;

if ( ! class_exists( 'dmsShortcode_intro' ) ) {
	class dmsShortcode_intro extends Shortcode {
		
		public function content( $atts, $content = null ) {
			
			$atts = shortcode_atts( [
				'header_title_l' => '',
				'header_title_r' => '',
				'title'          => '',
				'btn_try_text'   => '',
				'btn_try_url'    => '#',
				'btn_about_text' => '',
				'btn_about_url'  => '#',
				'btn_how_text'   => '',
				'btn_how_url'    => '#',
				'el_classes'     => '',
				'el_id'          => '',
			
			], $this->atts( $atts ), $this->shortcode );
			
			
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
