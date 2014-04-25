<?php namespace Uberboom\Forecast\CacheStore;

class IlluminateCache implements CacheStoreInterface
{
	/**
	 * Determine if an item exists in the cache.
	 *
	 * @param  string  $key
	 * 
	 * @return bool
	 */
	public function has($key)
	{
		return \Cache::has($key);
	}

	/**
	 * Retrieve an item from the cache by key.
	 *
	 * @param  string  $key
	 * 
	 * @return mixed
	 */
	public function get($key)
	{
		return \Cache::get($key);
	}

	/**
	 * Store an item in the cache.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @param  \DateTime|int  $minutes
	 * 
	 * @return void
	 */
	public function put($key, $value, $minutes)
	{
		return \Cache::put($key, $value, $minutes);
	}

}