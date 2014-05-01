<?php namespace Uberboom\Forecast;

class Forecast
{
	/**
	 * API URL
	 * @var string
	 */
	const API_URL = 'https://api.forecast.io/forecast/';

	/**
	 * Imperial (US) units
	 * @var string
	 */
	const UNITS_US = 'us';
	
	/**
	 * International system of units (SI, “Le Système international d'unités”)
	 * @var string
	 */
	const UNITS_SI = 'si';

	/**
	 * Identical to {@link UNITS_SI}, except that windSpeed is in kilometers per hour.
	 * @var string
	 */
	const UNITS_CA = 'ca';

	/**
	 * Identical to {@link UNITS_SI}, except that windSpeed is in miles per hour, as in the US. (This option is provided because adoption of SI in the UK has been inconsistent.)
	 * @var string
	 */
	const UNITS_UK = 'uk';

	/**
	 * Selects the relevant units automatically, based on geographic location.
	 * @var string
	 */
	const UNITS_AUTO = 'auto';

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
	 * Units
	 * @var string
	 */
	private $_units;
	
	/**
	 * Constructor
	 * 
	 * @param  \Uberboom\Forecast\CacheStore\CacheStoreInterface $cacheStore
	 * 
	 * @return void
	 */
	public function __construct(CacheStore\CacheStoreInterface $cacheStore = null, HttpClient\HttpClientInterface $httpClient)
	{
		if (!is_null($cacheStore)) {
			$this->setCacheStore($cacheStore);
		}
		if (!is_null($httpClient)) {
			$this->setHttpClientWrapper($httpClient);
		}
		if (class_exists('\Illuminate\Config\Repository')) {
			$this->setApiKey(\Config::get('forecast::api_key'));
		}
	}
	
	
	/**
	 * Set forecast.io API key
	 * 
	 * @param  string   $api_key   API key
	 * 
	 * @link   https://developer.forecast.io
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
	 * @return string
	 */
	public function getApiKey()
	{
		if (!$this->_apiKey) {
			throw new \Uberboom\Forecast\Exception('API key not set');
		}
		return $this->_apiKey;
	}
	
	/**
	 * Set cache lifetime in minutes
	 * 
	 * @param  int  $minutes  Cache lifetime
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
	 * @return int
	 */
	public function getCacheLifetime()
	{
		return $this->_cacheLifetime;
	}
	
	/**
	 * Set units used for the API request
	 * 
	 * @see    self::UNITS_*
	 * 
	 * @param  string  $units  Units
	 *
	 * @return \Uberboom\Forecast\Forecast
	 */
	public function setUnits($units)
	{
		$this->_units = $units;
		return $this;
	}
	
	/**
	 * Get units used for the API request
	 *
	 * @return string
	 */
	public function getUnits()
	{
		return $this->_units;
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
	 * @param float      $latitude   Latitude of a location in decimal degrees
	 * @param float      $longitude  Longitude of a location in decimal degrees
	 * @param int|string $time       UNIX time or a string formatted as follows: [YYYY]-[MM]-[DD]T[HH]:[MM]:[SS] (with an optional time zone formatted as Z for GMT time or {+,-}[HH][MM] for an offset in minutes or seconds). For the latter format, if no timezone is present, local time (at the provided latitude and longitude) is assumed. (This string format is a subset of ISO 8601 time. An as example, 2013-05-06T12:00:00-0400.)
	 * 
	 * @return todo
	 */
	public function getWeatherByLocation($latitude, $longitude, $time = null)
	{
		if (!$this->_httpClient instanceof \Uberboom\Forecast\HttpClient\HttpClientInterface) {
			throw new \Uberboom\Forecast\Exception('HTTP client not initialized');
		}

		$cacheKey = serialize(array(__METHOD__, $latitude, $longitude, $time, $this->_units));

		if ($this->_cacheStore && $this->_cacheStore->has($cacheKey)) {

			// already in cache
			$json = $this->_cacheStore->get($cacheKey);

		} else {

			// get from api
			$url = self::API_URL . $this->getApiKey() . '/' . urlencode($latitude . ',' . $longitude);
			if (!is_null($time)) {
				$url .= ',' . urlencode($time);
			}
			if (!is_null($this->_units)) {
				$url .= '?' . http_build_query(array('units' => $this->_units));
			}
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