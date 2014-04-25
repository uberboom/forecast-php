<?php namespace Uberboom\Forecast\HttpClient;

interface HttpClientInterface
{
	/**
	 * HTTP GET request
	 *
	 * @param  string   $url 
	 * @param  array    $params   Query parameters as associative array
	 * 
	 * @return string   Response body
	 */
	public function get($url, array $params = null);

}