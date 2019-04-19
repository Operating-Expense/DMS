<?php

namespace DMS\Helper;


class Locale {
	
	/**
	 * Get current language
	 *
	 */
	public static function language() {
		global $locale;
		
		if ( class_exists( '\WPGlobus' ) ) {
			return \WPGlobus::Config()->language;
		}
		
		if ( ! empty( $locale ) ) {
			$e = explode( '_', $locale );
			
			return $e[0];
		}
		
		return 'en';
	}
	
	/**
	 * Get enabled languages
	 *
	 */
	public static function languages() {
		
		if ( class_exists( '\WPGlobus' ) ) {
			return \WPGlobus::Config()->enabled_languages;
		}
		
		return [];
	}
	
	/**
	 * Get text of current language
	 *
	 */
	public static function get( $text, $lang = null ) {
		
		$lang = $lang ?: self::language();
		
		$e = explode( '{:' . $lang . '}', $text );
		
		if ( isset( $e[1] ) ) {
			$e = explode( '{:}', $e[1] );
			
			return $e[0];
		}
		
		return '';
	}
	
	/**
	 * Get post content of current language
	 *
	 */
	public static function get_content( $content ) {
		$content = apply_filters( 'the_content', $content );
		$content = str_replace( ']]>', ']]&gt;', $content );
		
		return $content;
	}
	
	
	
	/**
	 * Translate
	 *
	 * @param $str
	 * @param string $lang
	 *
	 * @return string
	 */
	public static function translate( $str, $lang = '' ) {
		if ( ! class_exists( '\WPGlobus' ) ) {
			return $str;
		}
		
		
		$lang = $lang ? $lang : self::language();
		
		return \WPGlobus_Core::text_filter( $str, $lang );
	}
	
	
	
	
}
