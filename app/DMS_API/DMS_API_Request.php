<?php

namespace DMS\DMS_API;

use DMS\Helper\Logger;



class DMS_API_Request {
	
	private $ch;
	
	
	
	/**
	 * Init curl session
	 *
	 * @param array $options An array specifying which options to set and their values.
	 * The keys should be valid curl_setopt constants or
	 * their integer equivalents.
	 */
	public function init( $options ) {
		$this->ch = curl_init();
		
		$options_defaults = [
			CURLOPT_URL            => 'http://api.dmsolutions.com.ua:2660/api/',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HEADER         => true,
			CURLOPT_ENCODING       => '',
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 0,
			CURLOPT_FOLLOWLOCATION => false,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => 'GET',
			CURLOPT_SSL_VERIFYPEER => false,
			//CURLOPT_POSTFIELDS     => '',
			CURLOPT_HTTPHEADER     => [
				'Accept-Charset: charset=utf-8',
				'Content-Type: application/json',
			],
		];
		
		$options = array_replace( $options_defaults, $options );
		
		//Logger::log( $options, 'request >>', 'api_request' );
		
		curl_setopt_array( $this->ch, $options );
	}
	
	
	
	/**
	 * Make curl request
	 *
	 * @return array  ['header','body','curl_error','http_code','last_url']
	 */
	public function exec() {
		$response   = curl_exec( $this->ch );
		$curl_error = curl_error( $this->ch );
		$result     = [
			'headers_raw' => '',
			//'headers'     => '',
			'body_raw'    => '',
			'body'        => '',
			'curl_error'  => '',
			'http_code'   => '',
			'last_url'    => '',
		];
		if ( $response === false || $curl_error !== '' ) {
			$result['curl_error'] = $curl_error;
			
			return $result;
		}
		
		// headers
		$header_size           = curl_getinfo( $this->ch, CURLINFO_HEADER_SIZE );
		$result['headers_raw'] = substr( $response, 0, $header_size );
		/*
		$headers_arr = explode( "\r\n", $result['headers_raw'] );
		$headers_arr = array_filter( $headers_arr );
		$headers     = [];
		
		foreach ( $headers_arr as $header_raw_row ) {
			$header_arr = explode( ' ', $header_raw_row );
			$header_arr = array_filter( $header_arr );
			$headers[]  = $header_arr;
		}
		
		$result['headers'] = $headers;
		*/
		// body
		$result['body_raw'] = substr( $response, $header_size );
		$result['body']     = self::may_be_json( $result['body_raw'] );
		
		// code
		$result['http_code'] = curl_getinfo( $this->ch, CURLINFO_HTTP_CODE );
		
		// url
		$result['last_url'] = curl_getinfo( $this->ch, CURLINFO_EFFECTIVE_URL );
		
		Logger::log( $result, 'response >>', 'api_request' );
		
		return $result;
	}
	
	
	
	/**
	 * @param $string
	 * @param bool $return_decoded
	 *
	 * @return array|bool|mixed|object|null
	 */
	public static function may_be_json( $string, $return_decoded = true ) {
		$may_be_json = json_decode( $string, true );
		if ( $return_decoded ) {
			return ( json_last_error() === JSON_ERROR_NONE ) ? $may_be_json : null;
		}
		
		return json_last_error() === JSON_ERROR_NONE;
	}
	
	
}