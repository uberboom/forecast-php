<?php namespace Uberboom\Forecast;

abstract class DataAbstract
{
	/**
	 * Raw response from Forecast API
	 * 
	 * @var stdClass
	 */
	protected $_response;

	/**
	 * IANA timezone name for the requested location
	 * 
	 * @var string
	 */
	protected $_timezone;

	/**
	 * Constructor
	 * 
	 * @param  stdClass  $response  JSON response from Forecast API
	 * @param  string    $timezone  IANA timezone name for the requested location
	 */
	public function __construct(\stdClass $response, $timezone)
	{
		$this->_response = $response;
		$this->_timezone = $timezone;
	}

}