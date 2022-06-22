<?php

namespace App\Repositories;

interface  BaseRepository
{
     function create(array $attributes);
     function update($model, array $attributes);
     function forceDelete($model);
}