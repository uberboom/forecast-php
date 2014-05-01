<?php

/**
 * Forecast.io package
 * 
 * PHP package to simplify Forecast.io API calls
 * 
 * @package  Forecast
 * @author   Bernd Ennsfellner <bernd@ennsfellner.at>
 */

namespace Uberboom\Forecast\CacheStore;

/**
 * Interface for the cache store optionally used by the Forecast package
 */
interface CacheStoreInterface
{
	/**
	 * Determine if an item exists in the cache.
	 *
	 * @param  string  $key
	 * 
	 * @return bool
	 */
	public function has($key);

	/**
	 * Retrieve an item from the cache by key.
	 *
	 * @param  string  $key
	 * 
	 * @return mixed
	 */
	public function get($key);

	/**
	 * Store an item in the cache.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @param  \DateTime|int  $minutes
	 * 
	 * @return void
	 */
	public function put($key, $value, $minutes);

}