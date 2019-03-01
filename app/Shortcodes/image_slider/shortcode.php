<?php

use dms\Helper\Assets;
use dms\Model\Shortcode;

if ( ! class_exists( 'dmsShortcode_Image_Slider' ) ) {
	
	class dmsShortcode_Image_Slider extends Shortcode {
		
		public function content( $atts, $content = null ) {
			
			$atts = shortcode_atts( [
				'title'          => '',
				'el_classes'     => '',
				'el_id'          => '',
				'items'          => '',
				'autoplay'       => 'off',
				'autoplay_speed' => 3000,
				'num'            => 6,
				'num_medium'     => 3,
				'num_small'      => 1,
			], $this->atts( $atts ), $this->shortcode );
			
			$atts['items_arr'] = vc_param_group_parse_atts( $atts['items'] );
			$atts['autoplay']  = empty( $atts['autoplay'] ) ? 'off' : $atts['autoplay'];
			
			
			$data = $this->data( array(
				'atts'    => $atts,
				'content' => $content
			) );
			
			wp_enqueue_script( 'slick' );
			wp_enqueue_style( 'slick' );
			wp_enqueue_style( 'slick-theme' );
			
			
			Assets::enqueue_style_dist(
				$this->shortcode . '-style',
				'shortcode-' . $this->shortcode . '.css'
			);
			
			
			Assets::enqueue_script( $this->shortcode . '-script', $this->shortcode_uri . '/assets/scripts.js' );
			
			
			return DMS()->View->load( '/view/view', $data, true, $this->shortcode_dir );
		}
		
	}
}