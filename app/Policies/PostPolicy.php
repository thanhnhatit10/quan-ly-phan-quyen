<?php

namespace App\Policies;

use App\Models\Posts;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Nette\Utils\Json;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        // $roleJson = $user->group->permission;
        // if(!empty($roleJson)){
        //     $roleArr =  Json::decode($roleJson, true);
        //     $check = isRole($roleArr, 'posts');
        //     return $check;
        // }
        // return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Posts $posts)
    {
        
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        $roleJson = $user->group->permission;
        if(!empty($roleJson)){
            $roleArr =  Json::decode($roleJson, true);
            $check = isRole($roleArr, 'posts', 'add');
            return $check;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Posts $posts)
    {
        return $user->id === $posts->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Posts $posts)
    {
        return $user->id === $posts->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Posts $posts)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Posts $posts)
    {
        //
    }
}
