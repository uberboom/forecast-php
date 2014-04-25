<?php namespace Uberboom\Forecast\Facades;

use Illuminate\Support\Facades\Facade;

class Forecast extends Facade
{
	/**
	 * Laravel facade accessor
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'forecast';
		// return '\Uberboom\Forecast\Forecast';
	}

}