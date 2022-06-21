<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Equipment;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class EquipmentRepository extends BaseRepository
{
    function create(array $attributes)
    {
        //return new Response(["data" => $attributes->is]);
        return DB::transaction(function () use ($attributes) {
            $created = Equipment::create([
                'serial_number' => data_get($attributes, 'serial_number'),
                'name' => data_get($attributes, 'name'),
                'desc' => data_get($attributes, 'desc'),
                'status' => data_get($attributes, 'status'),
                'categories_id' => data_get($attributes, 'categories_id'),
                'users_id' => data_get($attributes, 'users_id', null)
            ]);
            
            return $created;
        });
    }

    /**
     * @param Equipment $equipment
     */
    function update($equipment, array $attributes)
    {
        return DB::transaction(function () use ($equipment, $attributes) {
            $users_id = data_get($attributes, 'users_id', '');
            $status = data_get($attributes, 'status', $equipment->status);
            if ($users_id != '')
                $status = 'used';
            $updated = $equipment->update([
                'name' => data_get($attributes, 'name', $equipment->name),
                'desc' => data_get($attributes, 'desc', $equipment->desc),
                'status' => $status,
                'users_id' =>  data_get($attributes, 'users_id', $equipment->users_id)
            ]);
            if (!$updated)
                throw new \Exception('Loi roi cha');
            return $equipment;
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