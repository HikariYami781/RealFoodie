<?php

namespace App\Providers;

//use App\Models\Receta;
//use App\Policies\RecetaPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /*protected $policies = [
        Receta::class => RecetaPolicy::class,
    ];*/

    public function boot()
    {
        $this->registerPolicies();
    }
}
