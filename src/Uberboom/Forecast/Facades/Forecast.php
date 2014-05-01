<?php

/**
 * Forecast.io package
 * 
 * PHP package to simplify Forecast.io API calls
 * 
 * @package  Forecast
 * @author   Bernd Ennsfellner <bernd@ennsfellner.at>
 */

namespace Uberboom\Forecast\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Laravel facade
 */
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