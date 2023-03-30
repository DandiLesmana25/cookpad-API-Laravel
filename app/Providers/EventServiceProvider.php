<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Models\User;  //call user model
use App\Observers\UserObserver;  //call observer UserOBserver

use App\Models\Recipe;         //call recipe model
use App\Models\Ingredient;      //call ingredient model
use App\Models\Tool;             //call Tool model

use App\Observers\RecipeObserver;           //call recipe observers
use App\Observers\IngredientObserver;
use App\Observers\ToolObserver;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
        User::observe(UserObserver::class); // register user observer in here
        Recipe::observe(RecipeObserver::class); // register Recipe observer in here
        Tool::observe(ToolObserver::class); // register Tool observer in here
        Ingredient::observe(IngredientObserver::class); 
    }
}
