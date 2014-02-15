<?php namespace Andreyco\Faceoff\Support\Laravel;

use ReflectionClass;
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
     * Guess the package path for the provider.
     *
     * @return string
     */
    public function guessPackagePath()
    {
        $path = with(new ReflectionClass($this))->getFileName();

        return realpath(dirname($path).'/../../../../');
    }

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
                $this->app->make('config')->get('faceoff::config'),
                $this->app->make('Andreyco\Faceoff\Support\Laravel\SessionProvider'));
        });
    }
}