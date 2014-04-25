<?php namespace Uberboom\Forecast\CacheStore;

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