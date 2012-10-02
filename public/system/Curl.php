<?php
class Curl 
{

	function __construct() {
		$this->c = curl_init();

    }

	function url_contents($url, $query_data = NULL, $requestMethod = 'GET') 
	{
		// return the contens of an url with POST params and authentication based on setings;
		if ($requestMethod != 'GET') die ( sprintf( "%s method not implemented yet.", $requestMethod ));

		$query_string = '';
		if ($query_data) {
			$query_string = sprintf("?%s", http_build_query ( $query_data ) );
		}

		curl_setopt($this->c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->c, CURLOPT_VERBOSE, true);
		curl_setopt($this->c, CURLOPT_URL, $url . $query_string);

		$contents = curl_exec($this->c);

		if ($contents) return $contents;
			else return FALSE;
  	}

  	function close() {
		curl_close($this->c);
  	}


}