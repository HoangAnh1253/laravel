<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CategoryRepository implements BaseRepository
{
    function create(array $attributes)
    {
        //return new Response(["data" => $attributes->is]);
        return DB::transaction(function () use ($attributes) {
            $created = Category::create([
                'title' => data_get($attributes, 'title'),
            ]);
            return $created;
        });
    }

    /**
     * @param Category $category
     */
    function update($category, array $attributes)
    {
        return DB::transaction(function () use ($category, $attributes) {
            $updated = $category->update([
                'title' => data_get($attributes, 'title', $category->title, $category->title)
            ]);
            if (!$updated)
                throw new \Exception('Loi roi cha');
            return $category;
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