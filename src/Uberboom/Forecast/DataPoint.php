<?php namespace Uberboom\Forecast;

class DataPoint extends DataAbstract
{
	/**
	 * Icons used for machine-readable text summaries
	 * 
	 * (Developers should ensure that a sensible default is defined, as additional values,
	 * such as hail, thunderstorm, or tornado, may be defined in the future.)
	 * 
	 * @var string
	 */
	const ICON_CLEAR_DAY           = 'clear-day';
	const ICON_CLEAR_NIGHT         = 'clear-night';
	const ICON_RAIN                = 'rain';
	const ICON_SNOW                = 'snow';
	const ICON_SLEET               = 'sleet';
	const ICON_WIND                = 'wind';
	const ICON_FOG                 = 'fog';
	const ICON_CLOUDY              = 'cloudy';
	const ICON_PARTLY_CLOUDY–DAY   = 'partly-cloudy-day';
	const ICON_PARTLY_CLOUDY–NIGHT = 'partly-cloudy-night';

	/**
	 * Type of precipitation
	 *
	 * @var string
	 */
	const TYPE_PRECIP_RAIN = 'rain';
	const TYPE_PRECIP_SNOW = 'snow';
	const TYPE_PRECIP_SLEET = 'sleet';

	/**
	 * Get the UNIX time at which this data point occurs.
	 * 
	 * @return int
	 */
	public function getTime()
	{
		if (!property_exists($this->_response, 'time')) {
			return false;
		}
		return $this->_response->time;
	}

	/**
	 * Get a human-readable text summary of this data point.
	 * 
	 * @return string
	 */
	public function getSummary()
	{
		if (!property_exists($this->_response, 'summary')) {
			return false;
		}
		return $this->_response->summary;
	}

	/**
	 * Get a machine-readable text summary of this data point, suitable for selecting an icon for display.
	 * 
	 * (Developers should ensure that a sensible default is defined, as additional values,
	 * such as hail, thunderstorm, or tornado, may be defined in the future.)
	 * 
	 * @see DataPoint::ICON_*
	 * 
	 * @return string
	 */
	public function getIcon()
	{
		if (!property_exists($this->_response, 'icon')) {
			return false;
		}
		return $this->_response->icon;
	}

	/**
	 * Get the UNIX time of sunrise.
	 * 
	 * (Only defined on daily data points.)
	 * 
	 * (If no sunrise or sunset will occur on the given day, then the
	 * appropriate fields will be undefined. This can occur during
	 * summer and winter in very high or low latitudes.)
	 * 
	 * @return int
	 */
	public function getSunriseTime()
	{
		if (!property_exists($this->_response, 'sunriseTime')) {
			return false;
		}
		return $this->_response->sunriseTime;
	}

	/**
	 * Get the UNIX time of sunset.
	 * 
	 * (Only defined on daily data points.)
	 * 
	 * (If no sunrise or sunset will occur on the given day, then the
	 * appropriate fields will be undefined. This can occur during
	 * summer and winter in very high or low latitudes.)
	 * 
	 * @return int
	 */
	public function getSunsetTime()
	{
		if (!property_exists($this->_response, 'sunsetTime')) {
			return false;
		}
		return $this->_response->sunsetTime;
	}

	/**
	 * Get a number representing the fractional part of the lunation number of the given day.
	 * 
	 * (Only defined on daily data points.)
	 * 
	 * This can be thought of as the “percentage complete” of the current lunar month:
	 * a value of 0 represents a new moon, a value of 0.25 represents a first quarter moon,
	 * a value of 0.5 represents a full moon, and a value of 0.75 represents a last quarter moon.
	 * 
	 * (The ranges in between these represent waxing crescent, waxing gibbous, waning gibbous,
	 * and waning crescent moons, respectively.)
	 * 
	 * @return float
	 */
	public function getMoonPhase()
	{
		if (!property_exists($this->_response, 'moonPhase')) {
			return false;
		}
		return $this->_response->moonPhase;
	}

	/**
	 * Get a numerical value representing the distance to the nearest storm in miles.
	 * 
	 * (Only defined on currently data points).
	 * 
	 * (This value is very approximate and should not be used in scenarios requiring
	 * accurate results. In particular, a storm distance of zero doesn’t necessarily
	 * refer to a storm at the requested location, but rather a storm in the vicinity
	 * of that location.)
	 * 
	 * @return int
	 */
	public function getNearestStormDistance()
	{
		if (!property_exists($this->_response, 'nearestStormDistance')) {
			return false;
		}
		return $this->_response->nearestStormDistance;
	}

