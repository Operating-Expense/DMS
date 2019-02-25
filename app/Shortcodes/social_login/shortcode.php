<?php
/**
 * Social Login Shortcode
 *
 */

use DMS\Model\Shortcode;
use DMS\Helper\Assets;

if ( !class_exists( 'DMSShortcode_Social_Login' ) ) {
	class DMSShortcode_Social_Login extends Shortcode {

		public function content( $atts, $content = null ) {

			$atts = shortcode_atts( [], $this->atts($atts), $this->shortcode );

			Assets::enqueue_style( 'font-awesome' );
			Assets::enqueue_style_dist(
				$this->shortcode.'-style',
				'shortcode-social_login.css'
			);

			$data = $this->data( array(
				'atts'    => $atts,
				'content' => $content,
			));

			return DMS()->View->load( '/view/view', $data, true, $this->shortcode_dir );
		}

	}
}
