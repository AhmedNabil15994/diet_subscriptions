<?php

namespace Modules\Apps\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Apps\Components\Loaders\{PageLoader,BtnLoader,BallsLoader,SppinerLoader,Paginator};

class AppsServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerComponents();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();


        $this->loadMigrationsFrom(module_path('Apps', 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register components.
     *
     * @return void
     */
    protected function registerComponents()
    {
        //Loaders
        Blade::component('front-page-loader', PageLoader::class);
        Blade::component('front-btn-loader', BtnLoader::class);
        Blade::component('front-balls-loader', BallsLoader::class);
        Blade::component('front-sppiner-loader', SppinerLoader::class);
        Blade::component('front-paginator', Paginator::class);
        //////////////////////////
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path('Apps', 'Config/config.php') => config_path('apps.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('Apps', 'Config/config.php'),
            'apps'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {

        $viewPath = resource_path('views/modules/apps');

        $sourcePath = module_path('Apps', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/apps';
        }, \Config::get('view.paths')), [$sourcePath]), 'apps');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/apps');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'apps');
        } else {
            $this->loadTranslationsFrom(module_path('Apps', 'Resources/lang'), 'apps');
        }
    }

   


    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (!app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('Apps', 'Database/factories'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
