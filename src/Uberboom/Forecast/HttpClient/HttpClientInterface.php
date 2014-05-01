<?php

/**
 * Forecast.io package
 * 
 * PHP package to simplify Forecast.io API calls
 * 
 * @package  Forecast
 * @author   Bernd Ennsfellner <bernd@ennsfellner.at>
 */

namespace Uberboom\Forecast\HttpClient;

/**
 * Interface for the HTTP client used by the Forecast package
 */
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