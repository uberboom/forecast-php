<?php namespace Uberboom\Forecast;

class DataBlock extends DataAbstract
{
	/**
	 * Get a human-readable text summary of this data block.
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
	 * Get a machine-readable text summary of this data block.
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
	 * Get an array of data point objects, ordered by time, which together describe
	 * the weather conditions at the requested location over time.
	 *
	 * @return \Uberboom\Forecast\DataPoint[]
	 */
	public function data()
	{
		if (!property_exists($this->_response, 'data')) {
			return false;
		}
		$data = array();
		foreach ($this->_response->data as $item) {
			$data[] = new DataPoint($item, $this->_timezone);
		}
	    return $data;
	}

}