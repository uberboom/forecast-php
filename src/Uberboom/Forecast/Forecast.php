<?php namespace Uberboom\Forecast;

class Forecast
{
	/**
	 * API URL
	 * @var string
	 */
	const API_URL = 'https://api.forecast.io/forecast/';

	/**
	 * API key for forecast.io
	 * @var string
	 */
	private $_apiKey;
	
	/**
	 * HTTP Client
	 * @var \Uberboom\Forecast\HttpClient\HttpClientInterface
	 */
	private $_httpClient;
	
	/**
	 * Cache
	 * @var \Uberboom\Forecast\Cache\CacheInterface
	 */
	private $_cacheStore;
	
	/**
	 * Cache lifetime in minutes
	 * @var int
	 */
	private $_cacheLifetime = 30;
	
	/**
	 * Constructor
	 * 
	 * @param  \Uberboom\Forecast\CacheStore\CacheStoreInterface $cacheStore
	 * 
	 * @return void
	 */
	public function __construct(CacheStore\CacheStoreInterface $cacheStore = null)
	{
		if (!is_null($cacheStore)) {
			$this->setCacheStore($cacheStore);
		}
	}
	
	
	/**
	 * Init
	 * 
	 * @return \Uberboom\Forecast\Forecast
	 */
	public function testitoutman()
	{
		echo 'abc ok';
		// die(__METHOD__);
		// return new static();
	}
	
	/**
	 * Set forecast.io API key
	 * 
	 * @link https://developer.forecast.io
	 *
	 * @return \Uberboom\Forecast\Forecast
	 */
	public function setApiKey($apiKey)
	{
		$this->_apiKey = $apiKey;
		return $this;
	}
	
	/**
	 * Get forecast.io API key
	 *
	 * @return void
	 */
	public function getApiKey()
	{
		return $this->_apiKey;
	}
	
	/**
	 * Set cache lifetime in minutes
	 *
	 * @return \Uberboom\Forecast\Forecast
	 */
	public function setCacheLifetime($minutes)
	{
		$this->_cacheLifetime = $lifetime;
		return $this;
	}
	
	/**
	 * Get cache lifetime in minutes
	 *
	 * @return void
	 */
	public function getCacheLifetime()
	{
		return $this->_cacheLifetime;
	}
	
	/**
	 * Set http request wrapper class
	 * 
	 * @param  \Uberboom\Forecast\HttpClient\HttpClientInterface $httpClient
	 * 
	 * @return \Uberboom\Forecast\Forecast
	 */
	public function setHttpClientWrapper(HttpClient\HttpClientInterface $httpClient)
	{
		$this->_httpClient = $httpClient;
		return $this;
	}
	
	/**
	 * Set cache wrapper class
	 * 
	 * @param  \Uberboom\Forecast\CacheStore\CacheStoreInterface $cacheStore
	 * 
	 * @return \Uberboom\Forecast\Forecast
	 */
	public function setCacheStore(CacheStore\CacheStoreInterface $cacheStore)
	{
		$this->_cacheStore = $cacheStore;
		return $this;
	}
	
	/**
	 * Get forecast data
	 * 
	 * @return todo
	 */
	public function getWeatherByLocation($latitude, $longitude)
	{
		if (!$this->_httpClient instanceof \Uberboom\Forecast\HttpClient\HttpClientInterface) {
			throw new \Uberboom\Forecast\Exception('HTTP client not initialized');
		}

		$cacheKey = serialize(array(__METHOD__, $latitude, $longitude));

		if ($this->_cacheStore && $this->_cacheStore->has($cacheKey)) {

			// already in cache
			$json = $this->_cacheStore->get($cacheKey);

		} else {

			// get from api
			$url = self::API_URL . $this->_apiKey . '/' . urlencode($latitude . ',' . $longitude);
			$response = $this->_httpClient->get($url);
			$json = json_decode($response);
			if ($json === false) {
				throw new \Uberboom\Forecast\Exception('Could not retrieve weather forecast');
			}

			// save in cache
			if ($this->_cacheStore) {
				$this->_cacheStore->put($cacheKey, $json, $this->_cacheLifetime);
			}
			
		}
		
		return new Data($json);

	}
	
}