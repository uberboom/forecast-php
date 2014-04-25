<?php namespace Uberboom\Forecast;

use Illuminate\Support\ServiceProvider;

class ForecastServiceProvider extends ServiceProvider
{

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('uberboom/forecast');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('forecast', 'Uberboom\Forecast\Forecast');
		
		// bind the laravel cache
        $this->app->bind('Uberboom\Forecast\CacheStore\CacheStoreInterface', 'Uberboom\Forecast\CacheStore\IlluminateCache');

	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		die(__METHOD__);
		return array('forecast');
	}

}
