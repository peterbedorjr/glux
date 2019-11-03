<?php

namespace App\Providers;

use App\Models\Channel;
use App\Observers\ChannelObserver;
use Illuminate\Support\Facades\Route;
use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningUnitTests()) {
            Schema::defaultStringLength(191);
        }

        Channel::observe(ChannelObserver::class);

        Route::bind('channelId', function ($id) {
            return Channel::where('id', $id)
                ->with('conversation.messages.user')
                ->first() ?? abort(404);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }
}
