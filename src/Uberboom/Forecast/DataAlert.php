<?php namespace Uberboom\Forecast;

class DataAlert extends DataAbstract
{
	/**
	 * Get a short text summary of the alert.
	 * 
	 * @return string
	 */
	public function getTitle()
	{
		if (!property_exists($this->_response, 'title')) {
			return false;
		}
		return $this->_response->title;
	}

	/**
	 * Get the UNIX time at which the alert will cease to be valid.
	 * 
	 * @return int
	 */
	public function getExpires()
	{
		if (!property_exists($this->_response, 'expires')) {
			return false;
		}
		return $this->_response->expires;
	}

	/**
	 * Get a detailed text description of the alert from the appropriate weather service.
	 * 
	 * @return string
	 */
	public function getDescription()
	{
		if (!property_exists($this->_response, 'description')) {
			return false;
		}
		return $this->_response->description;
	}

	/**
	 * Get an HTTP(S) URI that contains detailed information about the alert.
	 * 
	 * @return string
	 */
	public function getUri()
	{
		if (!property_exists($this->_response, 'uri')) {
			return false;
		}
		return $this->_response->uri;
	}

}