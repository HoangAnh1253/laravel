<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class UserRepository extends BaseRepository
{
    function create(array $attributes)
    {
        //return new Response(["data" => $attributes->is]);
        return DB::transaction(function () use ($attributes) {
            $created = User::create([
                'email' => data_get($attributes, 'email'),
                'password' => data_get($attributes, 'password'),
                'is_admin' => data_get($attributes, 'is_admin', false)
            ]);
            return $created;
        });
    }

    /**
     * @param User $user
     */
    function update($user, array $attributes)
    {
        return DB::transaction(function () use ($user, $attributes) {
            $updated = $user->update([
                'name' => data_get($attributes, 'name', $user->name),
                'gender' => data_get($attributes, 'gender', $user->gender),
                'birthdate' => data_get($attributes, 'birthdate', $user->birthdate),
                'password' => data_get($attributes, 'password', $user->password)
            ]);
            if (!$updated)
                throw new \Exception('Loi roi cha');
            return $user;
        });
    }

    function forceDelete($model)
    {
        return DB::transaction(function () use ($model) {
            $deleted = $model->forceDelete();
            if (!$deleted)
                throw new \Exception('Loi roi cha');
            return $model;
        });
    }

    function softDelete($model)
    {
        return DB::transaction(function () use ($model) {
            $deleted = $model->delete();
            if (!$deleted)
                throw new \Exception('Loi roi cha');
            return $model;
        });
    }
}