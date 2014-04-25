<?php namespace Uberboom\Forecast\HttpClient;

class File extends HttpClientAbstract implements HttpClientInterface
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
		
		// make call
		$options = array(
			'http' => array(
				'method'  => 'GET',
			),
		);
		$context  = stream_context_create($options);
		$response = file_get_contents($url, false, $context);
		if (!$response) {
			throw new Uberboom\Forecast\HttpRequest\Exception('Could not retrieve HTTP response');
		}

		return $response;

	}

}

