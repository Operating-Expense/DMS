<?php
/**
 * Form Textarea Field / Form Shortcode
 *
 **/

use DMS\Model\Shortcode;

if ( !class_exists( 'DMSShortcode_Form_Textarea' ) ) {
	class DMSShortcode_Form_Textarea extends Shortcode {

		public function content( $atts, $content = null ) {

			$atts = shortcode_atts( [
				'el_id'         =>  '',
				'required'      => '',
				'placeholder'   => ''
			], $this->atts($atts), $this->shortcode );

			$attributes   = [];
			$attributes[] = 'id = "field_' . esc_attr($atts['el_id']) . '"';
			$attributes[] = 'name = "field_' . esc_attr($atts['el_id']) . '"';
			$attributes[] = 'placeholder = "' . esc_attr($atts['placeholder']) . '"';

			if ( filter_var( $atts['required'], FILTER_VALIDATE_BOOLEAN) ) {
				$attributes[] = 'required = "required"';
			}

			$data = $this->data( array(
				'atts'    => $atts,
				'attributes' => $attributes
			));

			return DMS()->View->load( '/view/view', $data, true, $this->shortcode_dir );
		}

	}
}