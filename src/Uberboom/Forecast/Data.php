<?php namespace Uberboom\Forecast;

class Data
{
	/**
	 * Raw response from Forecast API
	 * 
	 * @var stdClass
	 */
	protected $_response;

	/**
	 * Flags
	 * 
	 * Flags are stored in this property after accessing getFlags() for the first time.
	 * 
	 * @see getFlags()
	 * 
	 * @var DataFlag
	 */
	protected $_flags;

	/**
	 * Currently
	 * 
	 * Currently is stored in this property after accessing currently() for the first time.
	 * 
	 * @see currently()
	 * 
	 * @var DataPoint
	 */
	protected $_currently;

	/**
	 * Minutely
	 * 
	 * Minutely is stored in this property after accessing minutely() for the first time.
	 * 
	 * @see minutely()
	 * 
	 * @var DataPoint
	 */
	protected $_minutely;

	/**
	 * Hourly
	 * 
	 * Hourly is stored in this property after accessing hourly() for the first time.
	 * 
	 * @see hourly()
	 * 
	 * @var DataPoint
	 */
	protected $_hourly;

	/**
	 * Daily
	 * 
	 * Daily is stored in this property after accessing daily() for the first time.
	 * 
	 * @see daily()
	 * 
	 * @var DataPoint
	 */
	protected $_daily;

	/**
	 * Units
	 * 
	 * Units used in response is stored in this property after accessing getUnits() for the first time.
	 * 
	 * @see getUnits()
	 * 
	 * @var string
	 */
	protected $_units;
	
	/**
	 * Units to method mapping
	 *
	 * @var array
	 */
	protected $_unitsByMethod = array(
		'getNearestStormDistanceUnit' => array(
			'ca' => 'km',
			'si' => 'km',
			'uk' => 'km',
			'us' => 'mi',
		),
		'getPrecipIntensityUnit' => array(
			'ca' => 'mm/h',
			'si' => 'mm/h',
			'uk' => 'mm/h',
			'us' => 'in/h',
		),
		'getPrecipAccumulationUnit' => array(
			'ca' => 'cm',
			'si' => 'cm',
			'uk' => 'cm',
			'us' => 'in',
		),
		'getTemperatureUnit' => array(
			'ca' => '°C',
			'si' => '°C',
			'uk' => '°C',
			'us' => '°F',
		),
		'getWindSpeedUnit' => array(
			'ca' => 'km/h',
			'si' => 'm/s',
			'uk' => 'mi/h',
			'us' => 'mi/h',
		),
		'getPressureUnit' => array(
			'ca' => 'mbar',
			'si' => 'mbar',
			'uk' => 'mbar',
			'us' => 'hPa',
		),
		'getVisibilityUnit' => array(
			'ca' => 'km',
			'si' => 'km',
			'uk' => 'km',
			'us' => 'mi',
		),
		'getOzoneUnit' => array(
			'ca' => 'DU',
			'si' => 'DU',
			'uk' => 'DU',
			'us' => 'DU',
		),
	);

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
		if (!property_exists($this->_response, 'timezone')) {
			return false;
		}
		return $this->_response->timezone;
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
	 * Returns true if current weather conditions are available.
	 * 
	 * @return boolean
	 */
	public function hasCurrently()
	{
		return property_exists($this->_response, 'currently');
	}

	/**
	 * Get current weather conditions at the requested location
	 *
	 * @return \Uberboom\Forecast\DataPoint
	 */
	public function currently()
	{
		// return data stored in property if exists to improve performance
		if (!is_null($this->_currently)) {
			return $this->_currently;
		}

		if (!$this->hasCurrently()) {
			return false;
		}
	    return new DataPoint($this->_response->currently, $this->getTimezone());
	}

	/**
	 * Returns true if minute-by-minute weather conditions are available.
	 * 
	 * @return boolean
	 */
	public function hasMinutely()
	{
		return property_exists($this->_response, 'minutely');
	}

	/**
	 * Get minute-by-minute weather conditions for the next hour
	 *
	 * @return \Uberboom\Forecast\DataBlock
	 */
	public function minutely()
	{
		// return data stored in property if exists to improve performance
		if (!is_null($this->_minutely)) {
			return $this->_minutely;
		}

		if (!$this->hasMinutely()) {
			return false;
		}
	    return new DataBlock($this->_response->minutely, $this->getTimezone());
	}

