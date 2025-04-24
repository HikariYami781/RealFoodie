<?php
namespace App\Policies;

use App\Models\Receta;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecetaPolicy
{
    use HandlesAuthorization;

    public function create($user)
    {
        return true;
    }


    public function update(User $user, Receta $receta)
    {
        return $user->id === $receta->user_id;
    }

    public function delete(User $user, Receta $receta)
    {
        return $user->id === $receta->user_id;
    }
}