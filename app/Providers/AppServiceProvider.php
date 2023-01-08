<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerMorphMaps();

        \View::composer('*', function ($view) {
            if ($authUser = auth()->user()) {
                $view->with('authUser', $authUser);
            }
        });

        /*DB Info in Log*/
        $this->logQueryIntoLogFile();
    }

    public function registerMorphMaps()
    {
        Relation::morphMap([
            // 'Product' => \App\Models\Product::class,
            // 'MasterOrder' => \App\Models\MasterOrder::class
        ]);
    }

    public function logQueryIntoLogFile()
    {
        \DB::listen(function ($query) {
            \Log::info(
                $query->sql, $query->bindings, $query->time
            );
        });
    }
}
