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
                'base_uri' => 'http://trivia.propernerd.com/api/questions',
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
