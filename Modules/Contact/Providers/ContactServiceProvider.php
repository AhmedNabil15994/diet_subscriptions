<?php

namespace Modules\Contact\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class ContactServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->publishes([
            __DIR__.'/../Database/Migrations/' => database_path('migrations'),
        ], 'modules-migrations');
    }

    /**
     * Register the contact provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path('Contact', 'Config/config.php') => config_path('contact.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('Contact', 'Config/config.php'),
            'contact'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/contact');

        $sourcePath = module_path('Contact', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/contact';
        }, \Config::get('view.paths')), [$sourcePath]), 'contact');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/contact');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'contact');
        } else {
            $this->loadTranslationsFrom(module_path('Contact', 'Resources/lang'), 'contact');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('Contact', 'Database/factories'));
        }
    }

    /**
     * Get the contacts provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