	/**
	 * Returns true if hour-by-hour weather conditions are available.
	 * 
	 * @return boolean
	 */
	public function hasHourly()
	{
		return property_exists($this->_response, 'hourly');
	}

	/**
	 * Get hour-by-hour weather conditions for the next two days
	 *
	 * @return \Uberboom\Forecast\DataBlock
	 */
	public function hourly()
	{
		// return data stored in property if exists to improve performance
		if (!is_null($this->_hourly)) {
			return $this->_hourly;
		}

		if (!$this->hasHourly()) {
			return false;
		}
	    return new DataBlock($this->_response->hourly, $this->getTimezone());
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
		// return data stored in property if exists to improve performance
		if (!is_null($this->_daily)) {
			return $this->_daily;
		}

		if (!$this->hasDaily()) {
			return false;
		}
	    return new DataBlock($this->_response->daily, $this->getTimezone());
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
			$data[] = new DataAlert($item, $this->getTimezone());
		}
	    return $data;
	}

	/**
	 * Returns true if flags are available.
	 * 
	 * @return boolean
	 */
	public function hasFlags()
	{
		return property_exists($this->_response, 'flags');
	}

	/**
	 * Get miscellaneous metadata concerning this request.
	 * 
	 * @return \Uberboom\Forecast\DataFlag
	 */
	public function getFlags()
	{
		// return flags stored in property if exists to improve performance
		if (!is_null($this->_flags)) {
			return $this->_flags;
		}

		if (!$this->hasFlags()) {
			$this->_flags = false;
			return false;
		}
	    $this->_flags = new DataFlag($this->_response->flags, $this->getTimezone());
		return $this->_flags;
	}

	/**
	 * Get units used in response
	 *
	 * @see DataFlag::getUnits
	 * 
	 * @return string
	 */
	protected function _getUnits()
	{
		if (!is_null($this->_units)) {
			return $this->_units;
		}

		$flags = $this->getFlags();
		if (!$flags) {
			$this->_units = false;
		} else {
			$this->_units = $flags->getUnits();
		}
		return $this->_units;
	}
	
	/**
	 * Get unit used for {@link DataPoint\getNearestStormDistance()}
	 * 
	 * @return string
	 */
	public function getNearestStormDistanceUnit()
	{
		return $this->_getUnitByMethod(__FUNCTION__);
	}
	
	/**
	 * Get unit used for {@link DataPoint\todo()}
	 * 
	 * @return string
	 */
	public function getPrecipIntensityUnit()
	{
		return $this->_getUnitByMethod(__FUNCTION__);
	}

	/**
	 * Get unit used for {@link DataPoint\todo()}
	 * 
	 * @return string
	 */
	public function getPrecipAccumulationUnit()
	{
		return $this->_getUnitByMethod(__FUNCTION__);
	}

	/**
	 * Get unit used for {@link DataPoint\todo()}
	 * 
	 * @return string
	 */
	public function getTemperatureUnit()
	{
		return $this->_getUnitByMethod(__FUNCTION__);
	}

	/**
	 * Get unit used for {@link DataPoint\todo()}
	 * 
	 * @return string
	 */
	public function getWindSpeedUnit()
	{
		return $this->_getUnitByMethod(__FUNCTION__);
	}

	/**
	 * Get unit used for {@link DataPoint\getPressure()}
	 * 
	 * @return string
	 */
	public function getPressureUnit()
	{
		return $this->_getUnitByMethod(__FUNCTION__);
	}

	/**
	 * Get unit used for {@link DataPoint\getVisibility()}
	 * 
	 * @return string
	 */
	public function getVisibilityUnit()
	{
		return $this->_getUnitByMethod(__FUNCTION__);
	}

	/**
	 * Get unit used for {@link DataPoint\getOzone()}
	 * 
	 * @return string
	 */
	public function getOzoneUnit()
	{
		return $this->_getUnitByMethod(__FUNCTION__);
	}

	/**
	 * Get unit for a method
	 * 
	 * @return string
	 */
	protected function _getUnitByMethod($method)
	{
		$units = $this->_getUnits();
		return $this->_unitsByMethod[$method][$units];
	}
	
}