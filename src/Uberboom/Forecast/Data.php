<?php namespace Uberboom\Forecast;

class Data
{
	/**
	 * Raw response from Forecast API
	 * @var stdClass
	 */
	protected $_response;

	/**
	 * Constructor
	 * 
	 * @param  stdClass  $response  JSON response from Forecast API
	 */
	public function __construct(\stdClass $response)
	{
		$this->_response = $response;
	}

	/**
	 * Get the requested latitude
	 *
	 * @return float
	 */
	public function getLatitude()
	{
		if (!property_exists($this->_response, 'latitude')) {
			return false;
		}
		return $this->_response->latitude;
	}
	
	/**
	 * Get the requested longitude
	 *
	 * @return float
	 */
	public function getLongitude()
	{
		if (!property_exists($this->_response, 'longitude')) {
			return false;
		}
		return $this->_response->longitude;
	}
	
	/**
	 * Get the IANA timezone name for the requested location (e.g. America/New_York)
	 * 
	 * This is the timezone used for text forecast summaries and for determining
	 * the exact start time of daily data points.
	 * 
	 * (Developers are advised to rely on local system settings rather than this value
	 * if at all possible: users may deliberately set an unusual timezone, and furthermore
	 * are likely to know what they actually want better than our timezone database does.)
	 *
	 * @return string
	 */
	public function getTimezone()
	{
		if (!property_exists($this->_response, 'longitude')) {
			return false;
		}
		return $this->_response->longitude;
	}
	
	/**
	 * Get the current timezone offset in hours from GMT.
	 * 
	 * @return int|float Float will be returned for half hour timezones
	 */
	public function getTimezoneOffset()
	{
		if (!property_exists($this->_response, 'offset')) {
			return false;
		}
		return $this->_response->offset;
	}
	
	/**
	 * Get current weather conditions at the requested location
	 *
	 * @return \Uberboom\Forecast\DataPoint
	 */
	public function currently()
	{
		if (!property_exists($this->_response, 'currently')) {
			return false;
		}
	    return new DataPoint($this->_response->currently);
	}

	/**
	 * Get minute-by-minute weather conditions for the next hour
	 *
	 * @return \Uberboom\Forecast\DataBlock
	 */
	public function minutely()
	{
		if (!property_exists($this->_response, 'minutely')) {
			return false;
		}
	    return new DataBlock($this->_response->minutely);
	}

	/**
	 * Get hour-by-hour weather conditions for the next two days
	 *
	 * @return \Uberboom\Forecast\DataBlock
	 */
	public function hourly()
	{
		if (!property_exists($this->_response, 'hourly')) {
			return false;
		}
	    return new DataBlock($this->_response->hourly);
	}

	/**
	 * Returns true if day-by-day weather conditions are available.
	 * 
	 * @return boolean
	 */
	public function hasDaily()
	{
		return property_exists($this->_response, 'daily');
	}

	/**
	 * Get day-by-day weather conditions for the next week
	 *
	 * @return \Uberboom\Forecast\DataBlock
	 */
	public function daily()
	{
		if (!$this->hasDaily()) {
			return false;
		}
	    return new DataBlock($this->_response->daily);
	}
	
	/**
	 * Returns true if weather alerts are available.
	 * 
	 * @return boolean
	 */
	public function hasAlerts()
	{
		return property_exists($this->_response, 'alerts');
	}

	/**
	 * Get any severe weather alerts, issued by a governmental weather
	 * authority, pertinent to the requested location.
	 * 
	 * @return \Uberboom\Forecast\DataAlert[]
	 */
	public function getAlerts()
	{
		if (!$this->hasAlerts()) {
			return false;
		}
		$data = array();
		foreach ($this->_response->alerts as $item) {
			$data[] = new DataAlert($item);
		}
	    return $data;
	}

	/**
	 * Get miscellaneous metadata concerning this request.
	 * 
	 * @return \Uberboom\Forecast\DataFlag
	 */
	public function getFlags()
	{
		if (!property_exists($this->_response, 'flags')) {
			return false;
		}
	    return new DataFlag($this->_response->flags);
	}

}