<?php

/**
 * Forecast.io package
 * 
 * PHP package to simplify Forecast.io API calls
 * 
 * @package  Forecast
 * @author   Bernd Ennsfellner <bernd@ennsfellner.at>
 */

namespace Uberboom\Forecast;

/**
 * Flag
 * 
 * Excerpt from the Forecast.io API documentation:
 * “The flags object contains various metadata information related to the request.”
 */
class DataFlag extends DataAbstract
{
	/**
	 * Indicates that the Dark Sky data source supports the given location, but a temporary error
	 * (such as a radar station being down for maintenance) has made the data unavailable.
	 * 
	 * @return string
	 */
	public function isDarkSkyUnavailable()
	{
		if (!property_exists($this->_response, 'darksky-unavailable')) {
			return false;
		}
		return $this->_response->{'darksky-unavailable'};
	}

	/**
	 * Returns true if radar stations are available.
	 * 
	 * @return boolean
	 */
	public function hasDarkSkyStations()
	{
		return property_exists($this->_response, 'darksky-stations');
	}

	/**
	 * Get IDs of radar stations utilized in servicing this request.
	 * 
	 * @return array
	 */
	public function getDarkSkyStations()
	{
		if (!$this->hasDarkSkyStations()) {
			return false;
		}
		return $this->_response->{'darksky-stations'};
	}

	/**
	 * Returns true if DataPoint stations are available.
	 * 
	 * @return boolean
	 */
	public function hasDataPointStations()
	{
		return property_exists($this->_response, 'datapoint-stations');
	}

	/**
	 * Get IDs of DataPoint stations utilized in servicing this request.
	 * (UK Met Office / Datapoint API)
	 * 
	 * @return array
	 */
	public function getDataPointStations()
	{
		if (!$this->hasDataPointStations()) {
			return false;
		}
		return $this->_response->{'datapoint-stations'};
	}

	/**
	 * Returns true if ISD stations are available.
	 * 
	 * @return boolean
	 */
	public function hasIsdStations()
	{
		return property_exists($this->_response, 'isd-stations');
	}

	/**
	 * Get IDs of ISD stations utilized in servicing this request.
	 * (USA NOAA / Integrated Surface Database)
	 * 
	 * @return array
	 */
	public function getIsdStations()
	{
		if (!$this->hasIsdStations()) {
			return false;
		}
		return $this->_response->{'isd-stations'};
	}

	/**
	 * Returns true if Madis stations are available.
	 * 
	 * @return boolean
	 */
	public function hasMadisStations()
	{
		return property_exists($this->_response, 'madis-stations');
	}

	/**
	 * Get IDs of Madis stations utilized in servicing this request.
	 * (USA NOAA/ESRL / Meteorological Assimilation Data Ingest System)
	 * 
	 * @return array
	 */
	public function getMadisStations()
	{
		if (!$this->hasMadisStations()) {
			return false;
		}
		return $this->_response->{'madis-stations'};
	}

	/**
	 * Returns true if LAMP stations are available.
	 * 
	 * @return boolean
	 */
	public function hasLampStations()
	{
		return property_exists($this->_response, 'lamp-stations');
	}

	/**
	 * Get IDs of LAMP stations utilized in servicing this request.
	 * (USA NOAA / Localized Aviation MOS Program)
	 * 
	 * @return array
	 */
	public function getLampStations()
	{
		if (!$this->hasLampStations()) {
			return false;
		}
		return $this->_response->{'lamp-stations'};
	}

	/**
	 * Returns true if METAR stations are available.
	 * 
	 * @return boolean
	 */
	public function hasMetarStations()
	{
		return property_exists($this->_response, 'metar-stations');
	}

	/**
	 * Get IDs of METAR stations utilized in servicing this request.
	 * 
	 * @return array
	 */
	public function getMetarStations()
	{
		if (!$this->hasMetarStations()) {
			return false;
		}
		return $this->_response->{'metar-stations'};
	}

	/**
	 * Returns true if api.met.no license is available.
	 * 
	 * @return boolean
	 */
	public function hasMetNoLicense()
	{
		return property_exists($this->_response, 'metno-license');
	}

	/**
	 * Indicates that data from api.met.no was utilized in order to facilitate this request (as per their license agreement).
	 * 
	 * @return string
	 */
	public function getMetNoLicense()
	{
		if (!$this->hasMetNoLicense()) {
			return false;
		}
		return $this->_response->{'metno-license'};
	}

	/**
	 * Returns true if sources are available.
	 * 
	 * @return boolean
	 */
	public function hasSources()
	{
		return property_exists($this->_response, 'sources');
	}

	/**
	 * Get IDs of data sources utilized in servicing this request.
	 * 
	 * @return array
	 */
	public function getSources()
	{
		if (!$this->hasSources()) {
			return false;
		}
		return $this->_response->sources;
	}

	/**
	 * Get unit used for the data in this request
	 * 
	 * @return string
	 */
	public function getUnits()
	{
		if (!property_exists($this->_response, 'units')) {
			return false;
		}
		return $this->_response->units;
	}

}