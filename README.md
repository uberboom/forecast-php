forecast-php
============

Forecast.io API for PHP

* Framework agnostic
* Built in Laravel support
* Cache support to reduce API calls
* Provide your own cache store and http client, if required


## Setup for Laravel 4


### App Configuration

You can register the ForecastServiceProvider to automatically use the Laravel built in cache functionality.

To do so, update the `providers` array in your `app/config/app.php`:

```php
'providers' => array(
	// ...
	'Uberboom\Forecast\ForecastServiceProvider',
),
```

Next, update the class aliases in the `aliases` array in your `app/config/app.php`:

```php
'providers' => array(
	// ...
	'Forecast' => 'Uberboom\Forecast\Facades\Forecast',
),
```


### Configuration

First, publish the configuration from the package:

```php
php artisan config:publish uberboom/forecast
```

#### API Key

Get an API key at [Forecast for Developers](https://developer.forecast.io) and add the API key to the `app/config/packages/uberboom/forecast/config.php` file:

```php
'api_key' => 'your-api-key-from-developer.forecast.io',
```

#### Configuring the HTTP Client

The package includes two difference HTTP client implementations: One is using the [PHP Curl extension](http://www.php.net/manual/book.curl.php), the other one relies on `file_get_contents`, so make sure that [`allow_url_fopen`](http://www.php.net/manual/filesystem.configuration.php#ini.allow-url-fopen) is enabled in your php.ini file.

```php
'httpclient' => 'curl|file',
```


### Retrieve the Weather Forecast

The package provides some Laravel Facade magic, so fetching the weather forecast is a piece of cake:

```php
$weather = \Forecast::getWeatherByLocation($latitude, $longitude);
```



## Not Using Laravel?


### Manual Configuration

If you are not using Laravel, you have to set the API key manually:

```php
$forecastApiKey = 'your-api-key-from-developer.forecast.io';
$forecast = new \Uberboom\Forecast\Forecast();
$forecast->setApiKey($forecastApiKey);
```


### Setting the HTTP Client

The package includes two difference HTTP client implementations: One is using the [PHP Curl extension](http://www.php.net/manual/book.curl.php), the other one relies on `file_get_contents`, so make sure that [`allow_url_fopen`](http://www.php.net/manual/filesystem.configuration.php#ini.allow-url-fopen) is enabled in your php.ini file.

```php
$forecast->setHttpClientWrapper(new \Uberboom\Forecast\HttpClient\Curl());
$forecast->setHttpClientWrapper(new \Uberboom\Forecast\HttpClient\File());
```


### Cache

Currently, the package only includes an implementation for the Laravel framework. If you want to use the package’s cache functionality, you need to build and inject your own cache store class, which has to implement the `\Uberboom\Forecast\CacheStore\CacheStoreInterface` interface.

```php
$forecast->setCacheStore(new YourCacheStore());
```
