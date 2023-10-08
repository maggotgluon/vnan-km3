<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

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
        //
        
        Gate::define('toggle', function(User $user) {
            boo:$can=false;
            $can = $user->id==103;
            // dd($user->id==103,$can);
            // dd($can);
            return $can;
        });

        Gate::define('edit_document', function(User $user) {

            boo:$can=false;
            // 2,3,4,5,6,7,99
            $can = $user->user_level->value >= 2 
                || $user->user_level->value == 99
                || $user->permissions->where('allowance',1)->contains('parmission_name','admin');
            // dd($user->user_level->value);
            return $can;
        });
        Gate::define('edit_trainDocument', function(User $user) {

            boo:$can=false;
            // 2,3,4,5,6,7,99
            $can = $user->user_level->value >= 2 
                || $user->user_level->value == 99
                || $user->permissions->where('allowance',1)->contains('parmission_name','admin');

            return $can;
        });
        Gate::define('review_document', function(User $user) {

            boo:$can=false;
            // 6,7
            $can = $user->user_level->value == 6 
                || $user->user_level->value == 99
                || $user->permissions->where('allowance',1)->contains('parmission_name','admin');

            return $can;
        });
        Gate::define('review_trainDocument', function(User $user) {

            boo:$can=false;
            // 6,7
            $can = $user->user_level->value == 4 
                || $user->user_level->value == 99
                || $user->permissions->where('allowance',1)->contains('parmission_name','admin');

            return $can;
        });
        Gate::define('publish_document', function(User $user) {

            boo:$can=false;
            // 4,6
            $can = $user->user_level->value == 7 
                || $user->user_level->value == 99
                || $user->permissions->where('allowance',1)->contains('parmission_name','admin');

            return $can;
        });

        Gate::define('publish_trainDocument', function(User $user) {

            boo:$can=false;
            // 4,6
            $can = $user->user_level->value == 5 
                || $user->user_level->value == 99
                || $user->permissions->where('allowance',1)->contains('parmission_name','admin');

            return $can;
        });


        Gate::define('reject_document', function(User $user) {

            boo:$can=false;
            // 4,6
            $can = $user->user_level->value == 5 || $user->user_level->value == 7
                || $user->user_level->value == 99
                || $user->permissions->where('allowance',1)->contains('parmission_name','admin');

            return $can;
        });

        Gate::define('reject_training', function(User $user) {

            boo:$can=false;
            // 4,6
            $can = $user->user_level->value == 4 || $user->user_level->value == 6
                || $user->user_level->value == 99
                || $user->permissions->where('allowance',1)->contains('parmission_name','admin');

            return $can;
        });
        Gate::define('view_log', function(User $user) {

            boo:$can=false;
            // 4,6
            $can = $user->user_level->value == 4 || $user->user_level->value == 6
                || $user->user_level->value == 5 || $user->user_level->value == 7 
                || $user->user_level->value == 99
                || $user->permissions->where('allowance',1)->contains('parmission_name','admin');

            return $can;
        });
        Gate::define('manage_users', function(User $user) {

            boo:$can=false;
            // 4,6
            $can = $user->user_level->value == 4 
                || $user->user_level->value == 6
                || $user->user_level->value == 99
                || $user->permissions->where('allowance',1)->contains('parmission_name','admin');

            return $can;
        });
    }
}
