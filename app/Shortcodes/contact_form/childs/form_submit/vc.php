<?php

/**
 * Form Submit Child / VC Support
 **/

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_Form_Submit extends WPBakeryShortCode {

		protected function content( $atts, $content = null ) {

			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

			return DMS()->Controller->Shortcodes->content($this->settings['base'], $atts, $content);
		}

	}
}