	/**
	 * Get a numerical value representing the direction of the nearest storm in degrees,
	 * with true north at 0° and progressing clockwise.
	 * 
	 * (Only defined on currently data points).
	 * 
	 * (If nearestStormDistance is zero, then this value will not be defined.
	 * The caveats that apply to nearestStormDistance also apply to this value.)
	 * 
	 * @return int
	 */
	public function getNearestStormBearing()
	{
		if (!property_exists($this->_response, 'nearestStormBearing')) {
			return false;
		}
		return $this->_response->nearestStormBearing;
	}

	/**
	 * Get a numerical value representing the average expected intensity (in inches
	 * of liquid water per hour) of precipitation occurring at the given time
	 * conditional on probability (that is, assuming any precipitation occurs at all).
	 * 
	 * A very rough guide is that a value of
	 * 0 in./hr. corresponds to no precipitation,
	 * 0.002 in./hr. corresponds to very light precipitation,
	 * 0.017 in./hr. corresponds to light precipitation,
	 * 0.1 in./hr. corresponds to moderate precipitation, and
	 * 0.4 in./hr. corresponds to heavy precipitation.
	 * 
	 * @return float
	 */
	public function getPrecipIntensity()
	{
		if (!property_exists($this->_response, 'precipIntensity')) {
			return false;
		}
		return $this->_response->precipIntensity;
	}

	/**
	 * Get a numerical value representing the maximum expected intensity of precipitation
	 * on the given day in inches of liquid water per hour.
	 * 
	 * (Only defined on daily data points.)
	 * 
	 * @see getPrecipIntensityMaxTime()
	 * 
	 * @return float
	 */
	public function getPrecipIntensityMax()
	{
		if (!property_exists($this->_response, 'precipIntensityMax')) {
			return false;
		}
		return $this->_response->precipIntensityMax;
	}

	/**
	 * Get the UNIX time at which the maximum expected intensity of precipitation occurs
	 * on the given day.
	 * 
	 * (Only defined on daily data points.)
	 * 
	 * @see getPrecipIntensityMax()
	 * 
	 * @return int
	 */
	public function getPrecipIntensityMaxTime()
	{
		if (!property_exists($this->_response, 'precipIntensityMaxTime')) {
			return false;
		}
		return $this->_response->precipIntensityMaxTime;
	}

	/**
	 * Get a numerical value between 0 and 1 (inclusive) representing the probability
	 * of precipitation occuring at the given time.
	 * 
	 * @return float
	 */
	public function getPrecipProbability()
	{
		if (!property_exists($this->_response, 'precipProbability')) {
			return false;
		}
		return $this->_response->precipProbability;
	}

	/**
	 * Get a string representing the type of precipitation occurring at the given time.
	 * 
	 * If defined, this property will have one of the following values: rain, snow, sleet
	 * (which applies to each of freezing rain, ice pellets, and “wintery mix”), or hail.
	 *
	 * (If precipIntensity is zero, then this property will not be defined.)
	 * 
	 * @see DataPoint::TYPE_PRECIP_*
	 * 
	 * @return string
	 */
	public function getPrecipType()
	{
		if (!property_exists($this->_response, 'precipType')) {
			return false;
		}
		return $this->_response->precipType;
	}

	/**
	 * Get the amount of snowfall accumulation expected to occur on the given day.
	 * 
	 * (Only defined on daily data points.)
	 * 
	 * (If no accumulation is expected,this property will not be defined.)
	 * 
	 * @return string
	 */
	public function getPrecipAccumulation()
	{
		if (!property_exists($this->_response, 'precipAccumulation')) {
			return false;
		}
		return $this->_response->precipAccumulation;
	}

	/**
	 * Get a numerical value representing the temperature at the given time in degrees Fahrenheit.
	 * 
	 * (Not defined on daily data points.)
	 * 
	 * @return string
	 */
	public function getTemperature()
	{
		if (!property_exists($this->_response, 'temperature')) {
			return false;
		}
		return $this->_response->temperature;
	}

