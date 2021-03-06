<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserRepository implements BaseRepository
{

    function getAllUser(){
        return User::get();
    }

    function getAllUserPaginate(int $paginate){
        return User::paginate($paginate);
    }

    function getUserWhere(string $field, $value){
        if($field != '')
        {
            return User::where($field, $value)->get();
        }
        return User::all();
    }

    function getUserWherePaginate(string $field, $value, int $paginate){
        if($field != '')
        {
            return User::where($field, $value)->paginate($paginate);
        }
        return User::paginate($paginate);
    }
    
    function create(array $attributes)
    {
       
        return DB::transaction(function () use ($attributes) {
            $created = User::create([
                'email' => data_get($attributes, 'email'),
                'name' => data_get($attributes, 'name'),
                'birthdate' => data_get($attributes, 'birthdate'),
                'gender' => data_get($attributes, 'gender'),
                'phone_number' => data_get($attributes, 'phone_number'),
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
                'email' => data_get($attributes, 'email', $user->email),
                'phone_number' => data_get($attributes, 'phone_number', $user->phone_number),
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