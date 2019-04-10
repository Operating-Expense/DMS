<?php

namespace DMS\Helper;

/**
 * Front Helper
 *
 * Helper functions for templates and front controllers
 *
 * @category   Wordpress
 * @package    Starter Kit Backend
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */
class Front {
	
	/**
	 * Get post / page content classes
	 *
	 * @param int $sidebar_size
	 *
	 * @return string
	 */
	public static function get_grid_class( $sidebar_size = 4 ) {
		
		$classes_string = '';
		
		// If Unyson Framework plugin is active
		if ( function_exists( '\fw_ext_sidebars_get_current_position' ) ) {
			
			$current_sidebar_position = \fw_ext_sidebars_get_current_position();
			$current_sidebar_position = is_null( $current_sidebar_position ) ? 'right' : $current_sidebar_position;
			
			$content_size = 12 - $sidebar_size;
			
			if ( $current_sidebar_position == 'full' ) {
				$classes_string = 'col-md-12';
			} elseif ( $current_sidebar_position == 'left' ) {
				$classes_string = 'col-md-' . $content_size;
			} else {
				$classes_string = 'col-md-' . $content_size;
			}
			
		} else {
			$classes_string = 'col-md-8';
		}
		
		return $classes_string;
	}
	
	
	/**
	 * Get post categories list
	 *
	 * @param string $separator
	 *
	 * @return mixed
	 */
	public static function get_categories( $separator = ', ' ) {
		
		$post_type = \get_post_type();
		
		switch ( $post_type ) {
			default:
			case 'post':
				return self::get_valid_category_list( $separator );
				break;
		}
		
	}
	
	/**
	 * Get valid categories list
	 *
	 * @param string $separator
	 *
	 * @return mixed
	 */
	public static function get_valid_category_list( $separator = ', ' ) {
		$s = str_replace( ' rel="category"', '', \get_the_category_list( $separator ) );
		$s = str_replace( ' rel="category tag"', '', $s );
		
		return $s;
	}
	
	/**
	 * Get valid tags list
	 *
	 * @param string $separator
	 *
	 * @return mixed
	 */
	public static function get_valid_tags_list( $separator = ', ' ) {
		$s = str_replace( ' rel="tag"', '', \get_the_tag_list( '', $separator, '' ) );
		
		return $s;
	}
	
	
	public static function the_lang_select() {
		
		if ( ! class_exists( '\WPGlobus' ) ) {
			return '';
		}
		
		$enabled_languages = \WPGlobus::Config()->enabled_languages;
		$current_language  = \WPGlobus::Config()->language;
		
		?>
		<div class="lang-selector">
			
			<select name="lang-select" class="lang-select" onchange="document.location.href = this.value;">
				
				<?php foreach ( $enabled_languages as $language ) {
					$selected = $language === $current_language ? ' selected' : '';
					$url      = \WPGlobus_Utils::localize_current_url( $language );
					$code     = strtoupper( $language );
					//$name     = \WPGlobus::Config()->language_name[ $language ];
					
					?>
					<option value="<?php echo $url ?>" <?php echo $selected ?>><?php echo $code ?></option>
				<?php } ?>
			</select>
		
		</div>
		
		<?php
	}
	
	
	public static function the_lang_list() {
		if ( ! class_exists( '\WPGlobus' ) ) {
			return '';
		}
		
		$enabled_languages = \WPGlobus::Config()->enabled_languages;
		$current_language  = \WPGlobus::Config()->language;
		
		?>
		<div class="lang-selector-list">
			
			<ul class="lang-list">
				
				<?php foreach ( $enabled_languages as $language ) {
					$current  = $language === $current_language;
					$url      = \WPGlobus_Utils::localize_current_url( $language );
					$code     = strtoupper( $language );
					//$name     = \WPGlobus::Config()->language_name[ $language ];
					//$flag_src = \WPGlobus::Config()->flags_url . \WPGlobus::Config()->flag[ $language ];
					//$flag_img = '<img src="' . $flag_src . '"/>';
					
					if ( $current ) {
						?>
						<li><span><?php echo $code ?></span></li>
						<?php
					} else {
						?>
						<li><a href="<?php echo $url ?>"><?php echo $code ?></a></li>
						<?php
					}
					?>
				<?php } ?>
			
			</ul>
		</div>
		
		<?php
	}
	
}
