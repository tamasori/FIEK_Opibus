<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Event;
use Logs;
use Auth;

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
        Event::listen('eloquent.created: *', function ($event, $model) {
            if(!property_exists($model[0], "NoLog") && Auth::check()){
                Logs::create(array(
                    "user_id" => Auth::User()->id,
                    "connected_id" => $model[0]->id,
                    "message" => "New: ". get_class($model[0]),
                    "new" => $model[0]->toJson(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                    "old" => "",
                    "ip_address" => request()->ip()
                ));
            }
        });

        Event::listen('eloquent.updating: *', function ($event, $model) {
            if(!property_exists($model[0], "NoLog") && Auth::check()){

                $new = $model[0];
                $old_data = $model[0]->getOriginal();
                
                $class_name =get_class($model[0]); 
                $model = new $class_name;
                $old= $model->newInstance($old_data);
                Logs::create(array(
                    "user_id" => Auth::User()->id,
                    "connected_id" => $new->id,
                    "message" => "Updated: ". get_class($old),
                    "old" => $old->toJson(JSON_UNESCAPED_UNICODE),
                    "new" => $new->toJson(JSON_UNESCAPED_UNICODE),
                    "ip_address" => request()->ip()
                ));
            }
        });

        Event::listen('eloquent.deleted: *', function ($event, $model) {
            if(!property_exists($model[0], "NoLog")){
                Logs::create(array(
                    "user_id" => Auth::User()->id,
                    "connected_id" => $model[0]->id,
                    "message" => "Deleted: ". get_class($model[0]),
                    "new" => "",
                    "old" => $model[0]->toJson(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                    "ip_address" => request()->ip()
                ));
            }
        });
    }
}
