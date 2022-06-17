<?php

namespace App\Repositories;

abstract class BaseRepository
{
    abstract function create(array $attributes);
    abstract function update($model, array $attributes);
    abstract function forceDelete($model);
}