	/**
	 * Get a numerical value representing the minimum temperature
	 * on the given time in degrees Fahrenheit.
	 * 
	 * (Only defined on daily data points.)
	 * 
	 * @see getTemperatureMinTime()
	 * 
	 * @return float
	 */
	public function getTemperatureMin()
	{
		if (!property_exists($this->_response, 'temperatureMin')) {
			return false;
		}
		return $this->_response->temperatureMin;
	}

	/**
	 * Get the UNIX time at which the minimum temperature occurs on the given day.
	 * 
	 * (Only defined on daily data points.)
	 * 
	 * @see getTemperatureMin()
	 * 
	 * @return int
	 */
	public function getTemperatureMinTime()
	{
		if (!property_exists($this->_response, 'temperatureMinTime')) {
			return false;
		}
		return $this->_response->temperatureMinTime;
	}

	/**
	 * Get a numerical value representing the maximum temperature
	 * on the given time in degrees Fahrenheit.
	 * 
	 * (Only defined on daily data points.)
	 * 
	 * @see getTemperatureMaxTime()
	 * 
	 * @return float
	 */
	public function getTemperatureMax()
	{
		if (!property_exists($this->_response, 'temperatureMax')) {
			return false;
		}
		return $this->_response->temperatureMax;
	}

	/**
	 * Get the UNIX time at which the maximum temperature occurs on the given day.
	 * 
	 * (Only defined on daily data points.)
	 * 
	 * @see getTemperatureMax()
	 * 
	 * @return int
	 */
	public function getTemperatureMaxTime()
	{
		if (!property_exists($this->_response, 'temperatureMaxTime')) {
			return false;
		}
		return $this->_response->temperatureMaxTime;
	}

	/**
	 * Get a numerical value representing the apparent (or “feels like”) temperature
	 * at the given time in degrees Fahrenheit.
	 * 
	 * (Not defined on daily data points.)
	 * 
	 * @return string
	 */
	public function getApparentTemperature()
	{
		if (!property_exists($this->_response, 'apparentTemperature')) {
			return false;
		}
		return $this->_response->apparentTemperature;
	}

	/**
	 * Get a numerical value representing the minimum apparent (or “feels like”) temperature
	 * on the given time in degrees Fahrenheit.
	 * 
	 * (Only defined on daily data points.)
	 * 
	 * @see getApparentTemperatureMinTime()
	 * 
	 * @return float
	 */
	public function getApparentTemperatureMin()
	{
		if (!property_exists($this->_response, 'apparentTemperatureMin')) {
			return false;
		}
		return $this->_response->apparentTemperatureMin;
	}

	/**
	 * Get the UNIX time at which the minimum apparent (or “feels like”) temperature
	 * occurs on the given day.
	 * 
	 * (Only defined on daily data points.)
	 * 
	 * @see getApparentTemperatureMin()
	 * 
	 * @return int
	 */
	public function getApparentTemperatureMinTime()
	{
		if (!property_exists($this->_response, 'apparentTemperatureMinTime')) {
			return false;
		}
		return $this->_response->apparentTemperatureMinTime;
	}

	/**
	 * Get a numerical value representing the maximum apparent (or “feels like”) temperature
	 * on the given time in degrees Fahrenheit.
	 * 
	 * (Only defined on daily data points.)
	 * 
	 * @see getApparentTemperatureMaxTime()
	 * 
	 * @return float
	 */
	public function getApparentTemperatureMax()
	{
		if (!property_exists($this->_response, 'apparentTemperatureMax')) {
			return false;
		}
		return $this->_response->apparentTemperatureMax;
	}

	/**
	 * Get the UNIX time at which the maximum apparent (or “feels like”) temperature
	 * occurs on the given day.
	 * 
	 * (Only defined on daily data points.)
	 * 
	 * @see getApparentTemperatureMax()
	 * 
	 * @return int
	 */
	public function getApparentTemperatureMaxTime()
	{
		if (!property_exists($this->_response, 'apparentTemperatureMaxTime')) {
			return false;
		}
		return $this->_response->apparentTemperatureMaxTime;
	}

	/**
	 * Get a numerical value representing the dew point at the given time in degrees Fahrenheit.
	 * 
	 * @return float
	 */
	public function getDewPoint()
	{
		if (!property_exists($this->_response, 'dewPoint')) {
			return false;
		}
		return $this->_response->dewPoint;
	}

