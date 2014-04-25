<?php namespace Uberboom\Forecast;

class DataFlag
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
	 * Get IDs of radar stations utilized in servicing this request.
	 * 
	 * @return array
	 */
	public function getDarkSkyStations()
	{
		if (!property_exists($this->_response, 'darksky-stations')) {
			return false;
		}
		return $this->_response->{'darksky-stations'};
	}

	/**
	 * Get IDs of DataPoint stations utilized in servicing this request.
	 * (UK Met Office / Datapoint API)
	 * 
	 * @return array
	 */
	public function getDataPointStations()
	{
		if (!property_exists($this->_response, 'datapoint-stations')) {
			return false;
		}
		return $this->_response->{'datapoint-stations'};
	}

	/**
	 * Get IDs of ISD stations utilized in servicing this request.
	 * (USA NOAA / Integrated Surface Database)
	 * 
	 * @return array
	 */
	public function getIsdStations()
	{
		if (!property_exists($this->_response, 'isd-stations')) {
			return false;
		}
		return $this->_response->{'isd-stations'};
	}

	/**
	 * Get IDs of Madis stations utilized in servicing this request.
	 * (USA NOAA/ESRL / Meteorological Assimilation Data Ingest System)
	 * 
	 * @return array
	 */
	public function getMadisStations()
	{
		if (!property_exists($this->_response, 'madis-stations')) {
			return false;
		}
		return $this->_response->{'madis-stations'};
	}

	/**
	 * Get IDs of LAMP stations utilized in servicing this request.
	 * (USA NOAA / Localized Aviation MOS Program)
	 * 
	 * @return array
	 */
	public function getLampStations()
	{
		if (!property_exists($this->_response, 'lamp-stations')) {
			return false;
		}
		return $this->_response->{'lamp-stations'};
	}

	/**
	 * Get IDs of METAR stations utilized in servicing this request.
	 * 
	 * @return array
	 */
	public function getMetarStations()
	{
		if (!property_exists($this->_response, 'metar-stations')) {
			return false;
		}
		return $this->_response->{'metar-stations'};
	}

	/**
	 * Indicates that data from api.met.no was utilized in order to facilitate this request (as per their license agreement).
	 * 
	 * @return string
	 */
	public function getMetNoLicense()
	{
		if (!property_exists($this->_response, 'metno-license')) {
			return false;
		}
		return $this->_response->{'metno-license'};
	}

	/**
	 * Get IDs of data sources utilized in servicing this request.
	 * 
	 * @return array
	 */
	public function getSources()
	{
		if (!property_exists($this->_response, 'sources')) {
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