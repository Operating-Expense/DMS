<?php

use dms\Helper\Assets;
use dms\Model\Shortcode;

if ( ! class_exists( 'dmsShortcode_stat' ) ) {
	class dmsShortcode_stat extends Shortcode {
		
		public function content( $atts, $content = null ) {
			
			$atts = shortcode_atts( [
				'items'      => '',
				'title'      => '',
				'el_classes' => '',
				'el_id'      => '',
			
			], $this->atts( $atts ), $this->shortcode );
			
			$atts['items_arr'] = vc_param_group_parse_atts( $atts['items'] );
			
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
