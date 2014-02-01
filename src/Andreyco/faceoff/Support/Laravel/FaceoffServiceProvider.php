<?php namespace Andreyco\Faceoff\Support\Laravel;

use Andreyco\Faceoff\Faceoff;
use Illuminate\Support\ServiceProvider;

class FaceoffServiceProvider extends ServiceProvider
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
        $this->package('andreyco/faceoff');
    }

    public function register()
    {
        $this->app->bind('faceoff', function()
        {
            return new Faceoff(
                $this->app->make('config')->get('faceoff::init'),
                $this->app->make('\Andreyco\Faceoff\DataProviders\LaravelSessionProvider'));
        });
    }
}