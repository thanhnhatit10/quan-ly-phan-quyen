<?php

namespace App\Providers;

use App\Models\Groups;
use App\Models\User;
use App\Models\Posts;
use Nette\Utils\Json;
use App\Models\Modules;
use App\Policies\GroupsPolicy;
use App\Policies\PostPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Posts::class => PostPolicy::class,
        User::class => UserPolicy::class,
        Groups::class => GroupsPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        /**
         * users.view 
         * Lấy danh sách module
         * 
         */
        $moduleList =  Modules::all();
        if($moduleList->count() >0){
            foreach ($moduleList as $module) {
                Gate::define($module->name, function(User $user) use ($module){
                    $roleJson = $user->group->permission;
                    if(!empty($roleJson)){
                        $roleArr = Json::decode($roleJson, true);
                        $check = isRole($roleArr, $module->name);
                        return $check;
                    }
                    return false;
                });

                Gate::define($module->name.'.edit', function(User $user) use ($module){
                    $roleJson = $user->group->permission;
                    if(!empty($roleJson)){
                        $roleArr = Json::decode($roleJson, true);
                        $check = isRole($roleArr, $module->name, 'edit');
                        return $check;
                    }
                    return false;
                });
                Gate::define($module->name.'.delete', function(User $user) use ($module){
                    $roleJson = $user->group->permission;
                    if(!empty($roleJson)){
                        $roleArr = Json::decode($roleJson, true);
                        $check = isRole($roleArr, $module->name, 'delete');
                        return $check;
                    }
                    return false;
                });
                Gate::define($module->name.'.permission', function(User $user) use ($module){
                    $roleJson = $user->group->permission;
                    if(!empty($roleJson)){
                        $roleArr = Json::decode($roleJson, true);
                        $check = isRole($roleArr, $module->name, 'permission');
                        return $check;
                    }
                    return false;
                });
            }
        }
        
    }
}
