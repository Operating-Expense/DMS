<?php

namespace DMS\Helper;


class Logger {
	
	const LOGGING_ENABLED = true;
	const LOGGING_TIME_MS = true;
	
	
	
	public static function getMicroTime() {
		$t     = microtime( true );
		$micro = sprintf( '%06d', ( $t - floor( $t ) ) * 1000000 );
		$d     = null;
		try {
			$d = new \DateTime( date( 'Y-m-d H:i:s.' . $micro, $t ) );
		} catch ( \Exception $e ) {
			
		}
		
		return $d ? $d->format( 'Y-m-d H:i:s.u' ) : ''; //note "u" is microseconds (1 seconds = 1000000 µs).
	}
	
	
	
	public static function _log( $var, $desc = ' >> ', $log_file_destination = null, $clear_log = false ) {
		
		if ( ! self::LOGGING_ENABLED ) {
			return;
		}
		
		if ( ! $log_file_destination ) {
			//$log_file_destination = get_stylesheet_directory() . '/logs/Dev_' . date( 'Y-m-d' ) . '.log';
			$log_file_destination = wp_get_upload_dir()['basedir'] . '/dmslogs/Dev_' . date( 'Y-m-d' ) . '.log';
		}
		
		if ( ! file_exists( dirname( $log_file_destination ) ) ) {
			@mkdir( dirname( $log_file_destination ), 0775, true );
		}
		
		if ( $clear_log ) {
			file_put_contents( $log_file_destination, '' );
		}
		
		if ( self::LOGGING_TIME_MS ) {
			$time_mark = '[' . self::getMicroTime() . '] ';
		} else {
			$time_mark = '[' . date( 'Y-m-d H:i:s' ) . '] ';
		}
		
		error_log( $time_mark . $desc . ' ' . print_r( $var, true ) . PHP_EOL, 3, $log_file_destination );
		
	}
	
	
	
	public static function log( $var, $desc = ' ', $name = 'default', $separate = false ) {
		
		if ( ! self::LOGGING_ENABLED ) {
			return;
		}
		$date = $separate ? date( 'Y-m-d_H' ) : date( 'Y-m-d' );
		
		$log_file_destination = wp_get_upload_dir()['basedir'] . '/dmslogs/' . $name . '_' . $date . '.log';
		self::_log( $var, $desc, $log_file_destination, false );
		
	}
	
	
}