	/**
	 * Get a numerical value representing the wind speed in miles per hour.
	 * 
	 * @see getWindBearing()
	 * 
	 * @return float
	 */
	public function getWindSpeed()
	{
		if (!property_exists($this->_response, 'windSpeed')) {
			return false;
		}
		return $this->_response->windSpeed;
	}

	/**
	 * Get a numerical value representing the direction that the wind is coming from in degrees,
	 * with true north at 0° and progressing clockwise.
	 * 
	 * (If windSpeed is zero, then this value will not be defined.)
	 * 
	 * @see getWindSpeed()
	 * 
	 * @return int
	 */
	public function getWindBearing()
	{
		if (!property_exists($this->_response, 'windBearing')) {
			return false;
		}
		return $this->_response->windBearing;
	}

	/**
	 * Get a numerical value between 0 and 1 (inclusive) representing the percentage of sky
	 * occluded by clouds.
	 * 
	 * A value of 0 corresponds to clear sky, 0.4 to scattered clouds, 0.75 to broken cloud cover,
	 * and 1 to completely overcast skies.
	 * 
	 * @return float
	 */
	public function getCloudCover()
	{
		if (!property_exists($this->_response, 'cloudCover')) {
			return false;
		}
		return $this->_response->cloudCover;
	}

	/**
	 * Get a numerical value between 0 and 1 (inclusive) representing the relative humidity.
	 * 
	 * @return float
	 */
	public function getHumidity()
	{
		if (!property_exists($this->_response, 'humidity')) {
			return false;
		}
		return $this->_response->humidity;
	}

	/**
	 * Get a numerical value representing the sea-level air pressure in millibars.
	 * 
	 * @return float
	 */
	public function getPressure()
	{
		if (!property_exists($this->_response, 'pressure')) {
			return false;
		}
		return $this->_response->pressure;
	}

	/**
	 * Get a numerical value representing the average visibility in miles, capped at 10 miles.
	 * 
	 * @return float
	 */
	public function getVisibility()
	{
		if (!property_exists($this->_response, 'visibility')) {
			return false;
		}
		return $this->_response->visibility;
	}

	/**
	 * Get a numerical value representing the columnar density of 
	 * total atmospheric ozone at the given time in Dobson units.
	 * 
	 * @return float
	 */
	public function getOzone()
	{
		if (!property_exists($this->_response, 'ozone')) {
			return false;
		}
		return $this->_response->ozone;
	}
	
	/**
	 * Method overloading to get error values associated with numeric, non-time fields.
	 * 
	 * For example use getPrecipIntensityError to return the error value
	 * for the expected precipitation intensity.
	 * 
	 * All of the above numeric, non-time fields may, optionally, have an associated
	 * Error value defined with the property precipIntensityError, windSpeedError,
	 * pressureError, etc.), representing our system’s in its prediction. Such properties
	 * represent standard deviations of the value of their associated property; small error
	 * values therefore represent a strong confidence, while large error values represent a
	 * weak confidence. These properties are omitted where the confidence is not precisely
	 * known (though generally considered to be adequate).
	 * 
	 * @return float
	 */
	public function __call($name, array $arguments)
	{
		if (strpos($name, 'Time') !== false) {
			throw new \Uberboom\Forecast\Exception('Time fields have no associated error value');
		}
		if (strpos($name, 'get') !== 0) {
			throw new \Uberboom\Forecast\Exception('Method not supported: ' . $name);
		}

		// handle error methods: e.g. getPrecipIntensityError()
		$method = preg_replace('/Error$/ui', '', $name);
		$property = lcfirst(preg_replace('/get([a-zA-Z]*Error)$/ui', '$1', $name));
		if (method_exists($this, $method)) {
			if (!property_exists($this->_response, $property)) {
				return false;
			}
			return $this->_response->$property;
		} else {
			throw new \Uberboom\Forecast\Exception('Method does not exist: ' . $name);
		}

	}
	
	/**
	 * Property overloading to use method shortcuts
	 * 
	 * For example use humidity to call getHumidity()
	 * 
	 * @return mixed
	 */
	public function __get($name)
	{
		$method = 'get' . $name;
		if (!method_exists($this, $method)) {
			throw new \Uberboom\Forecast\Exception('Property does not exist: ' . $name);
		}
		return $this->$method();
	}

}