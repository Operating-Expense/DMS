<?php
/**
 * Form Text Datepicker Field / Form Shortcode
 *
 **/

use DMS\Helper\Assets;
use DMS\Model\Shortcode;

if ( !class_exists( 'DMSShortcode_Form_Text_Datepicker' ) ) {
	class DMSShortcode_Form_Text_Datepicker extends Shortcode {

		public function content( $atts, $content = null ) {

			$atts = shortcode_atts( [
				'el_id'         =>  '',
				'required'      => '',
				'placeholder'   => '',
				'create_event'  => ''
			], $this->atts($atts), $this->shortcode );

			$attributes   = [];
			$attributes[] = 'id = "field_' . esc_attr($atts['el_id']) . '"';
			$attributes[] = 'name = "field_' . esc_attr($atts['el_id']) . '"';
			$attributes[] = 'placeholder = "' . esc_attr($atts['placeholder']) . '"';

			if ( filter_var( $atts['required'], FILTER_VALIDATE_BOOLEAN) ) {
				$attributes[] = 'required = "required"';
			}

			$this->enqueue_scripts();

			$data = $this->data( array(
				'atts'    => $atts,
				'attributes' => $attributes
			));

			return DMS()->View->load( '/view/view', $data, true, $this->shortcode_dir );
		}

		/**
		 *
		 * Add Styles and scripts
		 *
		 *
		 * @return void
		 */
		public function enqueue_scripts() {

			Assets::enqueue_script( 'shortcode-air-datepicker', $this->shortcode_uri.'/assets/libs/air-datepicker/dist/js/datepicker.min.js' );
			Assets::enqueue_script( 'shortcode-air-datepicker-i18n', $this->shortcode_uri.'/assets/libs/air-datepicker/dist/js/i18n/datepicker.en.js' );
			Assets::enqueue_script( 'shortcode-air-datepicker-init', $this->shortcode_uri.'/assets/date-picker-init.js' );

			Assets::enqueue_style( 'shortcode-air-datepicker', $this->shortcode_uri.'/assets/libs/air-datepicker/dist/css/datepicker.min.css' );
		}

	}
}
