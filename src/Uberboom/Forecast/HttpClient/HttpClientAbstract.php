<?php namespace Uberboom\Forecast\HttpClient;

class HttpClientAbstract
{
	/**
	 * Get URL including parameters
	 *
	 * @param  string   $url 
	 * @param  array	$params   Query parameters as associative array
	 * 
	 * @return string
	 */
	public function buildUrl($url, array $params = null)
	{
		if (!is_null($params)) {
			$url .= (strpos($url, '?') !== false) ? '&' : '?';
			$url .= http_build_query($params, '', '&');
		}
		return $url;		
	}

}