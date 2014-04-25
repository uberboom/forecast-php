<?php namespace Uberboom\Forecast\HttpClient;

class Curl extends HttpClientAbstract implements HttpClientInterface
{

	/**
	 * HTTP GET request
	 *
	 * @param  string   $url 
	 * @param  array	$params   Query parameters as associative array
	 * 
	 * @return string   Response body
	 */
	public function get($url, array $params = null)
	{
		$url = $this->buildUrl($url, $params);
		
		// make curl call
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		if (!$response) {
			throw new Uberboom\Forecast\HttpRequest\Exception(curl_error($ch), curl_errno($ch));
		}
		$httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if ($httpStatus != 200) {
			throw new Uberboom\Forecast\HttpRequest\Exception('API returned HTTP status code ' . $httpStatus);
		}
		curl_close($ch);

		return $response;

	}

}

