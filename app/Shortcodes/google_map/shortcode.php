<?php
/**
 * Google Map Shortcode
 *
 **/

use DMS\Helper\Assets;
use DMS\Model\Shortcode;

if ( !class_exists( 'DMSShortcode_Google_Map' ) ) {
	class DMSShortcode_Google_Map extends Shortcode {

		public function content( $atts, $content = null ) {

			/** Shortcode data **/
			$atts = shortcode_atts( [
				'el_id'         => '',
				'api_key'       => '',
				'address'       => '',
				'height'        => '',
				'zoom'          => '',
				'pin_icon'      => '',
				'pin_label'      => '',
				'pin_color'      => '',
				'pin_fontweight' => '',
				'pin_labelorigin' => '',
				'pin_offset_x'  => '',
				'pin_offset_y'  => '',
				'hue'           => '',
				'saturation'    => '',
				'lightness'     => '',
				'gamma'         => ''
			], $this->atts($atts), $this->shortcode );

			$data = $this->data( [
				'atts'    => $atts,
				'content' => $content
			]);

			$api_key = $atts['api_key'] !== '' ? '?key=' . $atts['api_key'] : '';
			Assets::enqueue_script( 'google-maps-api', 'https://maps.googleapis.com/maps/api/js' . $api_key);

			$map_loader_script = DMS()->View->load( '/view/google_map_init', $data, true, $this->shortcode_dir );
			
			Assets::add_inline_script( 'google-maps-api', $map_loader_script );

			return DMS()->View->load( '/view/view', $data, true, $this->shortcode_dir );
		}
	}
}
