<?php

namespace Mana;

if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * @property  controller
 */
class Request {
	private $Controller;

	function __construct() {

		// Route to controller
		$args                 = explode( "/", $this->path_info() );
		$controller_class     = 'Controller' . ucfirst( $args[1] );
		$controller_arguments = array_slice( $args, 2 );
		if ( class_exists( $controller_class, true ) ) {
			$this->Controller = new $controller_class( $this, $controller_arguments );
		} else {
			$this->class_not_callable( $controller_class );
		}
	}

	/**
	 * Return consistant path based on server variable and home_page path fallback
	 *
	 * @return string Returns information about a file path
	 */
	function path_info() {
		$path_info = '';
		if ( isset( $_SERVER['PATH_INFO'] ) ) {
			$path_info = $_SERVER['PATH_INFO'];
		}


		$no_specified_path = empty( $path_info ) || $path_info == '/';
		if ( $no_specified_path ) {
			$path_info = \Configuration::HOME_PAGE;
		} else {
			$ends_with_slash = ! substr( strrchr( $path_info, "/" ), 1 );
			if ( $ends_with_slash ) {
				$slashless_request = substr( $path_info, 0, - 1 );
				$Url               = new Url( $slashless_request );
				header( 'Location: ' . $Url->url_absolute );
				exit();
			}
		}

		return (string) $path_info;
	}

	/**
	 * Requesting urls without controller
	 *
	 * @param  string $controller_class name of controller
	 */
	function class_not_callable( $controller_class ) {
		$Url         = new Url( '/errors/404' );
		$log_message = "Not callable '$controller_class' or missing parameter.";
		$this->redirect( $Url, $log_message );
	}

	/**
	 * Redirect to new url
	 *
	 * @param Url $Url URL to redirect to
	 * @param $log_message
	 */
	function redirect( $Url, $log_message ) {
		echo( "Location: " . $Url->url_absolute );
		exit( $log_message );
	}
}