<?php

namespace App\Providers;

use App\Http\Clients\QuestionClient;
use Illuminate\Support\ServiceProvider;

class QuestionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(QuestionClient::class, function () {
            return new QuestionClient([
                'base_uri' => 'https://opentdb.com',
            ]);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
